<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Checkout;

class RiwayatBelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Checkout::where('user_id', Auth::id());
        $riwayatBelanja = $query->latest()->paginate(10);

        return view('landingpage.pelanggan.riwayatBelanja', compact('riwayatBelanja'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $validated = $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $checkout = Checkout::findOrFail($id);

        if ($request->hasFile('bukti_transfer')) {
            $imageName = time() . '.' . $request->bukti_transfer->extension();
            $request->bukti_transfer->move(public_path('storage/buktiTF'), $imageName);
            $filePath = 'storage/buktiTF/' . $imageName;

            $checkout->bukti_transfer = $filePath;
            $checkout->save();
        }

        return response()->json([
            'success' => true,
            'bukti_path' => asset($filePath),
        ]);
    }
    public function terimaPesanan($id)
    {
        $checkout = Checkout::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // hanya bisa jika sudah dikirim
        if ($checkout->status !== 'dikirim') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan belum bisa dikonfirmasi'
            ]);
        }

        $checkout->update([
            'status' => 'selesai'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil diterima'
        ]);
    }

}