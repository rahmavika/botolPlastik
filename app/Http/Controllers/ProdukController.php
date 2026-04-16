<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = produk::all();
        return view('produks.index', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'keterangan' => 'required|string',
        ]);
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
       }

       Produk::create($validated);
       return redirect('/dashboard-produk')->with('pesan', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(produk $produk)
    {
        $produk = produk::find($produk->id);
        return view('produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        return view('produks.update', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'keterangan' => 'required|string',
        ]);
        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($validated);
        return redirect('/dashboard-produk')->with('pesan', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }
        $produk->delete();

        return redirect('/dashboard-produk')->with('pesan', 'Data berhasil dihapus');
    }
}