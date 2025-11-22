@extends('main')
@section('content')
<div class="container" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('assets/img/bkns66.jpeg') }}'); background-size: cover; background-position: center; min-height: 100vh; background-attachment: fixed;">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header text-center">
          <img src="{{ asset('assets/img/bn-removebg-preview.png') }}" alt="Logo" class="img-fluid mb-3" style="max-height: 100px;">
          <h3><i class="bi bi-person-circle"></i> Login E-Magazine</h3>
        </div>
        <div class="card-body">
          @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
          @endif
          
          <form method="POST" action="/login" id="loginForm">
            @csrf
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
          </form>
          
          
          <div class="text-center">
            <p>Belum punya akun? <a href="/register">Daftar di sini</a></p>
          </div>
          
          <script>
            // Refresh CSRF token setiap 10 menit untuk mencegah error 419
            setInterval(function() {
              fetch('/refresh-csrf')
                .then(response => response.json())
                .then(data => {
                  document.querySelector('input[name="_token"]').value = data.token;
                })
                .catch(error => console.log('CSRF refresh error:', error));
            }, 600000); // 10 menit
            
            // Refresh token saat form akan disubmit
            document.getElementById('loginForm').addEventListener('submit', function(e) {
              e.preventDefault();
              fetch('/refresh-csrf')
                .then(response => response.json())
                .then(data => {
                  document.querySelector('input[name="_token"]').value = data.token;
                  this.submit();
                })
                .catch(error => {
                  console.log('CSRF refresh error:', error);
                  this.submit(); // Submit anyway if refresh fails
                });
            });
          </script>
          

        </div>
      </div>
    </div>
  </div>
</div>
@endsection