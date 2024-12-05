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
    <h1>Hasil Pencarian</h1>
    @if($books->isEmpty())
      <p>Tidak ada buku yang ditemukan.</p>
    @else
      <ul>
        <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($books as $book)
        <div class="col">
            <div class="card h-100">
                <div class="d-flex align-items-start">
                    <!-- Gambar di sebelah kiri -->
                    @if ($book->image_path)
                        <img src="{{ $book->image_path }}" alt="Gambar Buku {{ $book->title }}" class="img-fluid rounded-start me-3" style="max-height: 200px; max-width: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-book.png') }}" alt="Default Gambar Buku" class="img-fluid rounded-start" style="max-height: 300px; max-width: 100%; object-fit: cover;">
                    @endif
                    <!-- Konten teks di sebelah kanan -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">
                            <strong>Penulis:</strong> {{ $book->author }} <br>
                            <strong>Kategori:</strong> {{ $book->category }}
                        </p>
                        <a href="{{ route('catalog.show', $book->id) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
      </ul>
    @endif
  </div>
@endsection