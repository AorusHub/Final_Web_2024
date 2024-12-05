@extends('layouts.app')

@section('title','Dashboard')

@section('pagetitle')

<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href={{route('home.index')}}>Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@endsection


@section('main')
<div class="container">
    <h2 class="my-4">Selamat Datang, {{ Auth::user()->name }}</h2>
    @if(Auth::check())

      @if(auth()->user()->role === 'Mahasiswa')

        <div class="row text-center">
          <!-- Kotak Total Pinjaman Aktif -->
          <div class="col-md-3">
              <div class="card bg-info text-white">
                  <div class="card-body">
                      <h5 class="card-title">Pinjaman Aktif</h5>
                      <br>
                      <p class="card-text fs-3">{{ $PinjamAktif }}</p>
                  </div>
              </div>
          </div>

          <!-- Kotak Total Biaya Denda -->
          <div class="col-md-3">
              <div class="card bg-warning text-dark">
                  <div class="card-body">
                      <h5 class="card-title">Total Denda</h5>
                      <BR>
                      <p class="card-text fs-3">Rp{{ number_format($totalDenda, 0, ',', '.') }}</p>
                  </div>
              </div>
          </div>

          <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h5 class="card-title">Jumlah buku yang tersedia</h5>
                    <p class="card-text fs-3">{{$BukuSedia}}</p>
                </div>
            </div>
          </div>


          <!-- Kotak Buku yang Bisa Dipinjam -->
          <div class="col-md-3">
              <div class="card bg-success text-white">
                  <div class="card-body">
                      <h5 class="card-title">Buku yang Bisa Dipinjam</h5>
                      <p class="card-text fs-3">{{ $remainingLoans }}</p>
                  </div>
              </div>
          </div>
        </div>

        <!-- Daftar Peminjaman Aktif -->
        <div class="row">
          <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Peminjaman Aktif</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Batas Pengembalian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeLoans as $loan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->loan_date }}</td>
                                <td>{{ $loan->due_date }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $loan->status === 'approved' ? 'bg-warning' : '' }}
                                        {{ $loan->status === 'returned' ? 'bg-success' : '' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($activeLoans->isEmpty())
                    <p class="text-muted">Belum ada peminjaman aktif.</p>
                    @endif
                </div>
            </div>

        <!-- Riwayat Peminjaman -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Riwayat Peminjaman</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loanHistory as $loan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->loan_date }}</td>
                                <td>{{ $loan->return_date }}</td>
                                <td>
                                    <span class="badge bg-success">{{ ucfirst($loan->status) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($loanHistory->isEmpty())
                    <p class="text-muted">Belum ada riwayat peminjaman.</p>
                    @endif
                </div>
            </div>
          </div>

          <div class="col-lg-6">
        <!-- Daftar Denda -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Daftar Denda</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Buku</th>
                                <th>Alasan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fines as $fine)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $fine->loan->book->title }}</td>
                                <td>{{ $fine->reason }}</td>
                                <td>Rp{{ number_format($fine->amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $fine->is_paid ? 'bg-success' : 'bg-danger' }}">
                                        {{ $fine->is_paid ? 'Lunas' : 'Belum Lunas' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($fines->isEmpty())
                    <p class="text-muted">Tidak ada denda saat ini.</p>
                    @endif
                </div>
            </div>

        <!-- Katalog Buku -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Katalog Buku</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->stock }}</td>
                                <td>
                                    @if ($book->stock > 0)
                                    <form action="{{ route('loans.request', $book->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-primary">Pinjam</button>
                                    </form>
                                    @else
                                    <span class="text-muted">Stok habis</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
      </div>

      @elseif(auth()->user()->role === 'Pegawai')
      <div class="row text-center">
        <!-- Kotak Total Buku -->
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Buku</h5>
                    <p class="card-text fs-3">{{ $totalBooks }}</p>
                </div>
            </div>
        </div>

        <!-- Kotak Pinjaman Aktif -->
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Pinjaman Aktif</h5>
                    <p class="card-text fs-3">{{ $activeLoansCount }}</p>
                </div>
            </div>
        </div>

        <!-- Kotak Pengembalian -->
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Pengembalian</h5>
                    <p class="card-text fs-3">{{ $returnedLoansCount }}</p>
                </div>
            </div>
        </div>

        <!-- Kotak Denda Belum Dibayar -->
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Denda Belum Dibayar</h5>
                    <p class="card-text fs-3">{{ $unpaidFinesCount }}</p>
                </div>
            </div>
        </div>
    </div>

  <!-- Daftar Buku -->
    <div class="row">
      <div class="col-lg-6">
        <div class="my-4">
            <h2>Buku Terbaru</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($books->isEmpty())
            <p class="text-muted">Belum ada Buku di Katalog.</p>
            @endif
        </div>

        <!-- Daftar Pinjaman Aktif -->
        <div class="my-4">
            <h2>Pinjaman Aktif</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeLoans as $loan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->loan_date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($activeLoans->isEmpty())
            <p class="text-muted">Tidak ada yang sedang meminjam buku.</p>
            @endif
        </div>
      </div>

      <div class="col-lg-6">
        <!-- Daftar Pengembalian -->
        <div class="my-4">
            <h2>Pengembalian Terbaru</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returnedLoans as $loan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->return_date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($returnedLoans->isEmpty())
            <p class="text-muted">Belum ada yang mengembalikan buku.</p>
            @endif
        </div>

        <!-- Daftar Denda Belum Dibayar -->
        <div class="my-4">
            <h2>Denda Belum Dibayar</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Buku</th>
                        <th>Jumlah</th>
                        <th>Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unpaidFines as $fine)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $fine->loan->user->name }}</td>
                        <td>{{ $fine->loan->book->title }}</td>
                        <td>Rp{{ number_format($fine->amount, 0, ',', '.') }}</td>
                        <td>{{ $fine->reason }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($unpaidFines->isEmpty())
            <p class="text-muted">Tidak ada yang memiliki denda.</p>
            @endif
        </div>
      </div>
    </div>

      @else
          <!-- Statistik -->
          <div class="row text-center mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title text-white">Total Pengguna</h5>
                        <p class="card-text fs-3">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title text-white">Total Buku</h5>
                        <p class="card-text fs-3">{{ $totalBooks }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title text-white">Total Peminjaman</h5>
                        <p class="card-text fs-3">{{ $totalLoans }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title text-white">Total Denda</h5>
                        <p class="card-text fs-3">{{ $totalFines }}</p>
                    </div>
                </div>
            </div>
        </div>
        
      
          <!-- Daftar Pengguna Terbaru -->
          <div class="my-4">
              <h2>Pengguna Terbaru</h2>
              <table class="table">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Registrasi</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($latestUsers as $user)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ ucfirst($user->role) }}</td>
                          <td>{{ $user->created_at->format('d M Y') }}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      
          <!-- Daftar Peminjaman Terbaru -->
          <div class="my-4">
              <h2>Peminjaman Terbaru</h2>
              <table class="table">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Nama Peminjam</th>
                          <th>Buku</th>
                          <th>Status</th>
                          <th>Tanggal Pinjam</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($latestLoans as $loan)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $loan->user->name }}</td>
                          <td>{{ $loan->book->title }}</td>
                          <td>{{ ucfirst($loan->status) }}</td>
                          <td>{{ $loan->loan_date }}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      
          <!-- Daftar Denda Belum Dibayar -->
          <div class="my-4">
              <h2>Denda Belum Dibayar</h2>
              <table class="table">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Nama Peminjam</th>
                          <th>Buku</th>
                          <th>Jumlah</th>
                          <th>Alasan</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($unpaidFines as $fine)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $fine->loan->user->name }}</td>
                          <td>{{ $fine->loan->book->title }}</td>
                          <td>Rp{{ number_format($fine->amount, 0, ',', '.') }}</td>
                          <td>{{ $fine->reason }}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>   
      @endif
    @endif
</div>
@endsection
