<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Fine;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    // Menampilkan daftar peminjaman untuk Pegawai/Admin
    public function indexLoan()
    {
        if (Auth::user()->role === 'Mahasiswa') {
            // Jika mahasiswa, tampilkan hanya data peminjaman miliknya
            $loans = Loan::with('book')
                ->where('user_id', Auth::id())
                ->paginate(10);
        } else {
            // Jika Pegawai/Admin, tampilkan semua data peminjaman
            $loans = Loan::with('book', 'user')
            ->where('status', '!=', 'cancelled') // Filter tidak termasuk yang dibatalkan
            ->paginate(10);
        }
        return view('section.loan', compact('loans'));
    }

    // Menampilkan daftar denda

    // Mahasiswa mengajukan peminjaman buku
    public function requestLoan($bookId)
    {
        $book = Book::findOrFail($bookId);
    
        // Validasi apakah stok tersedia
        if ($book->stock <= 0) {
            return back()->with('error', 'Buku ini sedang tidak tersedia.');
        }
    
        // Validasi apakah mahasiswa sudah meminjam buku yang sama
        $existingLoan = Loan::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->exists();
    
        if ($existingLoan) {
            return back()->with('error', 'Anda sudah memiliki pinjaman aktif untuk buku ini.');
        }
    
        // Validasi maksimal 3 peminjaman
        $activeLoansCount = Loan::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->count();
    
        if ($activeLoansCount >= 3) {
            return back()->with('error', 'Anda hanya diperbolehkan meminjam maksimal 3 buku sekaligus.');
        }
    
        // Ajukan peminjaman (tanpa due_date)
        Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'status' => 'pending', // Status awal: pending
        ]);
    
        return back()->with('success', 'Permintaan peminjaman berhasil diajukan. Menunggu konfirmasi.');
    }
    
    

    // Pegawai mengonfirmasi peminjaman
    public function confirmLoan($loanId)
    {
        $loan = Loan::findOrFail($loanId);
    
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }
    
        // Set status ke 'approved' dan tetapkan due_date
        $loan->update([
            'status' => 'approved',
            'loan_date' => now(),
            'due_date' => now()->addDays(14), // Default batas pengembalian: 14 hari
        ]);
    
        $loan->book->decrement('stock'); // Kurangi stok buku
    
        return back()->with('success', 'Peminjaman telah dikonfirmasi.');
    }
    

    public function disapproveLoan($loanId)
    {
        $loan = Loan::findOrFail($loanId);

        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $loan->status = 'disapproved';
        $loan->save();

        return back()->with('success', 'Berhasil melarang mahasiswa untuk meminjam.');
    }

    public function cancelLoan($loanId)
    {
        $loan = Loan::findOrFail($loanId);

        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $loan->status = 'cancelled';
        $loan->save();

        return back()->with('success', 'Peminjaman telah dikonfirmasi.');
    }

    // Pegawai mengonfirmasi pengembalian
    public function returnLoan($loanId, Request $request)
    {
        $loan = Loan::findOrFail($loanId);
    
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Pengembalian hanya untuk buku yang sedang dipinjam.');
        }
    
        // Logika pengembalian
        $isOnTime = $request->input('on_time') === 'yes';
        if (!$isOnTime) {
            $lateDays = $request->input('late_days', 0);
            if ($lateDays > 0) {
                Fine::create([
                    'loan_id' => $loan->id,
                    'amount' => $lateDays * 1000, // Denda Rp.1000 per hari keterlambatan
                    'reason' => 'Terlambat mengembalikan buku',
                    'is_paid' => false,
                ]);
            }
        }
    
        // Perbarui status peminjaman
        $loan->status = 'returned';
        $loan->return_date = now();
        $loan->book->increment('stock'); // Tambah stok buku kembali
        $loan->save();
    
        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
    

    public function returnLate($loanId)
    {
        $loan = Loan::findOrFail($loanId);

        if ($loan->status !== 'approved') {
            return back()->with('error', 'Pengembalian hanya untuk buku yang dipinjam.');
        }

        // Hitung denda jika terlambat
        $lateDays = now()->diffInDays($loan->due_date, false);
        if ($lateDays < 0) {
            Fine::create([
                'loan_id' => $loan->id,
                'amount' => abs($lateDays) * 1000, // Denda Rp1000 per hari terlambat
                'reason' => 'Terlambat mengembalikan buku',
                'is_paid' => false,
            ]);
        }

        $loan->status = 'returned';
        $loan->return_date = now();
        $loan->book->increment('stock'); // Tambahkan stok buku
        $loan->save();

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    // Pegawai menandai buku hilang
    public function markAsLost($loanId)
    {
        $loan = Loan::findOrFail($loanId);

        if ($loan->status !== 'approved') {
            return back()->with('error', 'Hanya bisa menandai buku yang dipinjam.');
        }

        Fine::create([
            'loan_id' => $loan->id,
            'amount' => $loan->book->price + 35000, // Harga buku sebagai denda
            'reason' => 'Buku hilang',
            'is_paid' => false,
        ]);

        $loan->status = 'lost';
        $loan->is_lost = 1;
        $loan->save();

        return back()->with('success', 'Buku telah ditandai sebagai hilang.');
    }

    // Mahasiswa membayar denda
    public function payFine($fineId)
    {
        $fine = Fine::findOrFail($fineId);

        if ($fine->is_paid) {
            return back()->with('error', 'Denda ini sudah lunas.');
        }

        $fine->is_paid = true;
        $fine->save();

        return back()->with('success', 'Denda berhasil dibayar.');
    }
}

