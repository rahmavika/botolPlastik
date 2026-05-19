<?php

namespace App\Http\Controllers;

use App\Models\Logstok;
use App\Models\Checkout;
use App\Models\Keranjang;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
    $checkout = Checkout::findOrFail($id);

    $nama = $checkout->nama_pelanggan
        ?? optional($checkout->user)->name
        ?? 'Customer';

    $phone = $checkout->phone
        ?? $checkout->no_hp
        ?? optional($checkout->user)->phone
        ?? null;

    $pengiriman = $checkout->metode_pengiriman;
    $invoice = 'INV-' . str_pad($checkout->id, 5, '0', STR_PAD_LEFT);

    /*
    |--------------------------------------------------------------------------
    | FORMAT PESAN WHATSAPP
    |--------------------------------------------------------------------------
    */

    // STATUS DIPROSES
    if ($request->status == 'diproses') {

        // DELIVERY
        if ($pengiriman == 'delivery') {

            $message =
"*Botol Plastik Riau*

Yth. {$nama},

Pesanan Anda telah kami terima dan saat ini sedang diproses oleh tim kami.

📦 *Detail Pesanan*
• No. Pesanan : {$invoice}
• Status : Diproses
• Pengiriman : Delivery Toko

Pesanan akan segera kami siapkan untuk proses pengiriman.

Terima kasih telah berbelanja di Botol Plastik Riau.";

        }

        // AMBIL DI TOKO
        else {

            $message =
"*Botol Plastik Riau*

Yth. {$nama},

Pesanan Anda telah kami terima dan saat ini sedang diproses oleh tim kami dan dapat diambil nanti di toko.

📦 *Detail Pesanan*
• No. Pesanan : {$invoice}
• Status : Diproses
• Pengiriman : Ambil di Toko

Terima kasih telah berbelanja di Botol Plastik Riau.";

        }
    }

    // STATUS DIKIRIM
    elseif ($request->status == 'dikirim') {

        $message =
"*Botol Plastik Riau*

Yth. {$nama},

Pesanan Anda saat ini sedang dalam proses pengiriman.

📦 *Detail Pesanan*
• No. Pesanan : {$invoice}
• Status : Dikirim
• Pengiriman : Delivery Toko

Mohon menunggu hingga pesanan diterima.

Terima kasih atas kepercayaan Anda kepada Botol Plastik Riau.";

    }

    // STATUS SELESAI
    elseif ($request->status == 'selesai') {

        // DELIVERY
        if ($pengiriman == 'delivery') {

            $message =
"*Botol Plastik Riau*

Yth. {$nama},

Pesanan Anda telah selesai dan diterima.

📦 *Detail Pesanan*
• No. Pesanan : {$invoice}
• Status : Selesai
• Pengiriman : Delivery Toko

Terima kasih telah berbelanja dan mempercayai layanan kami.";

        }

        // AMBIL DI TOKO
        else {

            $message =
"*Botol Plastik Riau*

Yth. {$nama},

Pesanan Anda telah selesai dan sudah diambil di toko.

📦 *Detail Pesanan*
• No. Pesanan : {$invoice}
• Status : Selesai
• Pengiriman : Ambil di Toko

Terima kasih telah berbelanja dan mempercayai layanan kami.";

        }
    }

    // DEFAULT
    else {

        $message =
"*Botol Plastik Riau*

Yth. {$nama},

Status pesanan Anda telah diperbarui.

Terima kasih.";
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS DULU
    |--------------------------------------------------------------------------
    */

    $checkout->status = $request->status;
    $checkout->save();

    /*
    |--------------------------------------------------------------------------
    | JIKA TIDAK ADA NOMOR → LANGSUNG KEMBALI
    |--------------------------------------------------------------------------
    */

    if (!$phone) {

        return back()->with(
            'warning',
            'Status berhasil diperbarui, tetapi customer tidak memiliki nomor WhatsApp.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RAPIIKAN NOMOR
    |--------------------------------------------------------------------------
    */

    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (substr($phone, 0, 1) == '0') {
        $phone = '62' . substr($phone, 1);
    }

    /*
    |--------------------------------------------------------------------------
    | REDIRECT KE WHATSAPP
    |--------------------------------------------------------------------------
    */

    return redirect()->away(
        "https://wa.me/{$phone}?text=" . urlencode($message)
    );
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
        $validator = Validator::make($request->all(), [
            'alamat_pengiriman' => 'required|string|max:255',
            'metode_pembayaran' => 'required|string',
            'metode_pengiriman' => 'required|in:ditoko,delivery',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'checkout')
                ->withInput()
                ->with('error_checkout', 'Gagal membuat pesanan, cek data kamu!');
        }

        try {

            $user = Auth::user();
            $selectedIds = $request->selected_items;

            $keranjangs = Keranjang::with('produk')
                ->where('user_id', $user->id)
                ->whereIn('id', $selectedIds)
                ->get();

            if ($keranjangs->isEmpty()) {
                return redirect()->route('keranjang.show')
                    ->with('error_checkout', 'Keranjang Anda kosong!');
            }

            $totalHargaProduk = $keranjangs->sum(fn($k) => $k->jumlah * $k->harga);

            $produkDetails = $keranjangs->map(function ($item) {
                return [
                    'produk_id' => $item->produk->id,
                    'nama'      => $item->produk->nama_produk,
                    'gambar'    => $item->produk->gambar,
                    'jumlah'    => $item->jumlah,
                    'harga'     => $item->harga,
                    'total'     => $item->jumlah * $item->harga,
                ];
            })->toArray();

            $checkout = Checkout::create([
                'user_id' => $user->id,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'metode_pengiriman' => $request->metode_pengiriman,
                'total_harga' => $totalHargaProduk,
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
                    $stok->jumlah_stok = max(0, $stok->jumlah_stok);
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

            return redirect()
                ->route('checkout.detail', $checkout->id)
                ->with('success_checkout', 'Checkout berhasil dibuat!');

        } catch (\Exception $e) {

            Log::error('Checkout error: ' . $e->getMessage());

            return back()->with('error_checkout', 'Terjadi kesalahan saat checkout!');
        }
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        $selectedIds = $request->selected_items;

        if (!$selectedIds) {
            return redirect()->route('keranjang.show')
                ->with('error', 'Pilih minimal 1 produk!');
        }

        $keranjangs = Keranjang::with(['produk.stok'])
            ->where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.show')
                ->with('error', 'Data tidak ditemukan!');
        }

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
    public function inputResi(Request $request, $id)
    {
        $request->validate([
            'no_resi' => 'required|string|max:100'
        ]);

        $checkout = Checkout::findOrFail($id);
        $checkout->no_resi = $request->no_resi;
        $checkout->tanggal_kirim = now();
        $checkout->status = 'dikirim';
        $checkout->save();

        return back()->with('success', 'Resi berhasil ditambahkan');
    }
}