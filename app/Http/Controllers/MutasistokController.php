<?php

namespace App\Http\Controllers;

use App\Models\Logstok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MutasiStokController extends Controller
{
    /**
     * Display listing mutasi stok per bulan
     */
    public function index()
    {
        $user = Auth::user();

        $mutasiStoks = Logstok::with('produk')
            ->orderBy('tanggal')
            ->get()
            ->map(function ($mutasi) {
                $mutasi->tanggal = Carbon::parse($mutasi->tanggal);
                return $mutasi;
            });

        $mutasiPerBulan = $mutasiStoks->groupBy(function ($mutasi) {
            return $mutasi->tanggal->format('Y-m');
        });

        $hasil = collect();
        $daftarPeriode = $mutasiPerBulan->keys()->sortDesc();

        foreach ($daftarPeriode as $periode) {

            $mutasiBulanIni = $mutasiPerBulan[$periode];
            $tanggalAwalBulan = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();

            $stokAwal = $mutasiStoks->filter(function ($mutasi) use ($tanggalAwalBulan) {
                return $mutasi->tanggal->lt($tanggalAwalBulan);
            })->reduce(function ($total, $mutasi) {
                return $total + ($mutasi->tipe === 'masuk' ? $mutasi->jumlah : -$mutasi->jumlah);
            }, 0);

            $stokMasuk = $mutasiBulanIni->where('tipe', 'masuk')->sum('jumlah');
            $stokKeluar = $mutasiBulanIni->where('tipe', 'keluar')->sum('jumlah');
            $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar;

            $jumlahProduk = $mutasiBulanIni->groupBy('produk_id')->count();

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

        return view('mutasistoks.index', [
            'periodeList' => $hasil,
        ]);
    }

    /**
     * Detail mutasi stok per produk
     */
    public function show($bulan, $tahun)
    {
        $namaCabang = Auth::user()->name ?? '-';
        $tanggalCetak = now();

        $tanggalAwalBulan = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $tanggalAkhirBulan = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $mutasiStoks = Logstok::with('produk')
            ->get()
            ->map(function ($mutasi) {
                $mutasi->tanggal = Carbon::parse($mutasi->tanggal);
                return $mutasi;
            })
            ->groupBy('produk_id');

        $dataMutasi = $mutasiStoks->map(function ($logs) use ($tanggalAwalBulan, $tanggalAkhirBulan) {

            $first = $logs->first();
            $produk = $first->produk;

            $stokAwal = $logs->filter(function ($mutasi) use ($tanggalAwalBulan) {
                return $mutasi->tanggal->lt($tanggalAwalBulan);
            })->sum(function ($mutasi) {
                return $mutasi->tipe === 'masuk' ? $mutasi->jumlah : -$mutasi->jumlah;
            });

            $stokMasuk = $logs->filter(function ($mutasi) use ($tanggalAwalBulan, $tanggalAkhirBulan) {
                return $mutasi->tanggal->between($tanggalAwalBulan, $tanggalAkhirBulan)
                    && $mutasi->tipe === 'masuk';
            })->sum('jumlah');

            $stokKeluar = $logs->filter(function ($mutasi) use ($tanggalAwalBulan, $tanggalAkhirBulan) {
                return $mutasi->tanggal->between($tanggalAwalBulan, $tanggalAkhirBulan)
                    && $mutasi->tipe === 'keluar';
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

        return view('mutasistoks.detail-perproduk', compact(
            'namaCabang',
            'tanggalCetak',
            'bulan',
            'tahun',
            'dataMutasi'
        ));
    }

    /**
     * Cetak PDF mutasi stok
     */
    public function cetak(Request $request)
    {
        $filterType = $request->input('filter');
        Carbon::setLocale('id');

        if ($filterType === 'bulan') {

            $periode = $request->input('bulan');
            [$tahun, $bulan] = explode('-', $periode);

            $tanggalAwal = Carbon::create($tahun, $bulan, 1)->startOfDay();
            $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth()->endOfDay();

            $periodeLabel = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');

        } elseif ($filterType === 'tanggal') {

            $from = $request->input('from');
            $to = $request->input('to');

            $tanggalAwal = Carbon::parse($from)->startOfDay();
            $tanggalAkhir = Carbon::parse($to)->endOfDay();

            $periodeLabel = Carbon::parse($from)->translatedFormat('d F Y') .
                ' s/d ' .
                Carbon::parse($to)->translatedFormat('d F Y');
        }

        $mutasiStoks = Logstok::with('produk')
            ->where('tanggal', '<=', $tanggalAkhir) // ⬅️ INI KUNCINYA
            ->get()
            ->groupBy('produk_id')
            ->map(function ($logs) use ($tanggalAwal, $tanggalAkhir) {

                $produk = $logs->first()->produk;

                $stokAwal = $logs->where('tanggal', '<', $tanggalAwal)
                    ->reduce(fn($t, $m) => $t + ($m->tipe === 'masuk' ? $m->jumlah : -$m->jumlah), 0);

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

        $pdf = PDF::loadView('mutasistoks.cetak', [
            'dataMutasi'   => $mutasiStoks,
            'periodeLabel' => $periodeLabel,
            'filterType'   => $filterType,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ])->setPaper('a4', 'landscape');

        return $pdf->stream("Laporan Mutasi Stok.pdf");
    }
}