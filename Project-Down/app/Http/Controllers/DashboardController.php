<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Fine;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::check())
            if(Auth::user()->role === 'Mahasiswa'){
                $userId = Auth::id();
    
                // Peminjaman Aktif (Pending atau Disetujui)
                $activeLoans = Loan::where('user_id', $userId)
                    ->whereIn('status', ['pending', 'approved'])
                    ->with('book')
                    ->paginate(5);
            
                // Riwayat Peminjaman (Dikembalikan atau Hilang)
                $loanHistory = Loan::where('user_id', $userId)
                    ->whereIn('status', ['returned', 'lost'])
                    ->with('book')
                    ->paginate(5);
            
                // Daftar Denda
                $fines = Fine::whereHas('loan', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->with('loan.book')->paginate(5);
            
                // Katalog Buku
                $books = Book::paginate(5);
        
                $PinjamAktif = Loan::where('user_id', $userId)
                ->whereIn('status', ['pending', 'approved'])
                ->count();
        
                // Total biaya denda
                $totalDenda = Fine::whereHas('loan', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->sum('amount');
        
                // Total buku yang tersedia untuk dipinjam
                $BukuSedia = Book::where('stock', '>', 0)->count();
        
                $maxLoansAllowed = 3; // Batas maksimal peminjaman buku
                $remainingLoans = $maxLoansAllowed - $PinjamAktif;
            
                // Mengarahkan ke halaman dashboard mahasiswa dengan data yang dikirim
                return view('section.dashboard', compact('activeLoans', 'loanHistory', 'fines', 'books','PinjamAktif','totalDenda','BukuSedia','remainingLoans'));
            }

            elseif(Auth::user()->role === 'Pegawai'){
                // Jumlah total buku
                $totalBooks = Book::count();

                // Jumlah total pinjaman aktif
                $activeLoansCount = Loan::whereIn('status', ['pending', 'approved'])->count();

                // Jumlah total pengembalian
                $returnedLoansCount = Loan::where('status', 'returned')->count();

                // Total denda belum dibayar
                $unpaidFinesCount = Fine::where('is_paid', false)->count();

                $books = Book::latest()->take(5)->get(); // 5 buku terbaru
                $activeLoans = Loan::with('user', 'book')->whereIn('status', ['pending', 'approved'])->latest()->take(5)->get(); // 5 pinjaman terbaru
                $returnedLoans = Loan::with('user', 'book')->where('status', 'returned')->latest()->take(5)->get(); // 5 pengembalian terbaru
                $unpaidFines = Fine::with('loan.user', 'loan.book')->where('is_paid', false)->latest()->take(5)->get(); // 5 denda belum dibayar

                return view('section.dashboard', compact(
                    'totalBooks',
                    'activeLoansCount',
                    'returnedLoansCount',
                    'unpaidFinesCount',
                    'books',
                    'activeLoans',
                    'returnedLoans',
                    'unpaidFines'
                ));
            }
            elseif(Auth::user()->role === 'Admin'){
                $totalUsers = User::count();
                $totalBooks = Book::count();
                $totalLoans = Loan::count();
                $totalFines = Fine::count();
            
                // Daftar data
                $latestUsers = User::latest()->take(5)->get(); // 5 pengguna terbaru
                $latestLoans = Loan::with('user', 'book')->latest()->take(5)->get(); // 5 peminjaman terbaru
                $unpaidFines = Fine::with('loan.user', 'loan.book')->where('is_paid', false)->latest()->take(5)->get(); // 5 denda belum dibayar
            
                return view('section.dashboard', compact(
                    'totalUsers',
                    'totalBooks',
                    'totalLoans',
                    'totalFines',
                    'latestUsers',
                    'latestLoans',
                    'unpaidFines'
                ));
            }
    }
    
}