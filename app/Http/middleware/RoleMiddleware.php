<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect('login'); // Redirect ke login jika belum login
        }

        $user = Auth::user(); // Ambil user yang sedang login

        // Periksa apakah role user ada dalam daftar role yang diperbolehkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Tampilkan halaman 404 jika role tidak cocok
        abort(404, 'Halaman tidak ditemukan');
    }
}