@extends('main')
@section('content')
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Kelola Artikel Guru</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li><a href="{{ route('guru.dashboard') }}">Dashboard Guru</a></li>
        <li class="current">Kelola Artikel</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Artikel Saya</h2>
    <a href="{{ route('guru.artikel.create') }}" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Buat Artikel Baru
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($artikel->count() > 0)
    <div class="card">
      <div class="card-body">
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
              @foreach($artikel as $item)
              <tr>
                <td>{{ Str::limit($item->judul, 50) }}</td>
                <td>{{ $item->kategori->nama_kategori ?? 'Umum' }}</td>
                <td>
                  <span class="badge {{ $item->status == 'publikasi' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($item->status) }}
                  </span>
                </td>
                <td>{{ $item->tanggal }}</td>
                <td>
                  <a href="/artikel/{{ $item->id_artikel }}" class="btn btn-sm btn-outline-info" target="_blank">
                    <i class="bi bi-eye"></i>
                  </a>
                  <a href="{{ route('guru.artikel.edit', $item->id_artikel) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        {{ $artikel->links() }}
      </div>
    </div>
  @else
    <div class="card">
      <div class="card-body text-center">
        <i class="bi bi-file-text fs-1 text-muted"></i>
        <h4 class="mt-3">Belum Ada Artikel</h4>
        <p class="text-muted">Anda belum membuat artikel apapun.</p>
        <a href="{{ route('guru.artikel.create') }}" class="btn btn-success">
          <i class="bi bi-plus-circle"></i> Buat Artikel Pertama
        </a>
      </div>
    </div>
  @endif
</div>
@endsection