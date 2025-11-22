@extends('main')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h2 class="print-only" style="text-align: center; margin: 20px 0; display: none;">LAPORAN SISTEM E-MAGAZINE</h2>
        <h2 class="no-print">Laporan Sistem</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary no-print">Kembali</a>
    </div>

    <div class="row mb-4 hidden-when-filtered">
        <div class="col-md-2">
            <div class="card text-center bg-primary text-white">
                <div class="card-body">
                    <i class="bi bi-file-text fs-1"></i>
                    <h3>{{ $totalArtikel }}</h3>
                    <p>Total Artikel</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center bg-success text-white">
                <div class="card-body">
                    <i class="bi bi-check-circle fs-1"></i>
                    <h3>{{ $artikelPublish }}</h3>
                    <p>Dipublikasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center bg-warning text-white">
                <div class="card-body">
                    <i class="bi bi-file-earmark fs-1"></i>
                    <h3>{{ $artikelDraft }}</h3>
                    <p>Draft</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center bg-info text-white">
                <div class="card-body">
                    <i class="bi bi-people fs-1"></i>
                    <h3>{{ $totalUser }}</h3>
                    <p>Total User</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center bg-secondary text-white">
                <div class="card-body">
                    <i class="bi bi-chat-dots fs-1"></i>
                    <h3>{{ $totalKomentar }}</h3>
                    <p>Komentar</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center bg-dark text-white">
                <div class="card-body">
                    <i class="bi bi-tags fs-1"></i>
                    <h3>{{ $totalKategori }}</h3>
                    <p>Kategori</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row hidden-when-filtered">
        <div class="col-md-6 hidden-when-filtered">
            <div class="card">
                <div class="card-header">
                    <h5>User per Role</h5>
                </div>
                <div class="card-body">
                    @if($userByRole->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userByRole as $role)
                            <tr>
                                <td>{{ ucfirst($role->role) }}</td>
                                <td>{{ $role->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-muted">Tidak ada data user.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6 kategori-table-container">
            <div class="card">
                <div class="card-header">
                    <h5>Artikel per Kategori</h5>
                </div>
                <div class="card-body">
                    @if($artikelByKategori->count() > 0)
                    <table class="table" id="kategoriTable">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Jumlah Artikel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artikelByKategori as $kategori)
                            <tr>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>{{ $kategori->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-muted">Tidak ada data artikel.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4 filtered-content">
        <div class="card-header">
            <h5>Daftar Artikel Lengkap</h5>
        </div>
        <div class="card-body">
            @php
                $artikelLengkap = \App\Models\Artikel::with(['user', 'kategori'])
                    ->where('status', 'publikasi')
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp
            
            @if($artikelLengkap->count() > 0)
            <table class="table table-striped" id="artikelTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Artikel</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($artikelLengkap as $index => $artikel)
                    <tr data-bulan="{{ $artikel->created_at->month }}" data-tahun="{{ $artikel->created_at->year }}" data-kategori="{{ $artikel->kategori ? $artikel->kategori->nama_kategori : 'Tidak ada kategori' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $artikel->judul }}</td>
                        <td>{{ $artikel->user->nama }}</td>
                        <td>{{ $artikel->kategori ? $artikel->kategori->nama_kategori : 'Tidak ada kategori' }}</td>
                        <td>{{ $artikel->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">Tidak ada artikel yang dipublikasikan.</p>
            @endif
        </div>
    </div>

    <div class="card mt-4 no-print">
        <div class="card-header">
            <h5>Filter & Cetak Laporan</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Filter Bulan:</label>
                    <select id="filterBulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Filter Tahun:</label>
                    <select id="filterTahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Filter Kategori:</label>
                    <select id="filterKategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($artikelByKategori as $kat)
                            <option value="{{ $kat->nama_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="print-only">
        <h3 style="text-align: center; margin: 20px 0;">LAPORAN ARTIKEL E-MAGAZINE</h3>
        <p style="text-align: center; margin-bottom: 30px;">Filter: <span id="printFilter">Semua Data</span></p>
    </div>

    <style>
    @media print {
        .no-print { display: none !important; }
        .print-only { display: block !important; }
        .hidden-when-filtered { display: none !important; }
        .filtered-content, .show-on-print { display: block !important; }
        tr[style*="display: none"] { display: none !important; }
        body { font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        .card { border: none; box-shadow: none; }
        .card-header { background: none; border: none; padding: 10px 0; }
        .card-body { padding: 0; }
        h2.print-only { display: block !important; text-align: center; margin: 20px 0; }
    }
    .print-only { display: none; }
    h2.print-only { display: none; }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBulan = document.getElementById('filterBulan');
        const filterTahun = document.getElementById('filterTahun');
        const filterKategori = document.getElementById('filterKategori');
        
        function applyFilters() {
            const bulan = filterBulan.value;
            const tahun = filterTahun.value;
            const kategori = filterKategori.value;
            
            // Update print header
            updatePrintHeader(bulan, tahun, kategori);
            
            // Control visibility based on filter
            const hiddenElements = document.querySelectorAll('.hidden-when-filtered');
            const filteredContent = document.querySelectorAll('.filtered-content');
            const kategoriContainer = document.querySelector('.kategori-table-container');
            
            if (bulan || tahun || kategori) {
                // Hide dashboard and user table when any filter is active
                hiddenElements.forEach(el => el.style.display = 'none');
                // Show filtered content
                filteredContent.forEach(el => {
                    el.style.display = 'block';
                    el.classList.add('show-on-print');
                });
                // Hide kategori table if filtering by month/year
                if (bulan || tahun) {
                    kategoriContainer.style.display = 'none';
                } else {
                    kategoriContainer.style.display = 'block';
                }
            } else {
                // Show all when no filter
                hiddenElements.forEach(el => el.style.display = '');
                filteredContent.forEach(el => {
                    el.style.display = 'block';
                    el.classList.remove('show-on-print');
                });
                kategoriContainer.style.display = 'block';
            }
            
            // Filter tabel artikel per kategori
            const kategoriRows = document.querySelectorAll('#kategoriTable tbody tr');
            kategoriRows.forEach(row => {
                const kategoriName = row.cells[0].textContent;
                if (!kategori || kategoriName === kategori) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Filter tabel artikel lengkap
            const artikelRows = document.querySelectorAll('#artikelTable tbody tr');
            artikelRows.forEach(row => {
                const rowBulan = row.getAttribute('data-bulan');
                const rowTahun = row.getAttribute('data-tahun');
                const rowKategori = row.getAttribute('data-kategori');
                
                let show = true;
                if (bulan && rowBulan != bulan) show = false;
                if (tahun && rowTahun != tahun) show = false;
                if (kategori && rowKategori !== kategori) show = false;
                
                row.style.display = show ? '' : 'none';
            });
            
            // Show message when filtered
            showFilterMessage(bulan, tahun, kategori);
        }
        
        function updatePrintHeader(bulan, tahun, kategori) {
            let filterText = 'Semua Data';
            if (bulan || tahun || kategori) {
                let filters = [];
                if (bulan) {
                    const bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    filters.push(bulanNames[bulan]);
                }
                if (tahun) filters.push(tahun);
                if (kategori) filters.push('Kategori: ' + kategori);
                filterText = filters.join(' - ');
            }
            document.getElementById('printFilter').textContent = filterText;
        }
        
        function showFilterMessage(bulan, tahun, kategori) {
            let existingMsg = document.getElementById('filterMessage');
            if (existingMsg) existingMsg.remove();
            
            if (bulan || tahun || kategori) {
                let filters = [];
                if (bulan) {
                    const bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    filters.push(bulanNames[bulan]);
                }
                if (tahun) filters.push(tahun);
                if (kategori) filters.push('Kategori: ' + kategori);
                
                const message = document.createElement('div');
                message.id = 'filterMessage';
                message.className = 'alert alert-info mt-3';
                message.innerHTML = `<strong>Filter Aktif:</strong> ${filters.join(' - ')}<br><small>Menampilkan data yang sesuai dengan filter. Dashboard dan tabel user disembunyikan saat ada filter aktif.</small>`;
                
                document.querySelector('.container').appendChild(message);
            }
        }
        
        filterBulan.addEventListener('change', applyFilters);
        filterTahun.addEventListener('change', applyFilters);
        filterKategori.addEventListener('change', applyFilters);
    });
    </script>
</div>
@endsection