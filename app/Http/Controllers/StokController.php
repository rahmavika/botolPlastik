<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use App\Models\Logstok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $stoks = DB::table('produks')
            ->leftJoin('stoks', 'produks.id', '=', 'stoks.produk_id')
            ->select(
                'produks.id as produk_id',
                'produks.nama_produk',
                DB::raw('COALESCE(stoks.jumlah_stok, 0) as jumlah_stok')
            )
            ->get();

        return view('stoks.index', compact('stoks'));
    }

    public function tambah(Request $request, $produk_id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $stok = Stok::firstOrCreate(
            ['produk_id' => $produk_id],
            ['jumlah_stok' => 0]
        );

        $stok->jumlah_stok += $request->jumlah;
        $stok->save();

        Logstok::create([
            'tanggal'    => Carbon::now(),
            'produk_id'  => $produk_id,
            'tipe'       => 'masuk',
            'jumlah'     => $request->jumlah,
            'keterangan' => 'Penambahan stok manual',
            'created_by' => Auth::id(),
        ]);

        return redirect('/dashboard-stok')->with('success', 'Stok berhasil ditambah.');
    }

    public function kurangi(Request $request, $produk_id)
    {
        $request->validate([
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255'
        ]);

        $stok = Stok::where('produk_id', $produk_id)->firstOrFail();
        $stok->jumlah_stok -= $request->jumlah;
        if ($stok->jumlah_stok < 0) {
            $stok->jumlah_stok = 0;
        }
        $stok->save();

        Logstok::create([
            'tanggal'    => now(),
            'produk_id'  => $produk_id,
            'tipe'       => 'keluar',
            'jumlah'     => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Stok berhasil dikurangi.');
    }

    public function create()
    {
        return view('stoks.create', ['produks' => Produk::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id'   => 'required|exists:produks,id',
            'jumlah_stok' => 'required|integer|min:1',
        ]);

        Stok::create($validated);

        return redirect('/dashboard-stok')->with('pesan', 'Data berhasil disimpan');
    }
}