@extends('main')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Buat Artikel Baru</h2>
                <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">Kembali</a>
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
                    <form method="POST" action="{{ route('guru.artikel.store') }}" enctype="multipart/form-data">
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
                        </div>
                        
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Artikel</label>
                            <textarea class="form-control" id="isi" name="isi" rows="10" required>{{ old('isi') }}</textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Publikasikan Artikel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection