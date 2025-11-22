@extends('main')
@section('content')
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Manajemen Artikel</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li><a href="/dashboard">Dashboard</a></li>
        <li class="current">Manajemen Artikel</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Artikel Saya</h2>
    <a href="{{ route('manajemen.artikel.create') }}" class="btn btn-primary">
      <i class="bi bi-plus"></i> Buat Artikel
    </a>
  </div>

  <div class="card">
    <div class="card-body">
      @if($artikel->count() > 0)
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Foto</th>
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
              <td>
                @if($item->foto)
                <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                  <i class="bi bi-image text-muted"></i>
                </div>
                @endif
              </td>
              <td>
                {{ Str::limit($item->judul, 40) }}
                @if($item->lampiran && count($item->lampiran) > 0)
                <br><small class="text-muted"><i class="bi bi-paperclip"></i> {{ count($item->lampiran) }} lampiran</small>
                @endif
              </td>
              <td>{{ $item->kategori->nama_kategori ?? 'Umum' }}</td>
              <td>
                <span class="badge {{ $item->status == 'publikasi' ? 'bg-success' : 'bg-warning' }}">
                  {{ ucfirst($item->status) }}
                </span>
              </td>
              <td>{{ $item->tanggal }}</td>
              <td>
                <a href="{{ route('manajemen.artikel.edit', $item->id_artikel) }}" class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('manajemen.artikel.destroy', $item->id_artikel) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus artikel ini?')">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
      {{ $artikel->links() }}
      @else
      <div class="text-center py-4">
        <i class="bi bi-file-text display-1 text-muted"></i>
        <p class="text-muted mt-2">Belum ada artikel. <a href="{{ route('manajemen.artikel.create') }}">Buat artikel pertama</a></p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection