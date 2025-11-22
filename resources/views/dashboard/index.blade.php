@extends('main')
@section('content')
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Dashboard</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="current">Dashboard</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Ringkasan Dashboard</h2>
    <a href="{{ route('manajemen.artikel.index') }}" class="btn btn-primary">
      <i class="bi bi-file-text"></i> Kelola Artikel
    </a>
  </div>

  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-center bg-primary text-white">
        <div class="card-body">
          <i class="bi bi-file-text fs-1"></i>
          <h3>{{ $totalArtikel }}</h3>
          <p>Total Artikel</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center bg-warning text-white">
        <div class="card-body">
          <i class="bi bi-file-earmark fs-1"></i>
          <h3>{{ $artikelDraft }}</h3>
          <p>Draft</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center bg-success text-white">
        <div class="card-body">
          <i class="bi bi-check-circle fs-1"></i>
          <h3>{{ $artikelPublish }}</h3>
          <p>Dipublikasi</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center bg-info text-white">
        <div class="card-body">
          <i class="bi bi-chat-dots fs-1"></i>
          <h3>{{ $totalKomentar }}</h3>
          <p>Komentar</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>Artikel Terbaru Anda</h5>
        </div>
        <div class="card-body">
          @if($artikelTerbaru->count() > 0)
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Judul</th>
                  <th>Kategori</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($artikelTerbaru as $artikel)
                <tr>
                  <td>{{ Str::limit($artikel->judul, 50) }}</td>
                  <td>{{ $artikel->kategori->nama_kategori ?? 'Umum' }}</td>
                  <td>
                    <span class="badge {{ $artikel->status == 'publikasi' ? 'bg-success' : 'bg-warning' }}">
                      {{ ucfirst($artikel->status) }}
                    </span>
                  </td>
                  <td>{{ $artikel->tanggal }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <p class="text-muted">Belum ada artikel yang dibuat.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection