@extends('layouts.app')

@section('title','Home')

@section('pagetitle')

<div class="pagetitle">
    <h1>Home</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Home</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@endsection

@section('main')
<section class="section">
  <div class="row">
    <!-- Hero Section with Background Image -->
    <div class="col-lg-12">
        <div class="card mb-4" style="position: relative; overflow: hidden;">
            <!-- Hero Image as background -->
            <div class="card-img" 
                 style="background-image: url('{{ asset('images/back.jpg') }}'); 
                        height: 400px;
                        weight:400px; 
                        background-size: cover; 
                        background-position: center; 
                        position: absolute; 
                        top: 0; 
                        left: 0; 
                        right: 0; 
                        bottom: 0;">
            </div>

            <!-- Optional Overlay for better contrast -->
            <div class="overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.4); z-index: 1;"></div>

            <!-- Card body with text on top of background image -->
            <div class="card-body text-center" style="position: relative; z-index: 2;">
                <h1 class="card-title text-white">Selamat Datang di Perpustakaan Kami!</h1>
                <p class="text-white">Temukan berbagai koleksi buku dan berbagai fitur menarik di perpustakaan kami. Ayo mulai menjelajah sekarang!</p>
                <div>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg">Jelajahi Buku</a>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
@endsection

