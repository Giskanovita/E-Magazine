@extends('main')
@section('content')
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Buat Artikel</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="{{ route('manajemen.artikel.index') }}">Manajemen Artikel</a></li>
        <li class="current">Buat Artikel</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5>Form Artikel Baru</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('manajemen.artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
              <label class="form-label">Judul</label>
              <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
              @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Kategori</label>
              <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $kat)
                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                  {{ $kat->nama_kategori }}
                </option>
                @endforeach
              </select>
              @error('id_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Isi Artikel</label>
              <textarea name="isi" rows="10" class="form-control @error('isi') is-invalid @enderror" required>{{ old('isi') }}</textarea>
              @error('isi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
              @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Foto</label>
              <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
              @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Lampiran (Gambar/Dokumen)</label>
              <input type="file" name="lampiran[]" class="form-control @error('lampiran.*') is-invalid @enderror" multiple>
              <small class="text-muted">Bisa upload multiple file (max 5MB per file)</small>
              @error('lampiran.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="publikasi" {{ old('status') == 'publikasi' ? 'selected' : '' }}>Publikasi</option>
              </select>
              @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between">
              <a href="{{ route('manajemen.artikel.index') }}" class="btn btn-secondary">Kembali</a>
              <button type="submit" class="btn btn-primary">Simpan Artikel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection