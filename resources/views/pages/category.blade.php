@extends('main')
@section('content')
<!-- Page Title -->
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Kategori: {{ $kategori->nama_kategori }}</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li><a href="/artikel">Artikel</a></li>
        <li class="current">{{ $kategori->nama_kategori }}</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-9">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $kategori->nama_kategori }}</h2>
        <span class="badge bg-secondary">{{ $artikel->total() }} artikel</span>
      </div>
      
      <div class="row">
        @forelse($artikel as $item)
        <div class="col-md-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="{{ asset('assets/img/pahlawan.jpeg') }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <span class="badge bg-primary mb-2 align-self-start">{{ $item->kategori->nama_kategori }}</span>
              <h5 class="card-title">{{ Str::limit($item->judul, 50) }}</h5>
              <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
              <div class="d-flex justify-content-between align-items-center mt-auto">
                <small class="text-muted">Oleh: {{ $item->user->name ?? 'Admin' }} | {{ $item->tanggal }}</small>
                <div>
                  <span class="text-muted me-2"><i class="bi bi-heart"></i> {{ $item->likes->count() }}</span>
                  <a href="/artikel/{{ $item->id_artikel }}" class="btn btn-outline-primary btn-sm">Baca</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
          <i class="bi bi-journal-x display-1 text-muted"></i>
          <h4 class="mt-3">Belum Ada Artikel</h4>
          <p class="text-muted">Belum ada artikel dalam kategori {{ $kategori->nama_kategori }}.</p>
          <a href="/artikel" class="btn btn-primary">Lihat Semua Artikel</a>
        </div>
        @endforelse
      </div>
      
      @if($artikel->hasPages())
      <div class="d-flex justify-content-center">
        {{ $artikel->links() }}
      </div>
      @endif
    </div>
    
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          <h5>Kategori Lainnya</h5>
        </div>
        <div class="card-body">
          @php
            $allKategori = App\Models\Kategori::withCount('artikel')->get();
          @endphp
          @foreach($allKategori as $kat)
          <a href="/kategori/{{ $kat->id_kategori }}" class="d-block text-decoration-none mb-2 {{ $kat->id_kategori == $kategori->id_kategori ? 'fw-bold text-primary' : '' }}">
            <i class="bi bi-folder"></i> {{ $kat->nama_kategori }} ({{ $kat->artikel_count }})
          </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection