<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top, #f6f1ea, #e2d3c1);
            background-image: 
              linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px),
              linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px),
              radial-gradient(circle at top, #f6f1ea, #e2d3c1);
            background-size: 20px 20px, 20px 20px, auto;
        }
        .judul { font-family: 'Poppins', sans-serif }
        
        /* TAB CARD */
        .tab-card {
          position: relative;
          border-radius: 24px;
          padding: 28px 30px;
          cursor: pointer;
          transition: all .35s ease;
          opacity: .6;

          background:
            linear-gradient(160deg, rgba(255,255,255,.25), rgba(255,255,255,.08)),
            linear-gradient(160deg, #7a5c45, #5a3d2b);

          box-shadow: 0 8px 18px rgba(62,42,31,.18);
          color: #f4efe4;
          border: 1px solid rgba(255,255,255,.15);
        }

        .tab-card:hover {
          transform: translateY(-4px);
          opacity: .85;
          box-shadow: 0 14px 28px rgba(62,42,31,.28);
        }

        .tab-card.active {
          opacity: 1;
          transform: translateY(-6px);
          background:
            linear-gradient(160deg, rgba(255,255,255,.18), rgba(255,255,255,.06)),
            linear-gradient(160deg, #c9a44c, #5a3d2b);

          box-shadow: 0 18px 36px rgba(62,42,31,.35);
          border: 1px solid rgba(255,255,255,.35);
        }

        .tab-card svg {
          opacity: .5;
          transition: .3s;
        }

        .tab-card.active svg {
          opacity: 1;
          transform: scale(1.12);
        }

        table th, table td {
          padding: 0.75rem;
          font-size: 0.85rem;
          vertical-align: top;
        }

        .table-wrap {
          max-width: 1200px;
          margin: 0 auto;
        }

        .kategori-badge {
          border-radius: 8px;
        }

        .desc-row {
          padding-left: 1.5rem;
          padding-right: 1.5rem;
        }

        .btn {
          padding: 8px 12px;
          border-radius: 10px;
          font-size: 0.8rem;
          font-weight: 600;
        }
        /* Kondisi / Denda / Poin styling - refined */
        .kondisi-badge {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          padding: 6px 10px;
          border-radius: 9999px;
          font-size: 0.8rem;
          font-weight: 700;
          margin-left: 8px;
          box-shadow: 0 1px 0 rgba(0,0,0,0.03);
        }
        .kondisi-baik { background: #e6f9ef; color: #065f46; border: 1px solid #c7f0db; }
        .kondisi-telat { background: #fff7e6; color: #92400e; border: 1px solid #fde3b7; }
        .kondisi-rusak { background: #fff6ef; color: #92400e; border: 1px solid #fcd9b6; }
        .kondisi-hilang { background: #fff3f4; color: #7f1d1d; border: 1px solid #f7caca; }

        .denda-input { text-align: right; font-weight: 700; }
        .denda-display { display:inline-block; min-width:110px; text-align:right; font-weight:800; color:#b91c1c; background:#fff5f5; padding:6px 10px; border-radius:8px; border:1px solid #fee2e2; }

        .poin-badge {
          display:inline-block;
          padding:6px 10px;
          border-radius:9999px;
          background:#fffaf0;
          color:#7a5c45;
          font-weight:800;
          margin-left:8px;
          font-size:0.8rem;
          border:1px solid #f3e2c7;
        }
        .poin-badge.positive { background:#fff3f4; color:#9f1239; border-color:#fecaca; }
        /* styled checkbox labels */
        input.kondisi-checkbox + label { transition: all .4s ease-in-out; }
        input.kondisi-checkbox:checked + label { box-shadow: 0 6px 14px rgba(0,0,0,0.12); transform: translateY(-2px); }
        label.kondisi-badge { cursor:pointer; user-select:none; }
        label.kondisi-badge.disabled { opacity: .45; cursor:not-allowed; }
        .backface-visibility-hidden { backface-visibility: hidden; }
        
        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .empty-state-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            opacity: 0.3;
        }
        
        .empty-state-text {
            font-size: 1.1rem;
            font-weight: 500;
            color: #7a5c45;
            margin-bottom: 0.5rem;
        }
        
        .empty-state-subtext {
            font-size: 0.9rem;
            color: #a89b8c;
        }
        
        /* Header styling */
        .header-section {
            margin-bottom: 2rem;
        }
        
        .btn-action {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
        }
        
        .btn-action:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="text-[#3e2a1f]">
    <div class="min-h-screen flex gap-6 p-6">
        {{-- SIDEBAR --}}
        @include('petugas.layout.sidebar')

        {{-- MAIN --}}
        <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">
            <!-- HEADER SECTION -->
            <div class="header-section">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="judul text-4xl font-bold mb-1">{{ $title }}</h2>
                        <p class="text-[#7a5c45] text-sm">Laporan peminjaman buku per tanggal {{ date('d M Y') }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('petugas.manajemenbuku_petugas') }}?tab={{ $tab }}"
                           class="btn-action inline-flex items-center gap-2 px-5 py-3 bg-[#6b7280] hover:bg-[#4b5563] text-white rounded-xl font-medium shadow-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Kembali
                        </a>
                        <a href="{{ $pdfRoute }}"
                           class="btn-action inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] hover:from-[#d4af55] hover:to-[#936d42] text-white rounded-xl font-medium shadow-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
                                <path stroke-width="1.6" d="M4 21h16"/>
                            </svg>
                            Unduh PDF
                        </a>
                    </div>
                </div>

                <!-- STATS CARD -->
                <div class="stats-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-80 mb-1">Total Data Ditemukan</p>
                            <p class="text-3xl font-bold">{{ $items->count() }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm opacity-80 mb-1">Jenis Laporan</p>
                            <p class="text-2xl font-bold">
                                @if($tab === 'aktif')
                                    Peminjaman Aktif
                                @elseif($tab === 'proses')
                                    Proses Pengembalian
                                @else
                                    Pengembalian Selesai
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            @if($items->isEmpty())
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="empty-state">
                        <svg class="empty-state-icon mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="empty-state-text">Belum ada data</p>
                        <p class="empty-state-subtext">Tidak ada peminjaman pada kategori ini</p>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl shadow-lg table-wrap">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gradient-to-r from-[#e7dcc8] to-[#d9cbbe]">
                            @if($tab === 'selesai')
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Username</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Nama Lengkap</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Judul Buku</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Tanggal Kembali</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Kondisi</th>
                                    <th class="px-4 py-3 text-right text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Denda</th>
                                </tr>
                            @elseif($tab === 'proses')
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Username</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Nama Lengkap</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Judul Buku</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Tanggal Pinjam</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Status</th>
                                </tr>
                            @else
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Username</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Nama Lengkap</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Judul Buku</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Tanggal Pinjam</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Tanggal Kembali</th>
                                    <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Status</th>
                                </tr>
                            @endif
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($items as $index => $item)
                                @if($tab === 'selesai')
                                    <tr class="border-b hover:bg-[#faf6ee]/60 transition-colors duration-200">
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] whitespace-nowrap">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $item->peminjaman->user->username ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-[#555]">{{ $item->peminjaman->user->nama_lengkap ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-[#555]">{{ $item->peminjaman->buku->judul ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] whitespace-nowrap">{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            @php $kondisi = strtolower($item->kondisi ?? 'baik'); @endphp
                                            <span class="kondisi-badge kondisi-{{ $kondisi }}">{{ ucfirst($kondisi) }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right"><span class="denda-display">Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}</span></td>
                                    </tr>
                                @elseif($tab === 'proses')
                                    <tr class="border-b hover:bg-[#faf6ee]/60 transition-colors duration-200">
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] whitespace-nowrap">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $item->user->username ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-[#555]">{{ $item->user->nama_lengkap ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-[#555]">{{ $item->buku->judul ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($item->prosesKembali && $item->prosesKembali->status_proses === 'menunggu')
                                                <span class="kondisi-badge kondisi-menunggu">⏳ Menunggu</span>
                                            @elseif($item->prosesKembali && $item->prosesKembali->status_proses === 'diterima')
                                                <span class="kondisi-badge kondisi-baik">✓ Diterima</span>
                                            @else
                                                <span class="kondisi-badge kondisi-menunggu">⏳ Menunggu</span>
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    <tr class="border-b hover:bg-[#faf6ee]/60 transition-colors duration-200">
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] whitespace-nowrap">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $item->user->username ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-[#555]">{{ $item->user->nama_lengkap ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-[#555]">{{ $item->buku->judul ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] whitespace-nowrap">{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            @php $status = strtolower($item->status ?? ''); @endphp
                                            @if($status === 'dipinjam')
                                                <span class="kondisi-badge kondisi-dipinjam">📖 {{ $item->status }}</span>
                                            @elseif($status === 'terlambat')
                                                <span class="kondisi-badge kondisi-terlambat">⏰ {{ $item->status }}</span>
                                            @else
                                                <span class="kondisi-badge kondisi-menunggu">⏳ {{ ucfirst($item->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </main>
    </div>
</body>
</html>
