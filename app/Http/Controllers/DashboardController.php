<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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

        $totalPenjualan = Checkout::where('status', 'selesai')
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_harga');

        // 🔥 DATA PER HARI 1 BULAN
        $data = Checkout::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$start, $end])
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

        // STATUS
        $statusPesanan = Checkout::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // METODE PEMBAYARAN
        $metodePembayaran = Checkout::selectRaw('metode_pembayaran, COUNT(*) as total')
            ->groupBy('metode_pembayaran')
            ->pluck('total', 'metode_pembayaran');

        $transaksiTerbaru = Checkout::where('status', 'selesai')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'jumlahProduk',
            'jumlahPelanggan',
            'jumlahPesananMasuk',
            'totalPenjualan',
            'pesananPerHari',
            'statusPesanan',
            'metodePembayaran',
            'transaksiTerbaru',
            'bulan'
        ));
    }
}