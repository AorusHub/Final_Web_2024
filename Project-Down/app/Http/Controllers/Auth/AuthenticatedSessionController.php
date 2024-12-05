<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validasi email dan password
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);
    
        // Cek kredensial pengguna
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            // Ambil user yang sedang login
            $user = Auth::user();
    
            // Cek role pengguna dan lakukan redirect sesuai role
            switch ($user->role) {
                case 'Admin':
                    return redirect()->intended('/dashboard'); // Rute untuk Admin
                case 'Pegawai':
                    return redirect()->intended('/dashboard'); // Rute untuk Pegawai
                case 'Mahasiswa':
                    // Validasi domain email mahasiswa
                    if (!str_ends_with($user->email, '@student.unhas.ac.id')) {
                        Auth::logout(); // Logout jika email tidak sesuai
                        return back()->withErrors([
                            'email' => 'Harus menggunakan email Unhas',
                        ]);
                    }
                    return redirect()->intended('/dashboard'); // Rute untuk Mahasiswa
                default:
                    // Jika role tidak dikenal, logout dan beri pesan error
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Role pengguna tidak valid.',
                    ]);
            }
        }
    
        // Jika autentikasi gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
