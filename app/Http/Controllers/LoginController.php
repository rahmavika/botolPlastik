<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect('/')->with('login_modal', true);
    }
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $request->session()->put('name', $user->name);
            $request->session()->put('email', $user->email);
            $request->session()->put('phone', $user->phone);

            // $keranjangs = Keranjang::with('produk')->where('user_id', Auth::id())->get();
            // session()->put('keranjangs', $keranjangs);
            if ($user->role === 'pelanggan') {
                return redirect()->intended('/semuaproduk');
            } elseif ($user->role === 'admin') {
                return redirect()->intended('/dashboard');
            } 
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->forget(['name', 'email', 'phone']);

        return redirect('/');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}