<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $pegawai = User::where('role', 'Pegawai')->paginate(10);
        $mahasiswa = User::where('role', 'Mahasiswa')->paginate(10);
        $admin = User::where('role', 'Admin')->paginate(10);
        return view('section.user', compact('pegawai', 'mahasiswa', 'admin'));
    }
    

    // Menampilkan form tambah pengguna
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => 'required|in:Admin,Pegawai,Mahasiswa',
            'address' => ['nullable', 'string', 'max:255'], // Validasi alamat
            'phone_number' => ['nullable', 'string', 'max:15'], // Validasi nomor telepon
            'gender' => ['nullable', 'in:Laki-Laki,Perempuan'], // Validasi jenis kelamin
            'birth_date' => ['nullable', 'date'], // Validasi tanggal lahir
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Mahasiswa',
            'address' => $request->address, // Simpan alamat
            'phone_number' => $request->phone_number, // Simpan nomor telepon
            'gender' => $request->gender, // Simpan jenis kelamin
            'birth_date' => $request->birth_date, // Simpan tanggal lahir
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Menampilkan form edit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Memperbarui pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:Admin,Pegawai,Mahasiswa',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function profile()
{
    $user = Auth::user(); // Mengambil user yang sedang login
    return view('section.profile', compact('user'));
}
}

