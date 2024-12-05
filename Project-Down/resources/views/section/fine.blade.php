@extends('layouts.app')

@section('title', 'Daftar Denda')

@section('pagetitle')
<div class="pagetitle">
    <h1>Catalog</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href={{route('home.index')}}>Home</a></li>
        <li class="breadcrumb-item active">Fine</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@endsection

@section('main')
<div class="container">
    <h1 class="my-4">Daftar Denda</h1>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Buku</th>
                <th>Peminjam</th>
                <th>Jumlah</th>
                <th>Alasan</th>
                <th>Status</th>
                @if(Auth::user()->role === 'Pegawai')
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($fines as $fine)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $fine->loan->book->title }}</td>
                <td>{{ $fine->loan->user->name }}</td>
                <td>Rp{{ number_format($fine->amount, 0, ',', '.') }}</td>
                <td>{{ $fine->reason }}</td>
                <td>
                    @if ($fine->is_paid)
                        <span class="badge bg-success">Lunas</span>
                    @else
                        <span class="badge bg-danger">Belum Lunas</span>
                    @endif
                </td>
                @if(Auth::user()->role === 'Pegawai')
                <td>
                    @if (!$fine->is_paid)
                        <form action="{{ route('fines.pay', $fine->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-success">Bayar</button>
                        </form>
                    @else
                        <span class="badge text-secondary">Telah Bayar</span>
                    @endif
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $fines->links() }}
</div>
@endsection

