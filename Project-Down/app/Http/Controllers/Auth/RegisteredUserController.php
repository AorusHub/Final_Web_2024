<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['string','max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
            'address' => ['nullable', 'string', 'max:255'], // Validasi alamat
            'phone_number' => ['nullable', 'string', 'max:15'], // Validasi nomor telepon
            'gender' => ['nullable', 'in:Laki-Laki,Perempuan'], // Validasi jenis kelamin
            'birth_date' => ['nullable', 'date'], // Validasi tanggal lahir
        ]);
        
        if (!str_ends_with($request->email, '@student.unhas.ac.id')) {
            return back()->withErrors([
                'email' => 'Email harus menggunakan domain @student.unhas.ac.id.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'mahasiswa',
            'password' => Hash::make($request->password),
            'address' => $request->address, // Simpan alamat
            'phone_number' => $request->phone_number, // Simpan nomor telepon
            'gender' => $request->gender, // Simpan jenis kelamin
            'birth_date' => $request->birth_date, // Simpan tanggal lahir
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return redirect(route('login'));
    }

}
