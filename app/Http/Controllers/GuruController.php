<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik artikel guru
        $totalArtikel = Artikel::where('id_user', $user->id_user)->count();
        $artikelDraft = Artikel::where('id_user', $user->id_user)->where('status', 'draft')->count();
        $artikelPublish = Artikel::where('id_user', $user->id_user)->where('status', 'publikasi')->count();
        
        // Total komentar pada artikel guru
        $totalKomentar = Komentar::whereIn('id_artikel', 
            Artikel::where('id_user', $user->id_user)->pluck('id_artikel')
        )->count();
        
        // Artikel siswa yang perlu disetujui
        $artikelPendingApproval = Artikel::where('status', 'draft')
            ->whereHas('user', function($query) {
                $query->where('role', 'siswa');
            })
            ->count();
        
        // Artikel terbaru guru
        $artikelTerbaru = Artikel::where('id_user', $user->id_user)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Notifikasi terbaru untuk guru
        $notifications = Notification::where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('guru.dashboard', compact(
            'totalArtikel', 'artikelDraft', 'artikelPublish', 
            'totalKomentar', 'artikelTerbaru', 'artikelPendingApproval', 'notifications'
        ));
    }
    
    // Kelola artikel guru
    public function artikelIndex()
    {
        $artikel = Artikel::where('id_user', Auth::user()->id_user)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('guru.artikel', compact('artikel'));
    }
    
    public function createArtikel()
    {
        $kategori = Kategori::all();
        return view('guru.create-artikel', compact('kategori'));
    }
    
    public function storeArtikel(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'foto' => 'nullable|image|max:2048'
        ]);
        
        $data = $request->all();
        $data['id_user'] = Auth::user()->id_user;
        $data['tanggal'] = now()->format('Y-m-d');
        $data['status'] = 'publikasi'; // Guru bisa langsung publish
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('artikel', 'public');
        }
        
        Artikel::create($data);
        
        return redirect()->route('guru.artikel.index')->with('success', 'Artikel berhasil dibuat');
    }
    
    public function editArtikel($id)
    {
        $artikel = Artikel::where('id_artikel', $id)
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();
        $kategori = Kategori::all();
        return view('guru.edit-artikel', compact('artikel', 'kategori'));
    }
    
    public function updateArtikel(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'foto' => 'nullable|image|max:2048'
        ]);
        
        $artikel = Artikel::where('id_artikel', $id)
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();
        
        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('artikel', 'public');
        }
        
        $artikel->update($data);
        
        return redirect()->route('guru.artikel.index')->with('success', 'Artikel berhasil diupdate');
    }
    
    // Melihat komentar pada artikel guru
    public function komentarIndex()
    {
        $komentar = Komentar::whereIn('id_artikel', 
                Artikel::where('id_user', Auth::user()->id_user)->pluck('id_artikel')
            )
            ->with(['artikel', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('guru.komentar', compact('komentar'));
    }
    
    // Moderasi artikel siswa
    public function moderasiIndex()
    {
        $artikelSiswa = Artikel::where('status', 'draft')
            ->whereHas('user', function($query) {
                $query->where('role', 'siswa');
            })
            ->with(['user', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('guru.moderasi', compact('artikelSiswa'));
    }
    
    public function moderasiApprove($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        // Pastikan artikel dari siswa
        if ($artikel->user->role !== 'siswa') {
            return redirect()->back()->with('error', 'Hanya artikel siswa yang bisa disetujui');
        }
        
        $artikel->update(['status' => 'publikasi']);
        
        return redirect()->back()->with('success', 'Artikel siswa berhasil disetujui');
    }
    

}