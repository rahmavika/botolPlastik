<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\PDF;

class UserController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        if ($currentUser->role === 'admin') {

            $users = User::where(function ($query) use ($currentUser) {
                    $query->where('role', 'pelanggan')
                        ->orWhere('id', $currentUser->id); // user login ikut tampil
                })
                ->orderByRaw("
                    CASE
                        WHEN id = ? THEN 0
                        ELSE 1
                    END
                ", [$currentUser->id])
                ->get();

        } elseif ($currentUser->role === 'super_admin') {

            $users = User::whereIn('role', ['admin', 'pelanggan'])
                ->orderByRaw("
                    CASE
                        WHEN id = ? THEN 0
                        ELSE 1
                    END
                ", [$currentUser->id])
                ->get();

        } else {
            $users = collect();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create',['users' =>User::all()]);
    }
    public function store(Request $request)
    {
        $currentUser = auth()->user();

        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed',
            'phone' => 'required|digits_between:12,16',
            'role' => 'nullable|in:admin,pelanggan',
        ]);

        // if ($currentUser->role === 'admin') {
        //     $validated['role'] = 'pelanggan';
        // }
        $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);

        User::create($validated);
        return redirect('/dashboard-pengguna')->with('pesan', 'Data berhasil disimpan');
    }

    public function show(User $user)
    {
        $user = User::findOrFail($user->id);
        return view('users.show', compact('user'));
    }
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.update', compact('user'));
    }
    public function update(Request $request, string $id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|digits_between:12,16',
            'role' => 'nullable|in:admin,pelanggan',
            'old_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:4|confirmed',
        ]);

        // if ($currentUser->role === 'admin') {
        //     $validated['role'] = 'pelanggan';
        // }

        if (!empty($validated['password'])) {
            if (!Hash::check($validated['old_password'], $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama salah'])->withInput();
            }
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect('/dashboard-pengguna')->with('pesan', 'Data berhasil diupdate');
    }

    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect('/dashboard-pengguna')->with('pesan', 'Data berhasil dihapus');
    }

    public function editUser()
    {
        $user = Auth::user(); // Mengambil data pengguna yang sedang login
        if (!$user) {
            return redirect()->route('login')->withErrors('Please log in to access this page.');
        }
        return view('landingpage.pelanggan.editprofile', compact('user'));
    }

    public function updateUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:15',
            'password' => 'nullable|min:4|confirmed',
            'old_password' => 'required_with:password',
        ]);

        try {
            $user = User::findOrFail(Auth::id());
            $dataUpdate = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ];
            if (!empty($validated['password'])) {

                if (!Hash::check($validated['old_password'], $user->password)) {
                    return back()->withErrors([
                        'old_password' => 'Password lama tidak sesuai!'
                    ])->withInput();
                }
                $dataUpdate['password'] = Hash::make($validated['password']);
            }

            $user->update($dataUpdate);
            session([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ]);

            return redirect()->back()->with('success_profile', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data pengguna: ' . $e->getMessage());

            return redirect()->back()->withErrors('Terjadi kesalahan saat menyimpan data.');
        }
    }
}