<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $query = Artikel::with(['kategori', 'user'])
            ->where('status', 'publikasi');
            
        // Pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%');
            });
        }
        
        // Filter kategori
        if ($request->has('kategori') && $request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }
        
        $artikel = $query->orderBy('created_at', 'desc')->paginate(12);
        $kategori = Kategori::all();
        
        return view('pages.artikel', compact('artikel', 'kategori'));
    }
    
    public function show($id)
    {
        $artikel = Artikel::with(['kategori', 'user', 'likes'])
            ->where('id_artikel', $id)
            ->where('status', 'publikasi')
            ->firstOrFail();
            
        $related = Artikel::with(['kategori', 'user'])
            ->where('id_kategori', $artikel->id_kategori)
            ->where('id_artikel', '!=', $id)
            ->where('status', 'publikasi')
            ->take(3)
            ->get();
            
        return view('pages.single-post', compact('artikel', 'related'));
    }
}