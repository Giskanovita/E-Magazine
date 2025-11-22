<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadArtikel($id)
    {
        $artikel = Artikel::with(['user', 'kategori'])
            ->where('status', 'publikasi')
            ->findOrFail($id);
        
        $pdf = Pdf::loadView('pdf.artikel', compact('artikel'));
        
        $filename = 'artikel-' . str_replace(' ', '-', strtolower($artikel->judul)) . '.pdf';
        return $pdf->download($filename);
    }
}