<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ModerasiController extends Controller
{
    public function index()
    {
        $artikel = Artikel::with(['user', 'kategori'])
            ->where('status', 'draft')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('moderasi.index', compact('artikel'));
    }
    
    public function approve($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update(['status' => 'publikasi']);
        
        return redirect()->back()->with('success', 'Artikel berhasil disetujui');
    }
    
    public function reject($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();
        
        return redirect()->back()->with('success', 'Artikel berhasil ditolak');
    }
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,guru,siswa,publik'
        ]);
        
        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        
        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }
}