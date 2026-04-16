<?php

namespace App\Http\Controllers;

use App\Models\Contactus;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ContactusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function contactUs()
    {
        $faqs = Contactus::where('is_published', true)->get();
        return view('landingpage.page.contact_us', compact('faqs'));
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
            'nama' => 'required|string|max:100',
            'email' => 'required|email',
            'pertanyaan' => 'required|string|max:1000',
        ]);

        Contactus::create($request->only('nama', 'email', 'pertanyaan'));

        return back()->with([
            'success' => 'Pertanyaan berhasil dikirim!',
            'alert_type' => 'tambah'
        ]);
    }

    public function index(Request $request)
    {
        $query = ContactUs::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('pertanyaan', 'like', "%{$search}%");
        }

        $questions = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('contactuses.index', compact('questions'));

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = ContactUs::findOrFail($id);
        return view('contactuses.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $question = ContactUs::findOrFail($id);
        return view('contactuses.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jawaban' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $question = ContactUs::findOrFail($id);
        $question->jawaban = $request->jawaban;
        $question->is_published = $request->has('is_published');
        $question->save();

        return redirect()->route('contactuses.index')->with([
            'success' => 'Pertanyaan berhasil diperbarui.',
            'alert_type' => 'edit'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ContactUs::destroy($id);

        return redirect()->route('contactuses.index')->with([
            'success' => 'Pertanyaan berhasil dihapus.',
            'alert_type' => 'hapus'
        ]);
    }

    /**
     * Cetak PDF daftar semua pertanyaan
     */
    // public function cetakPDF()
    // {
    //     $questions = ContactUs::orderBy('created_at', 'desc')->get();
    //     $pdf = Pdf::loadView('contactuses.cetak_pdf', compact('questions'));
    //     return $pdf->stream('laporan-contact-us.pdf');
    // }
}