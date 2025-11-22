<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Artikel {{ ucfirst($type) }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .summary { margin-bottom: 30px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f5f5f5; font-weight: bold; }
        .group-header { background-color: #e9ecef; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN ARTIKEL YANG SUDAH TAYANG</h2>
        <h3>Pengelompokan Per {{ ucfirst($type) }}</h3>
        <p>Periode: 
            @if($bulan && $tahun)
                {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->format('F Y') }}
            @else
                Semua Periode ({{ now()->format('d F Y') }})
            @endif
        </p>
    </div>
    
    <div class="summary">
        <h4>Ringkasan:</h4>
        <table class="table">
            <tr>
                <th>{{ $type === 'bulan' ? 'Bulan' : 'Kategori' }}</th>
                <th>Jumlah Artikel</th>
            </tr>
            @foreach($artikelData as $data)
            <tr>
                <td>
                    @if($type === 'bulan')
                        {{ \Carbon\Carbon::createFromDate($data->tahun, $data->bulan, 1)->format('F Y') }}
                    @else
                        {{ $data->nama_kategori }}
                    @endif
                </td>
                <td>{{ $data->total }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    
    <div class="detail">
        <h4>Detail Artikel:</h4>
        @foreach($artikelDetail as $group => $artikels)
        <table class="table">
            <tr class="group-header">
                <td colspan="4">
                    @if($type === 'bulan')
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $group)->format('F Y') }}
                    @else
                        {{ $group }}
                    @endif
                    ({{ $artikels->count() }} artikel)
                </td>
            </tr>
            <tr>
                <th>No</th>
                <th>Judul Artikel</th>
                <th>Penulis</th>
                <th>Tanggal</th>
            </tr>
            @foreach($artikels as $index => $artikel)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $artikel->judul }}</td>
                <td>{{ $artikel->user->nama }}</td>
                <td>{{ $artikel->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </table>
        @endforeach
    </div>
    
    <div class="footer">
        <p>Laporan digenerate pada {{ now()->format('d F Y H:i') }}</p>
        <p>E-Magazine System</p>
    </div>
</body>
</html>