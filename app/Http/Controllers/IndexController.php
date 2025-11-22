<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;

class IndexController extends Controller
{
    public function index()
    {
        // Artikel terbaru
        $artikelTerbaru = Artikel::with(['kategori', 'user', 'likes'])
            ->where('status', 'publikasi')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        // Artikel terpopuler
        $artikelPopuler = Artikel::with(['kategori', 'user', 'likes'])
            ->where('status', 'publikasi')
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(3)
            ->get();
            
        $kategori = Kategori::withCount('artikel')->get();
        
        return view('pages.index', compact('artikelTerbaru', 'artikelPopuler', 'kategori'));
    }
}
