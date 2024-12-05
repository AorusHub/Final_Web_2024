@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('pagetitle')
<div class="pagetitle">
    <h1>Catalog</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href={{route('home.index')}}>Home</a></li>
        <li class="breadcrumb-item active">Loan</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@endsection

@section('main')
<div class="container">
    <h1 class="my-4">Daftar Peminjaman</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Buku</th>
                <th>Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Pengembalian</th>
                <th>Tanggal dikembalikan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $loan->book->title }}</td>
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->loan_date }}</td>
                <td>{{ $loan->due_date }}</td>
                <td>{{ $loan->return_date }}</td>
                <td>
                    @if ($loan->status === 'approved')
                        <span class="badge bg-warning">Dipinjam</span>
                    @elseif ($loan->status === 'disapproved')
                        <span class="badge bg-success">Dilarang</span>
                    @elseif ($loan->status === 'cancelled')
                        <span class="badge bg-success">Dibatalkan</span>
                    @elseif ($loan->status === 'returned')
                        <span class="badge bg-success">Dikembalikan</span>
                    @elseif ($loan->status === 'lost')
                        <span class="badge bg-success">Hilang</span>
                    @else
                        <span class="badge bg-danger">Pending</span>
                    @endif
                </td>
                <td>
                    @if (Auth::user()->role !== 'Mahasiswa') <!-- Batasi akses mahasiswa -->
                        @if ($loan->status === 'pending')
                            <form action="{{ route('loans.confirm', $loan->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-primary">Konfirmasi</button>
                            </form>
                            <form action="{{ route('loans.disapprove', $loan->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-primary">Larang</button>
                            </form>
                        @elseif ($loan->status === 'approved')
                            <!-- Tombol Kembalikan -->
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#returnModal{{ $loan->id }}">
                                Kembalikan
                            </button>
                            @include('section.loan.return')
                
                            <form action="{{ route('loans.lost', $loan->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-danger">Hilang</button>
                            </form>

                        @endif
                    @endif
                    @if (Auth::user()->role === 'Mahasiswa')
                        @if ($loan->status === 'pending')
                            <form action="{{ route('loans.cancel', $loan->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-primary">Batalkan</button>
                            </form>
                        @else
                            <span class="badge bg-success"> - </span>
                        @endif

                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $loans->links() }}
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil semua modal yang relevan
        const loanModals = document.querySelectorAll('[id^="returnModal"]');

        loanModals.forEach(modal => {
            const onTimeRadio = modal.querySelector('.form-check-input[value="yes"]');
            const lateRadio = modal.querySelector('.form-check-input[value="no"]');
            const lateDaysInput = modal.querySelector('[id^="lateDaysInput"]');

            // Pastikan elemen-elemen ditemukan sebelum menambahkan event listener
            if (onTimeRadio && lateRadio && lateDaysInput) {
                onTimeRadio.addEventListener('change', function () {
                    if (this.checked) {
                        lateDaysInput.style.display = 'none';
                    }
                });

                lateRadio.addEventListener('change', function () {
                    if (this.checked) {
                        lateDaysInput.style.display = 'block';
                    }
                });
            }
        });
    });
</script>
@endsection

