<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $query = Checkout::where('status', 'selesai')
            ->select('id', 'user_id', 'alamat_pengiriman', 'total_harga', 'tanggal_pemesanan', 'status');
        if ($tahun) {
            $query->whereYear('tanggal_pemesanan', $tahun);
        }
        if ($bulan) {
            $query->whereMonth('tanggal_pemesanan', $bulan);
        }
        $checkouts = $query->latest()->paginate(10);
        return view('penjualans.daftarPenjualan', compact('checkouts', 'tahun', 'bulan'));
    }

    public function show($id)
    {
        $checkout = Checkout::findOrFail($id);

        return view('penjualans.detailPenjualan', compact('checkout'));
    }

    public function cetakPdf(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');

        $checkouts = Checkout::when($tahun, function ($query, $tahun) {
                                return $query->whereYear('tanggal_pemesanan', $tahun);
                            })
                            ->when($bulan, function ($query, $bulan) {
                                return $query->whereMonth('tanggal_pemesanan', $bulan);
                            })
                            ->where('status', 'selesai')
                            ->get();

        $message = $checkouts->isEmpty() ? 'Maaf, penjualan tidak tersedia.' : null;
        $namaBulan = $bulan ? Carbon::create(null, $bulan)->translatedFormat('F') : 'Semua Bulan';
        $totalPenjualan = $checkouts->sum('total_harga');
        $pdf = PDF::loadView('penjualans.cetakPdf', [
            'checkouts' => $checkouts,
            'tahun' => $tahun ?: 'Semua Tahun',
            'bulan' => $namaBulan,
            'message' => $message,
            'totalPenjualan' => $totalPenjualan, 
        ]);

        return $pdf->stream('Laporan-Penjualan.pdf');
    }
}