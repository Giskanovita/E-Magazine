@extends('main')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kelola Kategori</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <h5>Tambah Kategori Baru</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.kategori.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h5>Daftar Kategori</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $item)
                        <tr>
                            <td>{{ $item->id_kategori }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.kategori.destroy', $item->id_kategori) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection