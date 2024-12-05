@extends('layouts.app')

@section('title','Catalog')

@section('pagetitle')
<div class="pagetitle">
    <h1>Catalog</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href={{route('home.index')}}>Home</a></li>
        <li class="breadcrumb-item active">Catalog</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@endsection

@section('main')
<div class="container my-5">
    <h1 class="text-center mb-4">Katalog Buku</h1>

    <!-- Tambah Buku -->
    @if (auth()->check() && (auth()->user()->role === 'Pegawai'|| auth()->user()->role === 'Admin'))
        <div class="text-end mb-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBookModal">Tambah Buku</button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($books as $book)
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

@include('section.catalog.add_catalog')
@endsection