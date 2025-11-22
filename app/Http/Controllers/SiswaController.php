<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik artikel siswa
        $totalArtikel = Artikel::where('id_user', $user->id_user)->count();
        $artikelDraft = Artikel::where('id_user', $user->id_user)->where('status', 'draft')->count();
        $artikelPublish = Artikel::where('id_user', $user->id_user)->where('status', 'publikasi')->count();
        
        // Total komentar pada artikel siswa
        $totalKomentar = Komentar::whereIn('id_artikel', 
            Artikel::where('id_user', $user->id_user)->pluck('id_artikel')
        )->count();
        
        // Artikel terbaru siswa
        $artikelTerbaru = Artikel::where('id_user', $user->id_user)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('siswa.dashboard', compact(
            'totalArtikel', 'artikelDraft', 'artikelPublish', 
            'totalKomentar', 'artikelTerbaru'
        ));
    }
    
    // Kelola artikel siswa
    public function artikelIndex()
    {
        $artikel = Artikel::where('id_user', Auth::user()->id_user)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('siswa.artikel', compact('artikel'));
    }
    
    public function createArtikel()
    {
        $kategori = Kategori::all();
        return view('siswa.create-artikel', compact('kategori'));
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
        $data['status'] = 'draft'; // Artikel siswa perlu persetujuan
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('artikel', 'public');
        }
        
        $artikel = Artikel::create($data);
        
        // Notify guru untuk persetujuan
        $gurus = User::where('role', 'guru')->get();
        
        foreach ($gurus as $guru) {
            Notification::create([
                'id_user' => $guru->id_user,
                'title' => 'Artikel Baru dari Siswa',
                'message' => 'Siswa ' . Auth::user()->nama . ' telah mengirim artikel: ' . $artikel->judul,
                'type' => 'info'
            ]);
        }
        
        return redirect()->route('siswa.artikel.index')->with('success', 'Artikel berhasil dikirim dan menunggu persetujuan guru');
    }
    
    public function editArtikel($id)
    {
        $artikel = Artikel::where('id_artikel', $id)
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();
        
        // Siswa hanya bisa edit artikel yang masih draft
        if ($artikel->status !== 'draft') {
            return redirect()->back()->with('error', 'Artikel yang sudah dipublikasi tidak bisa diedit');
        }
        
        $kategori = Kategori::all();
        return view('siswa.edit-artikel', compact('artikel', 'kategori'));
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
        
        // Siswa hanya bisa edit artikel yang masih draft
        if ($artikel->status !== 'draft') {
            return redirect()->back()->with('error', 'Artikel yang sudah dipublikasi tidak bisa diedit');
        }
        
        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('artikel', 'public');
        }
        
        $artikel->update($data);
        
        // Notify guru dan admin tentang update artikel
        $gurus = User::where('role', 'guru')->get();
        $admins = User::where('role', 'admin')->get();
        
        foreach ($gurus as $guru) {
            Notification::create([
                'id_user' => $guru->id_user,
                'title' => 'Artikel Diupdate oleh Siswa',
                'message' => 'Siswa ' . Auth::user()->nama . ' telah mengupdate artikel: ' . $artikel->judul,
                'type' => 'info'
            ]);
        }
        
        foreach ($admins as $admin) {
            Notification::create([
                'id_user' => $admin->id_user,
                'title' => 'Artikel Diupdate oleh Siswa',
                'message' => 'Siswa ' . Auth::user()->nama . ' telah mengupdate artikel: ' . $artikel->judul,
                'type' => 'info'
            ]);
        }
        
        return redirect()->route('siswa.artikel.index')->with('success', 'Artikel berhasil diupdate dan guru/admin telah diberitahu');
    }
}