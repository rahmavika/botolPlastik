<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keranjangs = Keranjang::with('produk')->where('user_id', Auth::id())->get();
        $totalHarga = $keranjangs->sum(function ($keranjang) {
            return $keranjang->jumlah * $keranjang->harga;
        });
        return view('landingpage.pelanggan.keranjang', compact('keranjangs', 'totalHarga'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $produkId = $request->produk_id; // ✅ ini ID, bukan object
        $jumlah = $request->jumlah;

        $produk = Produk::findOrFail($produkId); // ✅ ambil produk di sini
        $harga = $produk->harga;

        $keranjang = Keranjang::where('user_id', $userId)
            ->where('produk_id', $produkId)
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += $jumlah;
            $keranjang->harga = $keranjang->jumlah * $harga; // 🔥 update total harga juga
            $keranjang->save();
        } else {
            Keranjang::create([
                'user_id' => $userId,
                'produk_id' => $produkId,
                'jumlah' => $jumlah,
                'harga' => $harga * $jumlah,
            ]);
        }

        return response()->json(['success' => true]); // 🔥 penting untuk fetch
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $keranjangs = Keranjang::where('user_id', Auth::id())->get();
        $totalHarga = $keranjangs->sum(function ($keranjang) {
            return $keranjang->jumlah * $keranjang->harga;
        });

        return view('landingpage.pelanggan.keranjang', compact('keranjangs', 'totalHarga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $keranjang = Keranjang::findOrFail($id);

        $stokTersedia = $keranjang->produk->stok->jumlah_stok ?? 0;

        if ($request->action === 'increase') {
            if ($keranjang->jumlah < $stokTersedia) {
                $keranjang->jumlah++;
            }
        } elseif ($request->action === 'decrease') {
            if ($keranjang->jumlah > 1) {
                $keranjang->jumlah--;
            }
        }

        $keranjang->save();

        return back()->with('Jumlah produk diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       Keranjang::where('id', $id)->where('user_id', Auth::id())->delete();
       $keranjangs = Keranjang::with('produk')->where('user_id', Auth::id())->get();
       session()->put('keranjangs', $keranjangs);
       return redirect()->back()->with('Produk berhasil dihapus dari keranjang.');
   }
}