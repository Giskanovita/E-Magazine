@extends('main')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Kirim Artikel</h2>
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
            
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Artikel yang Anda kirim akan ditinjau oleh admin dan guru sebelum dipublikasikan.
            </div>
            
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('siswa.artikel.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Artikel</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select class="form-control" id="id_kategori" name="id_kategori" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto (Opsional)</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            <small class="form-text text-muted">Maksimal 2MB, format: JPG, PNG, GIF</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Artikel</label>
                            <textarea class="form-control" id="isi" name="isi" rows="10" required placeholder="Tulis artikel Anda di sini...">{{ old('isi') }}</textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Kirim untuk Ditinjau</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection