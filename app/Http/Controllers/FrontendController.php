<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Halaman semua produk + search
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $produks = Produk::with('stok');

        if ($search) {
            $produks->where(function ($query) use ($search) {
                $query->where('nama_produk', 'like', "%{$search}%")
                      ->orWhere('harga', 'like', "%{$search}%");
            });
        }

        // $produks = $produks
        //     ->leftJoin('stoks', 'produks.id', '=', 'stoks.produk_id')
        //     ->orderByRaw('CASE WHEN stoks.jumlah_stok > 0 THEN 0 ELSE 1 END')
        //     ->orderByDesc('stoks.jumlah_stok')
        //     ->select('produks.*')
        //     ->get();
        $produks = $produks->get();

        return view('landingpage.page.semuaproduk', [
            'produks' => $produks,
        ]);
    }

    /**
     * Produk terbaru (limit 10)
     */
    public function terbaru()
    {
        $produks = Produk::with('stok')
                        ->latest()
                        ->take(10)
                        ->get();

        return view('landingpage.page.terbaru', [
            'produks' => $produks,
        ]);
    }

    /**
     * Search terpisah (pakai pagination)
     */
    public function search(Request $request)
    {
        $search = $request->input('search');

        $produks = Produk::with('stok')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_produk', 'like', "%{$search}%")
                      ->orWhere('harga', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('landingpage.page.semuaproduk', [
            'produks' => $produks,
        ]);
    }
}