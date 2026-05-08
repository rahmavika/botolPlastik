<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogStok;
use Carbon\Carbon;

class LogStokController extends Controller
{
    /**
     * TAMPILKAN LOG STOK
     */
    public function index(Request $request)
    {
        $query = LogStok::with(['produk', 'user'])
            ->orderBy('created_at', 'desc');

        if ($request->from && $request->to) {
            $query->whereBetween('tanggal', [
                $request->from,
                $request->to
            ]);
        }
        if ($request->bulan) {
            $bulan = Carbon::parse($request->bulan);
            $query->whereMonth('tanggal', $bulan->month)
                  ->whereYear('tanggal', $bulan->year);
        }

        $logStok = $query->get();

        return view('logstoks.index', compact('logStok'));
    }
}