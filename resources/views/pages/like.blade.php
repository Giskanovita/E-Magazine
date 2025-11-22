@extends('main')
@section('content')
<!-- Page Title -->
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Like</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="current">Like</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      @auth
        <h2>Artikel yang Anda Sukai</h2>
        @if($liked_articles->count() > 0)
          <div class="row">
            @foreach($liked_articles as $item)
            <div class="col-md-12 mb-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" class="img-fluid rounded" alt="{{ $item->judul }}" style="height: 150px; width: 100%; object-fit: cover;">
                      @else
                        <img src="{{ asset('assets/img/post-landscape-1.jpg') }}" class="img-fluid rounded" alt="{{ $item->judul }}" style="height: 150px; width: 100%; object-fit: cover;">
                      @endif
                    </div>
                    <div class="col-md-9">
                      <span class="badge bg-primary mb-2">{{ $item->kategori->nama_kategori ?? 'Umum' }}</span>
                      <h5 class="card-title">{{ $item->judul }}</h5>
                      <p class="card-text">{{ Str::limit(strip_tags($item->isi), 150) }}</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Oleh: {{ $item->user->nama ?? 'Admin' }} | {{ $item->tanggal }}</small>
                        <div>
                          <span class="badge bg-danger me-2"><i class="bi bi-heart-fill"></i> {{ $item->likes->count() }} Likes</span>
                          <a href="/artikel/{{ $item->id_artikel }}" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        @else
          <div class="text-center py-5">
            <i class="bi bi-heart display-1 text-muted"></i>
            <h4 class="mt-3">Belum Ada Artikel yang Disukai</h4>
            <p class="text-muted">Mulai menyukai artikel untuk melihatnya di sini</p>
            <a href="/artikel" class="btn btn-primary">Jelajahi Artikel</a>
          </div>
        @endif
      @else
        <div class="text-center py-5">
          <i class="bi bi-person-x display-1 text-muted"></i>
          <h4 class="mt-3">Login Diperlukan</h4>
          <p class="text-muted">Silakan login untuk melihat artikel yang Anda sukai</p>
          <a href="/login" class="btn btn-primary">Login</a>
        </div>
      @endauth
    </div>
  </div>
</div>
@endsection