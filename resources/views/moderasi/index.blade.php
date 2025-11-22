@extends('main')
@section('content')
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Moderasi Konten</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="current">Moderasi</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(auth()->user()->role == 'admin')
  <div class="card mb-4">
    <div class="card-header">
      <h5>Tambah User Baru</h5>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.user.store') }}">
        @csrf
        <div class="row">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
          </div>
          <div class="col-md-2">
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
          </div>
          <div class="col-md-2">
            <div class="mb-3">
              <label for="role" class="form-label">Role</label>
              <select class="form-control" id="role" name="role" required>
                <option value="siswa">Siswa</option>
                <option value="guru">Guru</option>
                <option value="admin">Admin</option>
                <option value="publik">Publik</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="mb-3">
              <label class="form-label">&nbsp;</label>
              <button type="submit" class="btn btn-primary d-block">Tambah</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  @endif

  <div class="card">
    <div class="card-header">
      <h5>Artikel Menunggu Persetujuan</h5>
    </div>
    <div class="card-body">
      @if($artikel->count() > 0)
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Penulis</th>
              <th>Kategori</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($artikel as $item)
            <tr>
              <td>{{ Str::limit($item->judul, 50) }}</td>
              <td>{{ $item->user->nama ?? 'Unknown' }}</td>
              <td>{{ $item->kategori->nama_kategori ?? 'Umum' }}</td>
              <td>{{ $item->tanggal }}</td>
              <td>
                <form action="{{ route('moderasi.approve', $item->id_artikel) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                </form>
                <form action="{{ route('moderasi.reject', $item->id_artikel) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin tolak artikel ini?')">Tolak</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $artikel->links() }}
      @else
      <p class="text-muted">Tidak ada artikel yang menunggu persetujuan.</p>
      @endif
    </div>
  </div>
</div>
@endsection