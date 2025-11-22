@extends('main')
@section('content')
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Edit Artikel</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="{{ route('manajemen.artikel.index') }}">Manajemen Artikel</a></li>
        <li class="current">Edit Artikel</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5>Edit Artikel: {{ Str::limit($artikel->judul, 50) }}</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('manajemen.artikel.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
              <label class="form-label">Judul</label>
              <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $artikel->judul) }}" required>
              @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Kategori</label>
              <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $kat)
                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $artikel->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                  {{ $kat->nama_kategori }}
                </option>
                @endforeach
              </select>
              @error('id_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Isi Artikel</label>
              <textarea name="isi" rows="10" class="form-control @error('isi') is-invalid @enderror" required>{{ old('isi', $artikel->isi) }}</textarea>
              @error('isi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $artikel->tanggal) }}" required>
              @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Foto</label>
              @if($artikel->foto)
              <div class="mb-2">
                <img src="{{ asset('storage/'.$artikel->foto) }}" alt="Foto saat ini" style="max-width: 200px; height: auto;">
                <p class="text-muted small">Foto saat ini</p>
              </div>
              @endif
              <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
              <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
              @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Lampiran Saat Ini</label>
              @if($artikel->lampiran && count($artikel->lampiran) > 0)
              <div class="mb-2">
                @foreach($artikel->lampiran as $file)
                <div class="d-flex align-items-center mb-1">
                  <i class="bi bi-file-earmark me-2"></i>
                  <span>{{ $file['name'] }} ({{ number_format($file['size']/1024, 1) }} KB)</span>
                </div>
                @endforeach
              </div>
              @else
              <p class="text-muted small">Tidak ada lampiran</p>
              @endif
              
              <label class="form-label">Upload Lampiran Baru</label>
              <input type="file" name="lampiran[]" class="form-control @error('lampiran.*') is-invalid @enderror" multiple>
              <small class="text-muted">Upload file baru akan mengganti lampiran lama</small>
              @error('lampiran.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="draft" {{ old('status', $artikel->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="publikasi" {{ old('status', $artikel->status) == 'publikasi' ? 'selected' : '' }}>Publikasi</option>
              </select>
              @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between">
              <a href="{{ route('manajemen.artikel.index') }}" class="btn btn-secondary">Kembali</a>
              <button type="submit" class="btn btn-primary">Update Artikel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection