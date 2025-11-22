@extends('main')
@section('content')
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Dashboard Guru</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="current">Dashboard Guru</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Selamat Datang{{ Auth::check() ? ', ' . Auth::user()->nama : ' di Dashboard Guru' }}</h2>
    <a href="{{ route('guru.artikel.index') }}" class="btn btn-primary">
      <i class="bi bi-file-text"></i> Kelola Artikel
    </a>
  </div>

  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-center text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);">
        <div class="card-body">
          <i class="bi bi-file-text fs-1"></i>
          <h3>{{ $totalArtikel }}</h3>
          <p>Total Artikel</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center text-white" style="background: linear-gradient(135deg, #fdcb6e 0%, #e17055 100%); border: none; box-shadow: 0 8px 32px rgba(253, 203, 110, 0.3);">
        <div class="card-body">
          <i class="bi bi-file-earmark fs-1"></i>
          <h3>{{ $artikelDraft }}</h3>
          <p>Draft</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center text-white" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); border: none; box-shadow: 0 8px 32px rgba(86, 171, 47, 0.3);">
        <div class="card-body">
          <i class="bi bi-check-circle fs-1"></i>
          <h3>{{ $artikelPublish }}</h3>
          <p>Dipublikasi</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center text-white" style="background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); border: none; box-shadow: 0 8px 32px rgba(116, 185, 255, 0.3);">
        <div class="card-body">
          <i class="bi bi-chat-dots fs-1"></i>
          <h3>{{ $totalKomentar }}</h3>
          <p>Komentar</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
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
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($artikelTerbaru as $artikel)
                <tr>
                  <td>{{ Str::limit($artikel->judul, 40) }}</td>
                  <td>{{ $artikel->kategori->nama_kategori ?? 'Umum' }}</td>
                  <td>
                    <span class="badge {{ $artikel->status == 'publikasi' ? 'bg-success' : 'bg-warning' }}">
                      {{ ucfirst($artikel->status) }}
                    </span>
                  </td>
                  <td>{{ $artikel->tanggal }}</td>
                  <td>
                    <a href="{{ route('guru.artikel.edit', $artikel->id_artikel) }}" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-pencil"></i>
                    </a>
                  </td>
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
    
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h5>Menu Guru</h5>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="{{ route('guru.artikel.create') }}" class="btn btn-success">
              <i class="bi bi-plus-circle"></i> Buat Artikel Baru
            </a>
            <a href="{{ route('guru.artikel.index') }}" class="btn btn-primary">
              <i class="bi bi-list"></i> Kelola Artikel
            </a>
            <a href="{{ route('guru.moderasi.index') }}" class="btn btn-warning">
              <i class="bi bi-shield-check"></i> Moderasi Artikel
            </a>
            <a href="/artikel" class="btn btn-info">
              <i class="bi bi-newspaper"></i> Lihat Semua Artikel
            </a>
            <a href="/like" class="btn btn-outline-danger">
              <i class="bi bi-heart"></i> Artikel Favorit
            </a>
          </div>
        </div>
      </div>
      
      @if($notifications->count() > 0)
      <div class="card mt-3">
        <div class="card-header">
          <h5>Notifikasi Terbaru</h5>
        </div>
        <div class="card-body">
          @foreach($notifications as $notif)
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ $notif->title }}</strong><br>
            <small>{{ $notif->message }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          @endforeach
        </div>
      </div>
      @endif
      
      <div class="card mt-3">
        <div class="card-header">
          <h5>Tips untuk Guru</h5>
        </div>
        <div class="card-body">
          <ul class="list-unstyled">
            <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Tulis artikel yang menarik dan edukatif</li>
            <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Gunakan foto yang relevan</li>
            <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Tambahkan lampiran jika diperlukan</li>
            <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Publikasikan artikel berkualitas</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection