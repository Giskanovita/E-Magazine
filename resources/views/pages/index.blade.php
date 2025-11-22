@extends('main')
@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('assets/img/bn666.jpeg') }}'); background-size: cover; background-position: center; min-height: 60vh; display: flex; align-items: center;">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center text-white">
        <h1 class="display-4 fw-bold mb-4" style="color: white;"><i class="bi bi-journal-bookmark"></i> E-Magazine Sekolah</h1>
        <p class="lead mb-4">Platform Digital untuk Berbagi Karya dan Prestasi Siswa</p>
        @auth
          <div class="mb-4">
            <p class="h5">Selamat datang, {{ auth()->user()->nama }}!</p>
            @if(auth()->user()->role == 'admin')
              <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg me-2">Dashboard Admin</a>
            @elseif(auth()->user()->role == 'guru')
              <a href="{{ route('guru.dashboard') }}" class="btn btn-primary btn-lg me-2">Dashboard Guru</a>
            @else
              <a href="{{ route('siswa.dashboard') }}" class="btn btn-primary btn-lg me-2">Dashboard Siswa</a>
            @endif
            <form method="POST" action="/logout" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-outline-light btn-lg">Logout</button>
            </form>
          </div>
        @else
          <div class="mb-4">
            <a href="/artikel" class="btn btn-outline-light btn-lg">Lihat Artikel</a>
          </div>
        @endauth
      </div>
    </div>
  </div>
</section>

<!-- Latest Articles Section -->
<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center mb-5">
        <h2 class="fw-bold">Artikel Terbaru</h2>
        <p class="text-muted">Baca artikel dan berita terbaru dari sekolah</p>
      </div>
    </div>
    <div class="row">
      @forelse($artikelTerbaru as $item)
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
          @if($item->foto)
            <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
          @else
            <img src="{{ asset('assets/img/post-landscape-1.jpg') }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
          @endif
          <div class="card-body d-flex flex-column">
            <span class="badge bg-primary mb-2 align-self-start">{{ $item->kategori->nama_kategori ?? 'Umum' }}</span>
            <h5 class="card-title">{{ Str::limit($item->judul, 50) }}</h5>
            <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
            <div class="d-flex justify-content-between align-items-center mt-auto">
              <small class="text-muted">{{ $item->tanggal }}</small>
              <a href="/artikel/{{ $item->id_artikel }}" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12 text-center">
        <p class="text-muted">Belum ada artikel yang dipublikasikan.</p>
      </div>
      @endforelse
    </div>
    @if($artikelTerbaru->count() > 0)
    <div class="row mt-4">
      <div class="col-12 text-center">
        <a href="/artikel" class="btn btn-primary">Lihat Semua Artikel</a>
      </div>
    </div>
    @endif
  </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center mb-5">
        <h2 class="fw-bold">Kategori</h2>
        <p class="text-muted">Jelajahi artikel berdasarkan kategori</p>
      </div>
    </div>
    <div class="row">
      @forelse($kategori as $kat)
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-center h-100 shadow-sm">
          <div class="card-body">
            <i class="bi bi-folder2-open display-4 text-primary mb-3"></i>
            <h5 class="card-title">{{ $kat->nama_kategori }}</h5>
            <p class="card-text text-muted">{{ $kat->artikel_count }} artikel</p>
            <a href="/kategori/{{ $kat->id_kategori }}" class="btn btn-outline-primary">Lihat Artikel</a>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12 text-center">
        <p class="text-muted">Belum ada kategori yang tersedia.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>
@endsection