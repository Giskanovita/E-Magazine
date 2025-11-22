<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container position-relative d-flex align-items-center justify-content-between">

    <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
      <img src="{{ asset('assets/img/bn-removebg-preview.png') }}" alt="Logo" style="height: 40px; margin-right: 10px; animation: bounce 2s infinite;">
      <h1 class="sitename" style="animation: slideIn 1s ease-out;">E-Mading</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="/"><i class="bi bi-house"></i> Home</a></li>
        <li><a href="/artikel"><i class="bi bi-newspaper"></i> Artikel</a></li>
        <li><a href="/like"><i class="bi bi-heart"></i> Like</a></li>
        @auth
        @if(Auth::user()->role != 'siswa')
        <li><a href="/moderasi"><i class="bi bi-shield-check"></i> Moderasi</a></li>
        @endif
        @endauth
        @auth
        @if(Auth::user()->role == 'admin')
        <li><a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard Admin</a></li>
        @elseif(Auth::user()->role == 'guru')
        <li><a href="{{ route('guru.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard Guru</a></li>
        @elseif(Auth::user()->role == 'siswa')
        <li><a href="{{ route('siswa.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard Siswa</a></li>
        @endif
        @endauth
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <div class="header-social-links">
      @guest
      <a href="/login" class="btn btn-outline-primary btn-sm"><i class="bi bi-box-arrow-in-right"></i> Login</a>
      @else
      <span class="text-muted me-2">{{ Auth::user()->nama }}</span>
      <form action="/logout" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
      </form>
      @endguest
    </div>

  </div>
</header>