@extends('main')
@section('content')
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Edit Artikel</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li><a href="{{ route('siswa.dashboard') }}">Dashboard Siswa</a></li>
        <li><a href="{{ route('siswa.artikel.index') }}">Kelola Artikel</a></li>
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
          <h5>Edit Artikel</h5>
          <small class="text-muted">Artikel yang sudah dipublikasi tidak dapat diedit</small>
        </div>
        <div class="card-body">
          <form action="{{ route('siswa.artikel.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
              <label for="judul" class="form-label">Judul Artikel</label>
              <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                     id="judul" name="judul" value="{{ old('judul', $artikel->judul) }}" required>
              @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="id_kategori" class="form-label">Kategori</label>
              <select class="form-select @error('id_kategori') is-invalid @enderror" 
                      id="id_kategori" name="id_kategori" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $kat)
                  <option value="{{ $kat->id_kategori }}" 
                          {{ old('id_kategori', $artikel->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                  </option>
                @endforeach
              </select>
              @error('id_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="isi" class="form-label">Isi Artikel</label>
              <textarea class="form-control @error('isi') is-invalid @enderror" 
                        id="isi" name="isi" rows="10" required>{{ old('isi', $artikel->isi) }}</textarea>
              @error('isi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="foto" class="form-label">Foto Artikel (Opsional)</label>
              @if($artikel->foto)
                <div class="mb-2">
                  <img src="{{ asset('storage/' . $artikel->foto) }}" alt="Current foto" class="img-thumbnail" style="max-width: 200px;">
                  <p class="text-muted small">Foto saat ini</p>
                </div>
              @endif
              <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                     id="foto" name="foto" accept="image/*">
              <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB.</div>
              @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="alert alert-info">
              <i class="bi bi-info-circle"></i>
              <strong>Catatan:</strong> Artikel yang telah diedit akan dikirim ulang untuk persetujuan guru.
            </div>

            <div class="d-flex justify-content-between">
              <a href="{{ route('siswa.artikel.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Update Artikel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection