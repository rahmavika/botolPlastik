<?php

namespace App\Http\Controllers;

use App\Models\Logstok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LogstokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $logStoks = Logstok::with('produk')
            ->orderBy('tanggal')
            ->get()
            ->map(function ($log) {
                $log->tanggal = Carbon::parse($log->tanggal);
                return $log;
            });
        $mutasiPerBulan = $logStoks->groupBy(function ($log) {
            return $log->tanggal->format('Y-m');
        });

        $hasil = collect();

        $daftarPeriode = $mutasiPerBulan->keys()->sortDesc();

        foreach ($daftarPeriode as $periode) {
            $logsBulanIni = $mutasiPerBulan[$periode];
            $tanggalAwalBulan = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
            $stokAwal = $logStoks->filter(function ($log) use ($tanggalAwalBulan) {
                return $log->tanggal->lt($tanggalAwalBulan);
            })->reduce(function ($total, $log) {
                return $total + ($log->tipe === 'masuk' ? $log->jumlah : -$log->jumlah);
            }, 0);
            $stokMasuk = $logsBulanIni->where('tipe', 'masuk')->sum('jumlah');
            $stokKeluar = $logsBulanIni->where('tipe', 'keluar')->sum('jumlah');
            $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar;
            $jumlahProduk = $logsBulanIni->groupBy('produk_id')->count();

            $hasil->push((object)[
                'bulan'         => $tanggalAwalBulan->month,
                'tahun'         => $tanggalAwalBulan->year,
                'nama_bulan'    => $tanggalAwalBulan->locale('id')->translatedFormat('F Y'),
                'jumlah_produk' => $jumlahProduk,
                'stok_awal'     => $stokAwal,
                'stok_masuk'    => $stokMasuk,
                'stok_keluar'   => $stokKeluar,
                'stok_akhir'    => $stokAkhir,
            ]);
        }

        return view('logstoks.index', [
            'periodeList' => $hasil,
        ]);
    }

    public function show($bulan, $tahun)
    {
        $namaCabang = Auth::user()->name ?? '-';
        $tanggalCetak = now();

        $tanggalAwalBulan = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $tanggalAkhirBulan = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $logStoks = Logstok::with('produk')
            ->get()
            ->map(function($log) {
                $log->tanggal = Carbon::parse($log->tanggal);
                return $log;
            })
            ->groupBy('produk_id');

        $dataMutasi = $logStoks->map(function ($logs) use ($tanggalAwalBulan, $tanggalAkhirBulan) {
            $first = $logs->first();
            $produk = $first->produk;

            $stokAwal = $logs->filter(function ($log) use ($tanggalAwalBulan) {
                return $log->tanggal->lt($tanggalAwalBulan);
            })->sum(function ($log) {
                return $log->tipe === 'masuk' ? $log->jumlah : -$log->jumlah;
            });

            $stokMasuk = $logs->filter(function ($log) use ($tanggalAwalBulan, $tanggalAkhirBulan) {
                return $log->tanggal->between($tanggalAwalBulan, $tanggalAkhirBulan) && $log->tipe === 'masuk';
            })->sum('jumlah');

            $stokKeluar = $logs->filter(function ($log) use ($tanggalAwalBulan, $tanggalAkhirBulan) {
                return $log->tanggal->between($tanggalAwalBulan, $tanggalAkhirBulan) && $log->tipe === 'keluar';
            })->sum('jumlah');

            $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar;

            return (object)[
                'nama_produk' => $produk->nama_produk ?? '-',
                'stok_awal'   => $stokAwal,
                'masuk'       => $stokMasuk,
                'keluar'      => $stokKeluar,
                'stok_akhir'  => $stokAkhir,
            ];
        })->values();

        return view('logstoks.detail-perproduk', compact('namaCabang', 'tanggalCetak', 'bulan', 'tahun', 'dataMutasi'));
    }


    public function cetak(Request $request)
    {
        $filterType = $request->input('filter');
        $from = null;
        $to = null;
        Carbon::setLocale('id');

        if ($filterType === 'bulan') {
            $periode = $request->input('bulan');
            if (!$periode || !preg_match('/^\d{4}-\d{2}$/', $periode)) {
                abort(400, 'Format periode tidak valid');
            }

            [$tahun, $bulan] = explode('-', $periode);
            $tanggalAwal = Carbon::create($tahun, $bulan, 1)->startOfDay();
            $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth()->endOfDay();
            $periodeLabel = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');

        } elseif ($filterType === 'tanggal') {
            $from = $request->input('from');
            $to = $request->input('to');

            if (!$from || !$to) {
                abort(400, 'Tanggal awal dan akhir wajib diisi');
            }

            $tanggalAwal = Carbon::parse($from)->startOfDay();
            $tanggalAkhir = Carbon::parse($to)->endOfDay();
            $periodeLabel = Carbon::parse($from)->translatedFormat('d F Y') .
                ' s/d ' .
                Carbon::parse($to)->translatedFormat('d F Y');
        } else {
            abort(400, 'Tipe filter tidak valid');
        }
        $logStoks = Logstok::with('produk')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->get()
            ->groupBy('produk_id')
            ->map(function ($logs) use ($tanggalAwal, $tanggalAkhir) {
                $produk = $logs->first()->produk;

                $stokAwal = $logs->where('tanggal', '<', $tanggalAwal)
                    ->reduce(fn($total, $log) => $total + ($log->tipe === 'masuk' ? $log->jumlah : -$log->jumlah), 0);

                $masuk = $logs->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                    ->where('tipe', 'masuk')
                    ->sum('jumlah');

                $keluar = $logs->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                    ->where('tipe', 'keluar')
                    ->sum('jumlah');

                $stokAkhir = $stokAwal + $masuk - $keluar;

                return (object)[
                    'nama_produk' => $produk->nama_produk ?? '-',
                    'stok_awal'   => $stokAwal,
                    'masuk'       => $masuk,
                    'keluar'      => $keluar,
                    'stok_akhir'  => $stokAkhir,
                ];
            })->values();

        $tanggalCetakFormatted = now()->translatedFormat('d F Y');

        $pdf = PDF::loadView('logstoks.cetak', [
            'dataMutasi'   => $logStoks,
            'periodeLabel' => $periodeLabel,
            'filterType'   => $filterType,
            'tanggalCetak' => $tanggalCetakFormatted
        ])->setPaper('a4', 'landscape');

        if ($filterType === 'bulan') {
            $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');
            $fileName = "Laporan Mutasi Stok-$namaBulan.pdf";
        } else {
            $fromFormatted = Carbon::parse($from)->translatedFormat('d F Y');
            $toFormatted = Carbon::parse($to)->translatedFormat('d F Y');
            $fileName = "Laporan Mutasi Stok-$fromFormatted-$toFormatted.pdf";
        }

        return $pdf->stream($fileName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logstok $logstok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logstok $logstok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logstok $logstok)
    {
        //
    }
}