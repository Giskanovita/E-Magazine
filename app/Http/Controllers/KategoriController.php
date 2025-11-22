<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Artikel;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('artikel')->get();
        return view('pages.kategori', compact('kategori'));
    }
    
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        $artikel = Artikel::with(['kategori', 'user', 'likes'])
            ->where('id_kategori', $id)
            ->where('status', 'publikasi')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
            
        return view('pages.category', compact('kategori', 'artikel'));
    }
}