@extends('main')
@section('content')
<!-- Page Title -->
<div class="page-title">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">{{ Str::limit($artikel->judul, 50) }}</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li><a href="/artikel">Artikel</a></li>
        <li class="current">{{ Str::limit($artikel->judul, 30) }}</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-8">
      <!-- Blog Details Section -->
      <section id="blog-details" class="blog-details section">
        <div class="container">
          <article class="article">
            @if($artikel->foto)
            <div class="post-img">
              <img src="{{ asset('storage/' . $artikel->foto) }}" alt="{{ $artikel->judul }}" class="img-fluid rounded">
            </div>
            @endif
            
            <h2 class="title">{{ $artikel->judul }}</h2>
            
            <div class="meta-top">
              <ul>
                <li class="d-flex align-items-center"><i class="bi bi-person"></i> <span>{{ $artikel->user->nama ?? 'Admin' }}</span></li>
                <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <span>{{ $artikel->tanggal }}</span></li>
                <li class="d-flex align-items-center"><i class="bi bi-tag"></i> <a href="/kategori/{{ $artikel->kategori->id_kategori }}">{{ $artikel->kategori->nama_kategori ?? 'Umum' }}</a></li>
                <li class="d-flex align-items-center">
                  <button class="btn btn-link p-0 like-btn" data-artikel-id="{{ $artikel->id_artikel }}">
                    @php
                      $isLiked = false;
                      if (auth()->check()) {
                          $isLiked = auth()->user()->likes->where('id_artikel', $artikel->id_artikel)->count() > 0;
                      } else {
                          $sessionLikes = session()->get('guest_likes', []);
                          $isLiked = in_array($artikel->id_artikel, $sessionLikes);
                      }
                      $totalLikes = $artikel->likes->count();
                      if (!auth()->check()) {
                          $sessionLikes = session()->get('guest_likes', []);
                          $totalLikes += in_array($artikel->id_artikel, $sessionLikes) ? 1 : 0;
                      }
                    @endphp
                    <i class="bi bi-heart{{ $isLiked ? '-fill text-danger' : '' }}"></i>
                    <span class="like-count">{{ $totalLikes }}</span> Likes
                  </button>
                </li>
                <li class="d-flex align-items-center">
                  <a href="{{ route('artikel.pdf', $artikel->id_artikel) }}" class="btn btn-link p-0 text-decoration-none">
                    <i class="bi bi-download"></i> Download PDF
                  </a>
                </li>
              </ul>
            </div>
            
            <div class="content">
              {!! nl2br(e($artikel->isi)) !!}
            </div>
            
            @if($artikel->lampiran && count($artikel->lampiran) > 0)
            <div class="attachments mt-4">
              <h5><i class="bi bi-paperclip"></i> Lampiran</h5>
              <div class="row">
                @foreach($artikel->lampiran as $file)
                <div class="col-md-6 mb-2">
                  <div class="card">
                    <div class="card-body p-2">
                      <div class="d-flex align-items-center">
                        @if(str_contains($file['type'], 'image'))
                          <i class="bi bi-image text-primary me-2"></i>
                        @elseif(str_contains($file['type'], 'pdf'))
                          <i class="bi bi-file-pdf text-danger me-2"></i>
                        @elseif(str_contains($file['type'], 'word'))
                          <i class="bi bi-file-word text-info me-2"></i>
                        @else
                          <i class="bi bi-file-earmark text-secondary me-2"></i>
                        @endif
                        <div class="flex-grow-1">
                          <a href="{{ asset('storage/'.$file['path']) }}" target="_blank" class="text-decoration-none">
                            <small class="fw-bold">{{ $file['name'] }}</small><br>
                            <small class="text-muted">{{ number_format($file['size']/1024, 1) }} KB</small>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            @endif
          </article>
          
          <!-- Comments Section -->
          <div class="comments-section mt-5">
            <h4>Komentar ({{ $artikel->komentar->count() }})</h4>
            
            <!-- Comment Form -->
            @auth
            <form action="{{ route('komentar.store') }}" method="POST" class="mb-4">
              @csrf
              <input type="hidden" name="id_artikel" value="{{ $artikel->id_artikel }}">
              <div class="mb-3">
                <textarea name="isi_komentar" class="form-control" rows="3" placeholder="Tulis komentar Anda..." required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Kirim Komentar</button>
            </form>
            @else
            <div class="alert alert-info">
              <a href="{{ route('login') }}">Login</a> untuk memberikan komentar.
            </div>
            @endauth
            
            <!-- Comments List -->
            <div class="comments-list">
              @foreach($artikel->komentar->sortByDesc('created_at') as $komentar)
              <div class="comment-item border-bottom py-3">
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                      {{ strtoupper(substr($komentar->user->nama, 0, 1)) }}
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">{{ $komentar->user->nama }}</h6>
                    <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                    <p class="mt-2 mb-0">{{ $komentar->isi_komentar }}</p>
                  </div>
                </div>
              </div>
              @endforeach
              
              @if($artikel->komentar->count() == 0)
              <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
              @endif
            </div>
          </div>
        </div>
      </section>
    </div>
    
    <div class="col-lg-4 sidebar">
      <div class="widgets-container">
        <!-- Related Articles Widget -->
        @if($related->count() > 0)
        <div class="recent-posts-widget widget-item">
          <h3 class="widget-title">Artikel Terkait</h3>
          @foreach($related as $item)
          <div class="post-item">
            <div class="row align-items-center">
              <div class="col-4">
                @if($item->foto)
                  <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="img-fluid rounded" style="height: 60px; object-fit: cover;">
                @else
                  <img src="{{ asset('assets/img/post-landscape-1.jpg') }}" alt="{{ $item->judul }}" class="img-fluid rounded" style="height: 60px; object-fit: cover;">
                @endif
              </div>
              <div class="col-8">
                <h4><a href="/artikel/{{ $item->id_artikel }}">{{ Str::limit($item->judul, 40) }}</a></h4>
                <time>{{ $item->tanggal }}</time>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @endif
        
        <!-- Back to Articles -->
        <div class="widget-item">
          <div class="d-grid">
            <a href="/artikel" class="btn btn-primary">Kembali ke Artikel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeBtn = document.querySelector('.like-btn');
    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
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
    }
});
</script>
@endsection