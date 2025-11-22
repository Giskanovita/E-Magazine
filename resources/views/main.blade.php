<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>E-Magazine Sekolah</title>
  <meta name="description" content="Platform Digital untuk Berbagi Karya dan Prestasi Siswa">
  <meta name="keywords" content="sekolah, magazine, artikel, siswa, prestasi">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  
  <!-- Custom Soft Colors CSS -->
  <style>
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
    }
    
    .header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    }
    
    .card, .bg-white {
      background: rgba(255, 255, 255, 0.9) !important;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .btn-primary {
      background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
      border: none;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-success {
      background: linear-gradient(45deg, #56ab2f 0%, #a8e6cf 100%);
      border: none;
      box-shadow: 0 4px 15px rgba(86, 171, 47, 0.3);
    }
    
    .btn-info {
      background: linear-gradient(45deg, #74b9ff 0%, #0984e3 100%);
      border: none;
      box-shadow: 0 4px 15px rgba(116, 185, 255, 0.3);
    }
    
    .btn-warning {
      background: linear-gradient(45deg, #fdcb6e 0%, #e17055 100%);
      border: none;
      box-shadow: 0 4px 15px rgba(253, 203, 110, 0.3);
    }
    
    .footer {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .navbar-nav .nav-link {
      color: #6c757d !important;
      transition: all 0.3s ease;
    }
    
    .navbar-nav .nav-link:hover {
      color: #667eea !important;
      transform: translateY(-2px);
    }
  </style>

  <!-- =======================================================
  * Template Name: ZenBlog
  * Template URL: https://bootstrapmade.com/zenblog-bootstrap-blog-template/
  * Updated: Aug 08 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">
  @include('partials.navbar')
  
  <main class="main" style="padding-bottom: 60px;">
    @yield('content')
  </main>
  
  @include('partials.footer')

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="{{ asset('assets/js/responsive.js') }}"></script>

</body>

</html>