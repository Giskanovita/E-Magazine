<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManajemenArtikelController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            $artikel = new \Illuminate\Pagination\LengthAwarePaginator(
                collect(),
                0,
                10,
                1,
                ['path' => request()->url()]
            );
        } else {
            $artikel = Artikel::where('id_user', Auth::user()->id_user)
                ->with('kategori')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        
        return view('manajemen.artikel.index', compact('artikel'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('manajemen.artikel.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|max:2048',
            'lampiran.*' => 'nullable|file|max:5120',
            'status' => 'required|in:draft,publikasi'
        ]);

        $data = $request->all();
        $data['id_user'] = Auth::user()->id_user;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('artikel', 'public');
        }

        if ($request->hasFile('lampiran')) {
            $lampiran = [];
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store('lampiran', 'public');
                $lampiran[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            $data['lampiran'] = $lampiran;
        }

        Artikel::create($data);
        return redirect()->route('manajemen.artikel.index')->with('success', 'Artikel berhasil dibuat');
    }

    public function edit($id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::user()->id_user)->firstOrFail();
        $kategori = Kategori::all();
        return view('manajemen.artikel.edit', compact('artikel', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::user()->id_user)->firstOrFail();
        
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|max:2048',
            'lampiran.*' => 'nullable|file|max:5120',
            'status' => 'required|in:draft,publikasi'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($artikel->foto) {
                Storage::disk('public')->delete($artikel->foto);
            }
            $data['foto'] = $request->file('foto')->store('artikel', 'public');
        }

        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama
            if ($artikel->lampiran) {
                foreach ($artikel->lampiran as $file) {
                    Storage::disk('public')->delete($file['path']);
                }
            }
            
            $lampiran = [];
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store('lampiran', 'public');
                $lampiran[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            $data['lampiran'] = $lampiran;
        }

        $artikel->update($data);
        return redirect()->route('manajemen.artikel.index')->with('success', 'Artikel berhasil diupdate');
    }

    public function destroy($id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::user()->id_user)->firstOrFail();
        
        if ($artikel->foto) {
            Storage::disk('public')->delete($artikel->foto);
        }
        
        if ($artikel->lampiran) {
            foreach ($artikel->lampiran as $file) {
                Storage::disk('public')->delete($file['path']);
            }
        }
        
        $artikel->delete();
        return redirect()->route('manajemen.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
}