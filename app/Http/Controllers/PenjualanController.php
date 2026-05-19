<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');

        $query = Checkout::where('status', 'selesai');
        if ($tahun) {
            $query->whereYear('updated_at', $tahun);
        }
        if ($bulan) {
            $query->whereMonth('updated_at', $bulan);
        }

        $checkouts = $query
            ->latest('updated_at')
            ->paginate(10);

        return view('penjualans.daftarPenjualan', compact(
            'checkouts',
            'tahun',
            'bulan'
        ));
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

        $checkouts = Checkout::where('status', 'selesai')

            ->when($tahun, function ($query) use ($tahun) {
                $query->whereYear('updated_at', $tahun);
            })

            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('updated_at', $bulan);
            })

            ->latest('updated_at')
            ->get();

        $message = $checkouts->isEmpty()
            ? 'Maaf, data penjualan tidak tersedia.'
            : null;

        $namaBulan = $bulan
            ? Carbon::create()->month((int)$bulan)->translatedFormat('F')
            : 'Semua Bulan';

        $totalPenjualan = $checkouts->sum('total_harga');

        $pdf = PDF::loadView('penjualans.cetakPdf', [
            'checkouts'       => $checkouts,
            'tahun'           => $tahun ?: 'Semua Tahun',
            'bulan'           => $namaBulan,
            'message'         => $message,
            'totalPenjualan'  => $totalPenjualan,
        ]);

        return $pdf->stream('Laporan-Penjualan.pdf');
    }
}