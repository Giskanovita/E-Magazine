<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Komentar;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalArtikel = Artikel::count();
        $totalKategori = Kategori::count();
        $totalUser = User::count();
        $artikelPending = Artikel::where('status', 'draft')->count();
        
        $recentArtikel = Artikel::with(['user', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
       
        $notifications = Notification::where('id_user', auth()->user()->id_user)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact('totalArtikel', 'totalKategori', 'totalUser', 'artikelPending', 'recentArtikel', 'notifications'));
    }
    
    // Kelola Kategori
    public function kategoriIndex()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('admin.kategori', compact('kategori'));
    }
    
    public function kategoriStore(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori'
        ]);
        
        Kategori::create($request->only('nama_kategori'));
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }
    
    public function kategoriUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,'.$id.',id_kategori'
        ]);
        
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->only('nama_kategori'));
        return redirect()->back()->with('success', 'Kategori berhasil diupdate');
    }
    
    public function kategoriDestroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
    
    // Verifikasi Artikel
    public function artikelIndex()
    {
        $artikel = Artikel::with(['user', 'kategori'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.artikel', compact('artikel'));
    }
    
    public function artikelApprove($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update(['status' => 'publikasi']);
        
        return redirect()->back()->with('success', 'Artikel berhasil dipublikasikan');
    }
    
    public function artikelReject($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();
        
        return redirect()->back()->with('success', 'Artikel berhasil ditolak');
    }
    
    // Kelola User
    public function userIndex()
    {
        $users = User::orderBy('nama')->get();
        return view('admin.users', compact('users'));
    }
    
    public function userStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
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
    
    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id.',id_user',
            'role' => 'required|in:admin,guru,siswa,publik'
        ]);
        
        $user = User::findOrFail($id);
        $updateData = $request->only(['nama', 'username', 'role']);
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $user->update($updateData);
        return redirect()->back()->with('success', 'User berhasil diupdate');
    }
    
    public function userDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
    
    // Laporan
    public function laporan()
    {
        $totalArtikel = Artikel::count();
        $artikelPublish = Artikel::where('status', 'publikasi')->count();
        $artikelDraft = Artikel::where('status', 'draft')->count();
        $totalUser = User::count();
        $totalKomentar = Komentar::count();
        $totalKategori = Kategori::count();
        
        $userByRole = User::selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->get();
            
        $artikelByKategori = Artikel::join('kategori', 'artikel.id_kategori', '=', 'kategori.id_kategori')
            ->selectRaw('kategori.nama_kategori, COUNT(*) as total')
            ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
            ->get();
        
        return view('admin.laporan', compact(
            'totalArtikel', 'artikelPublish', 'artikelDraft', 'totalUser', 
            'totalKomentar', 'totalKategori', 'userByRole', 'artikelByKategori'
        ));
    }
    
    public function laporanPdf(Request $request)
    {
        $type = $request->get('type', 'bulan');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        
        $query = Artikel::with(['user', 'kategori'])->where('status', 'publikasi');
        
        if ($bulan && $tahun) {
            $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
        }
        
        if ($type === 'bulan') {
            if ($bulan && $tahun) {
                $artikelData = collect([[
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'total' => $query->count()
                ]]);
                $artikelDetail = [$tahun.'-'.str_pad($bulan, 2, '0', STR_PAD_LEFT) => $query->orderBy('created_at', 'desc')->get()];
            } else {
                $artikelData = Artikel::where('status', 'publikasi')
                    ->selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, COUNT(*) as total')
                    ->groupBy('tahun', 'bulan')
                    ->orderBy('tahun', 'desc')
                    ->orderBy('bulan', 'desc')
                    ->get();
                    
                $artikelDetail = Artikel::with(['user', 'kategori'])
                    ->where('status', 'publikasi')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy(function($artikel) {
                        return $artikel->created_at->format('Y-m');
                    });
            }
        } else {
            $kategori_id = $request->get('kategori_id');
            if ($kategori_id) {
                $query->whereHas('kategori', function($q) use ($kategori_id) {
                    $q->where('nama_kategori', $kategori_id);
                });
            }
            
            $artikelData = $query->join('kategori', 'artikel.id_kategori', '=', 'kategori.id_kategori')
                ->selectRaw('kategori.nama_kategori, COUNT(*) as total')
                ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
                ->get();
                
            $artikelDetail = $query->orderBy('id_kategori')
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('kategori.nama_kategori');
        }
        
        $filename = 'laporan-artikel-' . $type;
        if ($bulan && $tahun) {
            $filename .= '-' . $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);
        }
        if ($type === 'kategori' && $request->get('kategori_id')) {
            $filename .= '-' . str_replace(' ', '-', strtolower($request->get('kategori_id')));
        }
        $filename .= '-' . date('Y-m-d') . '.pdf';
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.laporan', compact('artikelData', 'artikelDetail', 'type', 'bulan', 'tahun'));
        
        return $pdf->download($filename);
    }
}