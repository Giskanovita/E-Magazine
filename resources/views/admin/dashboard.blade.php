@extends('main')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Admin</h2>
        <div>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-primary me-2">Kelola Kategori</a>
            <a href="{{ route('admin.artikel.index') }}" class="btn btn-success me-2">Kelola Artikel</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-info me-2">Kelola User</a>
            <a href="{{ route('admin.laporan') }}" class="btn btn-warning">Laporan</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);">
                <div class="card-body">
                    <h5>Total Artikel</h5>
                    <h3>{{ $totalArtikel }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); border: none; box-shadow: 0 8px 32px rgba(86, 171, 47, 0.3);">
                <div class="card-body">
                    <h5>Total Kategori</h5>
                    <h3>{{ $totalKategori }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); border: none; box-shadow: 0 8px 32px rgba(116, 185, 255, 0.3);">
                <div class="card-body">
                    <h5>Total User</h5>
                    <h3>{{ $totalUser }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #fdcb6e 0%, #e17055 100%); border: none; box-shadow: 0 8px 32px rgba(253, 203, 110, 0.3);">
                <div class="card-body">
                    <h5>Artikel Pending</h5>
                    <h3>{{ $artikelPending }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    @if($notifications->count() > 0)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
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
        </div>
    </div>
    @endif
</div>
@endsection