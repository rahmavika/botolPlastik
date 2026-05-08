<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');

        $start = Carbon::parse($bulan)->startOfMonth();
        $end   = Carbon::parse($bulan)->endOfMonth();

        $jumlahProduk = Produk::count();
        $jumlahPelanggan = User::where('role', 'pelanggan')->count();
        $jumlahPesananMasuk = Checkout::where('status', 'menunggu_konfirmasi')->count();

        $totalPenjualan = Checkout::where('status_pembayaran', 'lunas')
            ->whereBetween('updated_at', [$start, $end])
            ->sum('total_harga');

        $data = Checkout::selectRaw('DATE(updated_at) as tanggal, SUM(total_harga) as total')
            ->where('status_pembayaran', 'lunas')
            ->whereBetween('updated_at', [$start, $end])
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $pesananPerHari = collect();
        for ($i = 0; $i < $start->daysInMonth; $i++) {
            $tgl = $start->copy()->addDays($i)->format('Y-m-d');

            $pesananPerHari->push([
                'tanggal' => Carbon::parse($tgl)->translatedFormat('d'),
                'total' => $data[$tgl] ?? 0
            ]);
        }

        $tahun = $request->tahun ?? now()->year;
        $dataDB = Checkout::selectRaw('MONTH(updated_at) as bulan, SUM(total_harga) as total')
            ->where('status_pembayaran', 'lunas')
            ->whereYear('updated_at', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');
        $penjualanPerBulan = collect();
        for ($i = 1; $i <= 12; $i++) {
            $penjualanPerBulan->push([
                'bulan' => $i,
                'nama_bulan' => Carbon::create()->month($i)->translatedFormat('F'),
                'total' => $dataDB[$i] ?? 0
            ]);
        }

        $statusDefault = collect([
            'menunggu_konfirmasi' => 0,
            'diproses'            => 0,
            'dikirim'             => 0,
            'selesai'             => 0,
        ]);
        $statusDB = Checkout::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
        $statusPesanan = $statusDefault->merge($statusDB);

        $metodePembayaran = Checkout::where('status_pembayaran', 'lunas')
            ->selectRaw('metode_pembayaran, COUNT(*) as total')
            ->groupBy('metode_pembayaran')
            ->pluck('total', 'metode_pembayaran');

        $transaksiTerbaru = Checkout::where('status_pembayaran', 'lunas')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'jumlahProduk',
            'jumlahPelanggan',
            'jumlahPesananMasuk',
            'totalPenjualan',
            'pesananPerHari',
            'penjualanPerBulan',
            'statusPesanan',
            'metodePembayaran',
            'transaksiTerbaru',
            'tahun',
            'bulan'
        ));
    }
}