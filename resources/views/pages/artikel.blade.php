@extends('main')
@section('content')
<!-- Page Title -->
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Artikel</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="current">Artikel</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-9">
      <h2>Semua Artikel</h2>
      <div class="row">
        @forelse($artikel as $item)
        <div class="col-md-6 mb-4 artikel-card" data-kategori="{{ $item->kategori->nama_kategori ?? 'Umum' }}">
          <div class="card h-100 shadow-sm">
            @if($item->foto)
            <img src="{{ asset('storage/'.$item->foto) }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
            @else
            <img src="{{ asset('assets/img/pahlawan.jpeg') }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
            @endif
            <div class="card-body d-flex flex-column">
              <span class="badge bg-primary mb-2 align-self-start">{{ $item->kategori->nama_kategori ?? 'Umum' }}</span>
              <h5 class="card-title">{{ Str::limit($item->judul, 50) }}</h5>
              <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
              <div class="d-flex justify-content-between align-items-center mt-auto">
                <small class="text-muted">Oleh: {{ $item->user->nama ?? 'Admin' }} | {{ $item->tanggal }}</small>
                <div>
                  @if($item->lampiran && count($item->lampiran) > 0)
                  <span class="text-muted me-2"><i class="bi bi-paperclip"></i> {{ count($item->lampiran) }}</span>
                  @endif
                  <button class="btn btn-link p-0 text-muted me-2 like-btn" data-artikel-id="{{ $item->id_artikel }}">
                    @php
                      $isLiked = false;
                      if (auth()->check()) {
                          $isLiked = auth()->user()->likes->where('id_artikel', $item->id_artikel)->count() > 0;
                      } else {
                          $sessionLikes = session()->get('guest_likes', []);
                          $isLiked = in_array($item->id_artikel, $sessionLikes);
                      }
                      $totalLikes = $item->likes->count();
                      if (!auth()->check()) {
                          $sessionLikes = session()->get('guest_likes', []);
                          $totalLikes += in_array($item->id_artikel, $sessionLikes) ? 1 : 0;
                      }
                    @endphp
                    <i class="bi bi-heart{{ $isLiked ? '-fill text-danger' : '' }}"></i>
                    <span class="like-count">{{ $totalLikes }}</span>
                  </button>
                  <a href="{{ route('artikel.pdf', $item->id_artikel) }}" class="btn btn-link p-0 text-muted me-2" title="Download PDF">
                    <i class="bi bi-download"></i>
                  </a>
                  <a href="/artikel/{{ $item->id_artikel }}" class="btn btn-outline-primary btn-sm">Baca</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center">
          <p class="text-muted">Belum ada artikel yang dipublikasikan.</p>
        </div>
        @endforelse
      </div>
      
      @if($artikel->hasPages())
      <div class="d-flex justify-content-center">
        {{ $artikel->links() }}
      </div>
      @endif
    </div>
    
    <div class="col-md-3">
      <div class="card mb-3">
        <div class="card-header">
          <h5>Pencarian</h5>
        </div>
        <div class="card-body">
          <form action="/artikel" method="GET">
            <div class="mb-3">
              <input type="text" name="search" class="form-control" placeholder="Cari artikel..." value="{{ request('search') }}">
            </div>
            <div class="mb-3">
              <select name="kategori" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $kat)
                <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cari</button>
          </form>
        </div>
      </div>
      
      <div class="card">
        <div class="card-header">
          <h5>Filter Kategori</h5>
        </div>
        <div class="card-body">
          <button class="btn btn-outline-primary btn-sm mb-2 w-100 filter-btn active" data-kategori="all">
            <i class="bi bi-grid"></i> Semua Kategori
          </button>
          @foreach($kategori as $kat)
          <button class="btn btn-outline-secondary btn-sm mb-2 w-100 filter-btn" data-kategori="{{ $kat->nama_kategori }}">
            @if($kat->nama_kategori == 'Prestasi')
              <i class="bi bi-trophy"></i>
            @elseif($kat->nama_kategori == 'Opini')
              <i class="bi bi-chat-quote"></i>
            @elseif($kat->nama_kategori == 'Kegiatan')
              <i class="bi bi-calendar-event"></i>
            @elseif($kat->nama_kategori == 'Informasi Sekolah')
              <i class="bi bi-info-circle"></i>
            @else
              <i class="bi bi-tag"></i>
            @endif
            {{ $kat->nama_kategori }}
          </button>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<style>
.filter-btn.active {
  background-color: #0d6efd;
  color: white;
  border-color: #0d6efd;
}

.artikel-card {
  transition: all 0.3s ease;
}

.artikel-card.hidden {
  display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const filterButtons = document.querySelectorAll('.filter-btn');
  const artikelCards = document.querySelectorAll('.artikel-card');
  
  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Remove active class from all buttons
      filterButtons.forEach(btn => {
        btn.classList.remove('active');
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-secondary');
      });
      
      // Add active class to clicked button
      this.classList.add('active');
      this.classList.remove('btn-outline-secondary');
      this.classList.add('btn-primary');
      
      const selectedKategori = this.getAttribute('data-kategori');
      
      artikelCards.forEach(card => {
        const cardKategori = card.getAttribute('data-kategori');
        
        if (selectedKategori === 'all' || cardKategori === selectedKategori) {
          card.classList.remove('hidden');
        } else {
          card.classList.add('hidden');
        }
      });
    });
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-btn');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const artikelId = this.dataset.artikelId;
            
            fetch('/like/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ artikel_id: artikelId })
            })
            .then(response => response.json())
            .then(data => {
                const icon = this.querySelector('i');
                const count = this.querySelector('.like-count');
                
                if (data.liked) {
                    icon.className = 'bi bi-heart-fill text-danger';
                } else {
                    icon.className = 'bi bi-heart';
                }
                
                count.textContent = data.total_likes;
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>

@endsection