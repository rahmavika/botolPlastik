<?php

namespace App\Http\Controllers;

use App\Models\Logstok;
use App\Models\Checkout;
use App\Models\Keranjang;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showPesanan(Request $request)
    {
        $status = $request->get('status', 'menunggu_konfirmasi'); // default status
        $checkouts = Checkout::where('status', $status)
                            ->latest()
                            ->paginate(10);

        return view('pesanans.index', compact('checkouts', 'status'));
    }

    public function confirm(Request $request, $id)
    {
        $checkout = Checkout::findOrFail($id);
        $checkout->status = 'menunggu_konfirmasi';
        $checkout->catatan_admin = $request->input('catatan_admin');
        $checkout->save();

        if ($request->user()->role === 'admin') {
            return redirect()->route('pesanans.index')
                ->with('success', 'Pesanan berhasil dikonfirmasi.');
        }

        abort(403, 'Anda tidak memiliki akses untuk melakukan aksi ini.');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $checkout = Checkout::findOrFail($id);
        $checkout->status = $request->status;
        $checkout->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

        public function updatePembayaran(Request $request, $id)
    {
        $checkout = Checkout::findOrFail($id);
        $checkout->status_pembayaran = $request->status_pembayaran;
        $checkout->save();

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|max:255',
            'metode_pembayaran' => 'required|string',
            'total_harga' => 'required|numeric|min:0',
            'courier' => 'nullable|string',
            'service' => 'nullable|string',
            'ongkir' => 'nullable|numeric'
        ]);

        $user = Auth::user();
        $selectedIds = $request->selected_items;

        $keranjangs = Keranjang::with('produk')
            ->where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.show')->with('error', 'Keranjang Anda kosong!');
        }

        $totalHargaProduk = $keranjangs->sum(fn($k) => $k->jumlah * $k->harga);
        $ongkir = $request->ongkir ?? 0;
        $totalAkhir = $totalHargaProduk + $ongkir;

        $produkDetails = $keranjangs->map(function ($item) {
            return [
                'nama' => $item->produk->nama_produk,
                'jumlah' => $item->jumlah,
                'harga' => $item->harga,
                'total' => $item->jumlah * $item->harga,
            ];
        })->toArray();

        $checkout = Checkout::create([
            'user_id' => $user->id,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'courier' => $request->courier,
            'service' => $request->service,
            'ongkir' => $ongkir,
            'total_harga' => $totalAkhir,
            'produk_details' => $produkDetails,
            'tanggal_pemesanan' => now(),
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'belum_lunas',
            'status' => 'menunggu_konfirmasi',
        ]);

        foreach ($keranjangs as $item) {
            $stok = Stok::where('produk_id', $item->produk_id)->first();

            if ($stok) {
                $stok->jumlah_stok -= $item->jumlah;
                if ($stok->jumlah_stok < 0) {
                    $stok->jumlah_stok = 0;
                }
                $stok->save();
            }

            Logstok::create([
                'tanggal' => now(),
                'produk_id' => $item->produk_id,
                'tipe' => 'keluar',
                'jumlah' => $item->jumlah,
                'keterangan' => 'penjualan',
                'created_by' => $user->id,
            ]);
        }

        Keranjang::whereIn('id', $selectedIds)->delete();

        return redirect()->route('checkout.detail', $checkout->id)
            ->with('success', 'Checkout berhasil dibuat.');
    }

    public function show(Request $request)
    {
        $user = Auth::user();

        $selectedIds = $request->selected_items;

        // VALIDASI
        if (!$selectedIds) {
            return redirect()->route('keranjang.show')
                ->with('error', 'Pilih minimal 1 produk!');
        }

        // AMBIL HANYA YANG DICENTANG
        $keranjangs = Keranjang::with(['produk.stok'])
            ->where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.show')
                ->with('error', 'Data tidak ditemukan!');
        }

        // CEK STOK
        foreach ($keranjangs as $item) {
            $stok = $item->produk->stok;
            $sisaStok = $stok->jumlah_stok ?? 0;

            if ($item->jumlah > $sisaStok) {
                return redirect()->route('keranjang.show')->with(
                    'error',
                    "Stok {$item->produk->nama_produk} tidak mencukupi. Sisa stok: {$sisaStok}"
                );
            }
        }

        $totalHargaProduk = $keranjangs->sum(fn($k) => $k->jumlah * $k->harga);

        return view('landingpage.pelanggan.checkout', compact('user', 'keranjangs', 'totalHargaProduk'));
    }


    public function detail($id)
    {
        $checkout = Checkout::with('user')->findOrFail($id);
        $produkDetails = $checkout->produk_details ?? [];

        $totalBelanja = collect($produkDetails)->sum(function ($p) {
            return $p['total'];
        });

        return view('landingpage.pelanggan.detailPesanan', [
            'checkout'        => $checkout,
            'produkDetails'   => $produkDetails,
            'totalBelanja'    => $totalBelanja,
            'totalHargaAkhir' => $totalBelanja,
        ]);
    }
}