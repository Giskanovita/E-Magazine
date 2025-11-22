@extends('main')
@section('content')
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Moderasi Artikel Siswa</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li><a href="{{ route('guru.dashboard') }}">Dashboard Guru</a></li>
        <li class="current">Moderasi</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Artikel Siswa Menunggu Persetujuan</h2>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if($artikelSiswa->count() > 0)
    <div class="row">
      @foreach($artikelSiswa as $artikel)
        <div class="col-md-6 mb-4">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h6 class="mb-0">{{ $artikel->user->nama }}</h6>
              <span class="badge bg-warning">{{ ucfirst($artikel->status) }}</span>
            </div>
            <div class="card-body">
              <h5 class="card-title">{{ $artikel->judul }}</h5>
              <p class="card-text">{{ Str::limit($artikel->isi, 150) }}</p>
              <p class="text-muted small">
                <i class="bi bi-calendar"></i> {{ $artikel->tanggal }} | 
                <i class="bi bi-tag"></i> {{ $artikel->kategori->nama_kategori ?? 'Umum' }}
              </p>
            </div>
            <div class="card-footer d-flex justify-content-between">
              <a href="/artikel/{{ $artikel->id_artikel }}" class="btn btn-sm btn-outline-info" target="_blank">
                <i class="bi bi-eye"></i> Lihat Detail
              </a>
              <form action="{{ route('guru.moderasi.approve', $artikel->id_artikel) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-success" 
                        onclick="return confirm('Setujui artikel ini untuk dipublikasi?')">
                  <i class="bi bi-check-circle"></i> Setujui
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    
    {{ $artikelSiswa->links() }}
  @else
    <div class="card">
      <div class="card-body text-center">
        <i class="bi bi-shield-check fs-1 text-muted"></i>
        <h4 class="mt-3">Tidak Ada Artikel Menunggu</h4>
        <p class="text-muted">Semua artikel siswa sudah disetujui atau belum ada yang dikirim.</p>
      </div>
    </div>
  @endif
</div>
@endsection