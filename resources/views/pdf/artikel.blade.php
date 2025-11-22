<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $artikel->judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .meta { color: #666; margin-bottom: 20px; }
        .content { line-height: 1.6; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 12px; }
        .article-image { max-width: 100%; height: auto; margin: 20px 0; text-align: center; }
        .article-image img { max-width: 500px; height: auto; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $artikel->judul }}</h1>
    </div>
    
    @if($artikel->foto)
    <div class="article-image">
        <img src="{{ public_path('storage/' . $artikel->foto) }}" alt="{{ $artikel->judul }}">
    </div>
    @endif
    
    <div class="meta">
        <p><strong>Penulis:</strong> {{ $artikel->user->nama }}</p>
        <p><strong>Kategori:</strong> {{ $artikel->kategori->nama_kategori }}</p>
        <p><strong>Tanggal:</strong> {{ $artikel->created_at->format('d F Y') }}</p>
    </div>
    
    <div class="content">
        {!! nl2br(e($artikel->isi)) !!}
    </div>
    
    <div class="footer">
        <p>Diunduh dari Magazine pada {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>