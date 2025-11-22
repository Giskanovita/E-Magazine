<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;
use App\Models\Artikel;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_artikel' => 'required|exists:artikel,id_artikel',
            'isi_komentar' => 'required|string'
        ]);
        
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk berkomentar');
        }

        Komentar::create([
            'id_artikel' => $request->id_artikel,
            'id_user' => Auth::user()->id_user,
            'isi_komentar' => $request->isi_komentar
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan');
    }
}