@extends('main')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Kelola Artikel</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari artikel...">
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($artikel as $item)
                                <tr>
                                    <td>{{ Str::limit($item->judul, 50) }}</td>
                                    <td>{{ $item->user->nama }}</td>
                                    <td>{{ $item->kategori ? $item->kategori->nama_kategori : 'Tidak ada kategori' }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status == 'publikasi' ? 'success' : 'warning' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/artikel/{{ $item->id_artikel }}" class="btn btn-info btn-sm">Lihat</a>
                                        @if($item->status == 'draft')
                                        <form method="POST" action="{{ route('admin.artikel.approve', $item->id_artikel) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.artikel.reject', $item->id_artikel) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menolak artikel ini?')">Tolak</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $artikel->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('tbody tr');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const judul = row.cells[0].textContent.toLowerCase();
            const penulis = row.cells[1].textContent.toLowerCase();
            const kategori = row.cells[2].textContent.toLowerCase();
            
            if (judul.includes(searchTerm) || penulis.includes(searchTerm) || kategori.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection