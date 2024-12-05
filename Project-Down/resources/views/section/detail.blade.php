@extends('layouts.app')

@section('title','Detail Buku')

@section('pagetitle')
<div class="pagetitle">
    <h1>Catalog</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href={{route('home.index')}}>Home</a></li>
        <li class="breadcrumb-item"><a href={{route('catalog.index')}}>Catalog</a></li>
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>
</div><!-- End Page Title -->
@endsection

@section('main')
<div class="container my-5">
    <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary mb-4">Kembali ke Katalog</a>
    <div class="card">
        <div class="row g-0">
            <!-- Kolom untuk Gambar -->
            <div class="col-md-3">
              @if ($book->image_path)
                  <img src="{{ $book->image_path }}" alt="Gambar Buku {{ $book->title }}" class="img-fluid rounded-start" style="max-height: 300px; max-width: 100%; object-fit: cover;">
              @else
                  <img src="{{ asset('images/default-book.png') }}" alt="Default Gambar Buku" class="img-fluid rounded-start" style="max-height: 300px; max-width: 100%; object-fit: cover;">
              @endif
          </div>
          
            <!-- Kolom untuk Detail -->
            <div class="col-md-8">
                <div class="card-body">
                    <h1 class="card-title">{{ $book->title }}</h1>
                    <p class="card-text">
                        <strong>Penulis:</strong> {{ $book->author }} <br>
                        <strong>Penerbit:</strong> {{ $book->publisher }} <br>
                        <strong>Kategori:</strong> {{ $book->category }} <br>
                        <strong>Harga:</strong> Rp{{ number_format($book->price, 0, ',', '.') }} <br>
                        <strong>Stok:</strong> {{ $book->stock }} <br>
                        <strong>Deskripsi:</strong> <br> {{ $book->description }}
                    </p>

                    @if (auth()->check() && auth()->user()->role === 'Mahasiswa')
                        <form action="{{ route('loans.request', $book->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary">Ajukan Peminjaman</button>
                        </form>
                    @endif

                    @if (auth()->check() && (auth()->user()->role === 'Pegawai'|| auth()->user()->role === 'Admin'))
                    <!-- Tombol Edit dan Delete -->
                      <div class="d-flex justify-content-end">
                          <!-- Tombol Edit -->
                          <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editBookModal">Edit</button>

                          <!-- Tombol Hapus -->
                          <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBookModal{{ $book->id }}">Hapus</button>
                      </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('section.catalog.edit_catalog')
@include('section.catalog.delete_catalog')
@endsection
