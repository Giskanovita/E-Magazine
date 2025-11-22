@extends('main')
@section('content')
<!-- Page Title -->
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Kategori</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="current">Kategori</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>Kategori Artikel</h2>
      <div class="row">
        @forelse($kategori as $kat)
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
              @php
                $icons = ['bi-laptop', 'bi-trophy', 'bi-palette', 'bi-book', 'bi-newspaper', 'bi-camera', 'bi-music-note', 'bi-globe'];
                $colors = ['#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6f42c1', '#fd7e14', '#20c997'];
                $icon = $icons[($loop->index) % count($icons)];
                $color = $colors[($loop->index) % count($colors)];
              @endphp
              <i class="bi {{ $icon }}" style="font-size: 3rem; color: {{ $color }};"></i>
              <h5 class="card-title mt-3">{{ $kat->nama_kategori }}</h5>
              <p class="card-text text-muted">{{ $kat->artikel_count }} artikel tersedia</p>
              <a href="/kategori/{{ $kat->id_kategori }}" class="btn btn-outline-primary">Lihat Artikel</a>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center">
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Belum ada kategori yang tersedia.
          </div>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection