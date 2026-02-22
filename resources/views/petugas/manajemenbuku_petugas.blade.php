<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Peminjaman (Petugas)</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

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
  </style>
</head>

<body class="text-[#3e2a1f]">

<div class="min-h-screen flex gap-6 p-6">

  {{-- SIDEBAR --}}
  @include('petugas.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    @section('page-icon')
    <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    @endsection

    @section('page-title')
    Manajemen Peminjaman
    @endsection

    @include('petugas.layout.header')

    <!-- SEARCH + UNDUH LAPORAN -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-5 gap-4">

      <!-- INPUT SEARCH -->
      <div class="flex items-center gap-3 w-full md:w-1/2">
        <input type="text" id="searchInput" placeholder="Cari user atau buku..."
               class="w-full px-4 py-3 text-sm bg-white shadow border border-[#e2d3c1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c9a44c]">
        <button id="searchBtn"
                class="px-5 py-3 bg-[#c9a44c] rounded-xl hover:bg-[#b28f45] transition shadow flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <circle cx="11" cy="11" r="7" stroke-width="1.6"/>
            <path stroke-width="1.6" d="M20 20l-3-3"/>
          </svg>
        </button>
      </div>

      <!-- BUTTONS -->
      <div class="flex gap-3">
        <button onclick="navigateToLaporan()"
           class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
            <path stroke-width="1.6" d="M4 21h16"/>
          </svg>
          Unduh Laporan
        </button>
      </div>

    </div>

    <!-- TAB CARD -->
    <div class="grid grid-cols-3 gap-6 mb-8">
      <div onclick="showTab('aktif')" id="tab-aktif" class="tab-card active flex justify-between items-center">
        <div>
          <p class="text-sm opacity-80">Status</p>
          <h3 class="text-lg font-bold">Peminjaman Aktif</h3>
          <p class="text-sm">({{ $menungguKonfirmasi->count() + $dipinjam->count() }} data)</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="1.6" d="M4 6a2 2 0 012-2h12v15a1 1 0 01-1 1H6a2 2 0 01-2-2z"/>
          <path stroke-width="1.6" d="M6 4v14"/>
        </svg>
      </div>

      <div onclick="showTab('proses')" id="tab-proses" class="tab-card flex justify-between items-center">
        <div>
          <p class="text-sm opacity-80">Status</p>
          <h3 class="text-lg font-bold">Proses Pengembalian</h3>
          <p class="text-sm">({{ $proses->count() }} data)</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <circle cx="12" cy="12" r="9" stroke-width="1.6"/>
  <line x1="12" y1="12" x2="12" y2="7" stroke-width="1.6" stroke-linecap="round"/>
  <line x1="12" y1="12" x2="15" y2="12" stroke-width="1.6" stroke-linecap="round"/>
</svg>
      </div>

      <div onclick="showTab('selesai')" id="tab-selesai" class="tab-card flex justify-between items-center">
        <div>
          <p class="text-sm opacity-80">Status</p>
          <h3 class="text-lg font-bold">Selesai</h3>
          <p class="text-sm">({{ $selesai->count() }} data)</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <circle cx="12" cy="12" r="9" stroke-width="1.6"/>
          <path stroke-width="1.6" stroke-linecap="round" d="M8.5 12.5l2.5 2.5l4.5-5"/>
        </svg>
      </div>
    </div>

    <!-- TABLE COMPONENT -->
    @php
      function tableHeader() {
        return '
          <thead class="bg-[#e7dcc8] text-sm font-semibold">
            <tr>
              <th>No</th>
              <th>User</th>
              <th>Buku</th>
              <th>Durasi</th>
              <th>Kondisi</th>
              <th>Denda</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
        ';
      }
    @endphp

    <!-- TABEL PEMINJAMAN AKTIF (GABUNGAN MENUNGGU + DIPINJAM) -->
    <div id="table-aktif">
      <section>
        <div class="flex justify-between items-center mb-4">
          <h3 class="judul text-xl">Peminjaman Aktif</h3>
        </div>
        <div class="overflow-x-auto rounded-2xl shadow table-wrap">
          <table class="min-w-full bg-white">
            <thead class="bg-[#e7dcc8]">
              <tr>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">User</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Buku</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Tanggal Pinjam</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Tanggal Kembali</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @php
                $semuaPeminjaman = collect()
                  ->concat($menungguKonfirmasi)
                  ->concat($dipinjam)
                  ->sortByDesc('created_at');
              @endphp
              @foreach($semuaPeminjaman as $i => $p)
              <tr class="border-b hover:bg-[#faf6ee] transition">
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $loop->iteration }}</td>
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $p->user->username }}</td>
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $p->buku->judul }}</td>
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ \Illuminate\Support\Carbon::parse($p->tanggal_pinjam ?? $p->created_at)->format('Y-m-d') }}</td>
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $p->tanggal_kembali ? \Illuminate\Support\Carbon::parse($p->tanggal_kembali)->format('Y-m-d') : '-' }}</td>
                <td class="px-4 py-3">
                  <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $p->status === 'menunggu konfirmasi' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ $p->status === 'menunggu konfirmasi' ? 'Menunggu' : 'Dipinjam' }}
                  </span>
                </td>
                <td class="px-4 py-3 text-center space-x-1">
                  <button class="btn-detail px-4 py-2 bg-gradient-to-r from-[#c9a44c] to-[#b28f45] text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-[#b28f45] hover:to-[#a07a3d] transition-all duration-300 ease-in-out border-2 border-[#c9a44c] hover:border-[#b28f45] cursor-pointer backface-visibility-hidden mr-2" data-id="{{ $p->id }}" data-username="{{ $p->user->username }}" data-buku-judul="{{ $p->buku->judul }}" data-tgl-pinjam="{{ $p->tanggal_pinjam ? \Carbon\Carbon::parse($p->tanggal_pinjam)->format('Y-m-d') : \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') }}" data-tgl-kembali="{{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('Y-m-d') : '' }}" data-status="{{ $p->status }}" data-telepon="{{ $p->nomer_hp ?? $p->user->no_hp ?? '-' }}" data-nama-lengkap="{{ $p->nama_lengkap ?? '-' }}" data-alamat="{{ $p->alamat ?? '-' }}" data-kode-pinjam="{{ $p->kode_pinjam ?? '-' }}" data-foto-ktp="{{ $p->foto_ktp ? asset('storage/' . $p->foto_ktp) : '' }}" data-kondisi="Baik" data-denda="0">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Detail
                  </button>
                  @if($p->status === 'menunggu konfirmasi')
                    <form action="{{ route('peminjaman.setujui', $p->id) }}" method="POST" class="inline">
                      @csrf
                      <button type="button" class="btn-setujui-aktif px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-green-700 hover:to-green-800 transition-all duration-300 ease-in-out border-2 border-green-600 hover:border-green-700 cursor-pointer backface-visibility-hidden" data-username="{{ $p->user->username }}" data-buku-judul="{{ $p->buku->judul }}" data-tgl-pinjam="{{ $p->tanggal_pinjam ? \Carbon\Carbon::parse($p->tanggal_pinjam)->format('Y-m-d') : \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') }}">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Setujui
                      </button>
                    </form>

                    <form action="{{ route('peminjaman.tolak', $p->id) }}" method="POST" class="inline ml-2">
                      @csrf
                      <button type="button" class="btn-tolak-aktif px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-red-700 hover:to-red-800 transition-all duration-300 ease-in-out border-2 border-red-600 hover:border-red-700 cursor-pointer backface-visibility-hidden" data-username="{{ $p->user->username }}" data-buku-judul="{{ $p->buku->judul }}" data-tgl-pinjam="{{ $p->tanggal_pinjam ? \Carbon\Carbon::parse($p->tanggal_pinjam)->format('Y-m-d') : \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') }}">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak
                      </button>
                    </form>
                  @else
                    <button disabled class="px-4 py-2 bg-gradient-to-r from-gray-400 to-gray-500 text-white text-xs font-semibold rounded-xl shadow-lg border-2 border-gray-400 cursor-not-allowed opacity-60">
                      {{ ucfirst($p->status) }}
                    </button>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>
    </div>

    <!-- TABEL PROSES -->
    <div id="table-proses" class="hidden">
      <section>
        <div class="flex justify-between items-center mb-4">
          <h3 class="judul text-xl">Proses Pengembalian Buku</h3>
        </div>

        {{-- Stats removed as requested --}}

        {{-- CARDS --}}
        <div class="space-y-4">
          @forelse($proses as $p)
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-[#c9a44c]">
              {{-- USER HEADER --}}
              <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-[#c9a44c] text-white flex items-center justify-center font-bold">
                    {{ strtoupper(substr($p->user->username, 0, 1)) }}
                  </div>
                  <div>
                    <p class="font-semibold text-[#3e2a1f]">{{ $p->user->username }}</p>
                    <p class="text-xs text-[#6b5a4a]">{{ $p->user->email ?? '-' }}</p>
                  </div>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600">⋯</button>
              </div>

              {{-- BOOK INFO --}}
              <div class="bg-[#faf6ee] rounded-lg p-4 mb-4">
                <p class="text-xs text-[#6b5a4a] font-semibold mb-2">BUKU</p>
                <p class="font-semibold text-[#3e2a1f]">{{ $p->buku->judul }}</p>
              </div>

              {{-- DETAILS GRID --}}
              @php
                $prosesRec = $p->prosesKembali;
                // Debug: uncomment to see data
                // dd($p->id, $prosesRec);
                $tgl_pinjam = \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y');
                $tgl_kembali = $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d/m/Y') : '-';
                $tgl_dikembalikan = $prosesRec && $prosesRec->tanggal_dikembalikan ? \Carbon\Carbon::parse($prosesRec->tanggal_dikembalikan)->format('d/m/Y') : '-';
                $durasi = null;
                $durasiClass = '';
                if ($prosesRec && $prosesRec->tanggal_dikembalikan) {
                  $durasi = \Carbon\Carbon::parse($p->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($prosesRec->tanggal_dikembalikan));
                  if ($durasi > 7) $durasiClass = 'font-bold text-red-600';
                }
                $dendaDisplay = $prosesRec ? ('Rp ' . number_format($prosesRec->denda ?? 0, 0, ',', '.')) : 'Rp 0';
                $kondisiDisplay = $prosesRec ? ucfirst($prosesRec->kondisi_buku ?? 'baik') : 'baik';
              @endphp

              <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
                <div>
                  <p class="text-xs text-[#6b5a4a] font-semibold">Tgl Pinjam</p>
                  <p class="font-medium text-[#3e2a1f]">{{ $tgl_pinjam }}</p>
                </div>
                <div>
                  <p class="text-xs text-[#6b5a4a] font-semibold">Tgl Kembali (Seharusnya)</p>
                  <p class="font-medium text-[#3e2a1f]">{{ $tgl_kembali }}</p>
                </div>

                <div>
                  <p class="text-xs text-[#6b5a4a] font-semibold">Tgl Dikembalikan</p>
                  <p class="font-medium text-[#3e2a1f]">{{ $tgl_dikembalikan }}</p>
                </div>

                <div>
                  <p class="text-xs text-[#6b5a4a] font-semibold">Durasi</p>
                  <p class="{{ $durasiClass }}">{{ $durasi !== null ? $durasi . ' Hari' : '-' }}</p>
                </div>

                <div>
                  <p class="text-xs text-[#6b5a4a] font-semibold">Poin</p>
                  <p class="font-medium text-[#3e2a1f]">
                    <span id="poin-top-add-{{ $p->id }}" class="text-sm text-[#9f1239]">-</span>
                  </p>
                </div>
              </div>

              {{-- FORM: pilih kondisi dan denda --}}
              <div class="flex gap-3 flex-wrap items-center">
                <form action="{{ route('peminjaman.proseskembali', $p->id) }}" method="POST" class="flex items-center gap-3 proses-form" data-peminjaman-id="{{ $p->id }}">
                  @csrf
                  <label class="text-xs text-[#6b5a4a]">Kondisi</label>
                  <div class="flex items-center gap-2 kondisi-group" data-tgl-seharusnya="{{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('Y-m-d') : '' }}" data-tgl-dikembalikan="{{ $prosesRec && $prosesRec->tanggal_dikembalikan ? \Carbon\Carbon::parse($prosesRec->tanggal_dikembalikan)->format('Y-m-d') : now()->format('Y-m-d') }}">
                    @php $sel = $p->prosesKembali?->kondisi_buku ?? null; @endphp
                    @php
                      // support CSV stored kondisi like "telat,hilang"
                      $selArr = [];
                      if($sel) {
                        $selArr = array_map('trim', explode(',', $sel));
                      }
                    @endphp
                    <input id="k-{{ $p->id }}-baik" class="kondisi-checkbox hidden" type="checkbox" name="kondisi_buku[]" value="baik" {{ in_array('baik', $selArr) ? 'checked' : '' }}>
                    <label for="k-{{ $p->id }}-baik" class="kondisi-badge kondisi-baik cursor-pointer">Baik</label>

                    <input id="k-{{ $p->id }}-telat" class="kondisi-checkbox telat-checkbox hidden" type="checkbox" name="kondisi_buku[]" value="telat" {{ in_array('telat', $selArr) ? 'checked' : '' }}>
                    <label for="k-{{ $p->id }}-telat" class="kondisi-badge kondisi-telat cursor-pointer">Telat</label>

                    <input id="k-{{ $p->id }}-rusak" class="kondisi-checkbox hidden" type="checkbox" name="kondisi_buku[]" value="rusak" {{ in_array('rusak', $selArr) ? 'checked' : '' }}>
                    <label for="k-{{ $p->id }}-rusak" class="kondisi-badge kondisi-rusak cursor-pointer">Rusak</label>

                    <input id="k-{{ $p->id }}-hilang" class="kondisi-checkbox hidden" type="checkbox" name="kondisi_buku[]" value="hilang" {{ in_array('hilang', $selArr) ? 'checked' : '' }}>
                    <label for="k-{{ $p->id }}-hilang" class="kondisi-badge kondisi-hilang cursor-pointer">Hilang</label>
                  </div>
                    {{-- kondisi badge removed to avoid duplicate; use select value only --}}
                  <label class="text-xs text-[#6b5a4a]">Denda (Rp)</label>
                    <div class="flex items-center gap-2">
                    <input type="hidden" name="denda" value="{{ $p->prosesKembali ? $p->prosesKembali->denda : 0 }}" class="denda-input">
                    <span id="denda-display-{{ $p->id }}" class="denda-display">Rp {{ number_format($p->prosesKembali->denda ?? 0, 0, ',', '.') }}</span>
                    <button type="button" class="btn-detail px-5 py-3 bg-gradient-to-r from-[#c9a44c] to-[#b28f45] text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-2xl hover:from-[#b28f45] hover:to-[#a07a3d] transition-all duration-400 ease-in-out border-2 border-[#c9a44c] hover:border-[#b28f45] cursor-pointer backface-visibility-hidden" data-id="{{ $p->id }}" data-username="{{ $p->user->username }}" data-buku-judul="{{ $p->buku->judul }}" data-tgl-pinjam="{{ $p->tanggal_pinjam ?? $p->created_at->format('Y-m-d') }}" data-tgl-kembali="{{ $p->tanggal_kembali }}" data-status="{{ $p->status }}" data-telepon="{{ $p->nomer_hp ?? $p->user->no_hp ?? '-' }}" data-nama-lengkap="{{ $p->nama_lengkap ?? '-' }}" data-alamat="{{ $p->alamat ?? '-' }}" data-kode-pinjam="{{ $p->kode_pinjam ?? '-' }}">
                      <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                      Detail
                    </button>
                    {{-- poin inline removed; top shows new points only --}}
                  </div>
                </form>

                <form action="{{ route('pengembalian.selesai', $p->id) }}" method="POST" class="inline selesai-form" data-peminjaman-id="{{ $p->id }}">
                  @csrf
                  <input type="hidden" name="kondisi_buku" value="">
                  <input type="hidden" name="denda" value="">
                  <button type="button" class="btn-setujui px-5 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-2xl hover:from-green-700 hover:to-green-800 transition-all duration-400 ease-in-out border-2 border-green-600 hover:border-green-700 cursor-pointer backface-visibility-hidden" data-id="{{ $p->id }}" data-username="{{ $p->user->username }}" data-buku-judul="{{ $p->buku->judul }}" data-tgl-pinjam="{{ $p->tanggal_pinjam ?? $p->created_at->format('Y-m-d') }}" data-tgl-kembali="{{ $p->tanggal_kembali }}" data-status="{{ $p->status }}" data-telepon="{{ $p->nomer_hp ?? $p->user->no_hp ?? '-' }}" data-nama-lengkap="{{ $p->nama_lengkap ?? '-' }}" data-alamat="{{ $p->alamat ?? '-' }}" data-kode-pinjam="{{ $p->kode_pinjam ?? '-' }}">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Setujui
                  </button>
                </form>

                {{-- Tolak button removed per UX request --}}
              </div>
            </div>
          @empty
            <div class="bg-white rounded-lg p-8 text-center shadow">
              <p class="text-[#6b5a4a]">Tidak ada data proses pengembalian</p>
            </div>
          @endforelse
        </div>
      </section>
    </div>

    <!-- TABEL SELESAI -->
    <div id="table-selesai" class="hidden">
      <section>
        <div class="flex justify-between items-center mb-4">
          <h3 class="judul text-xl">Peminjaman Selesai</h3>
        </div>
        <div class="overflow-x-auto rounded-2xl shadow table-wrap">
          <table class="min-w-full bg-white">
            <thead class="bg-[#e7dcc8]">
              <tr>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">User</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Buku</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Durasi</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Kondisi Buku</th>
                <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Denda</th>
                <th class="px-4 py-3 text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach($selesai as $i => $pengembalian)
              @php
                $p = $pengembalian->peminjaman;
                // Kondisi buku dan denda diambil langsung dari pengembalian
                $tanggalPinjam = $p->tanggal_pinjam ?? $p->created_at;
                $tanggalKembali = $pengembalian->tanggal_kembali;
                $durasi = $tanggalPinjam && $tanggalKembali ? \Carbon\Carbon::parse($tanggalPinjam)->diffInDays(\Carbon\Carbon::parse($tanggalKembali)) : 0;
                $durasiClass = $durasi > 7 ? 'font-bold text-red-600' : '';
                $kondisiRaw = $pengembalian->kondisi_buku ?? '';
                $denda = $pengembalian->denda ?? 0;
                $kondisiArr = $kondisiRaw ? array_map('trim', explode(',', $kondisiRaw)) : [];
              @endphp
              <tr class="border-b hover:bg-[#faf6ee] transition">
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $loop->iteration }}</td>
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $p->user->username }}</td>
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $p->buku->judul }}</td>
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] {{ $durasiClass }}">{{ $durasi }} Hari</td>
                <td class="px-4 py-3">
                  @if(!empty($kondisiArr))
                    @foreach($kondisiArr as $kondisi)
                      <span class="kondisi-badge kondisi-{{ strtolower($kondisi) }} mr-1">{{ ucfirst($kondisi) }}</span>
                    @endforeach
                  @else
                    <span class="text-gray-500">-</span>
                  @endif
                </td>
                <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $denda ? 'Rp ' . number_format($denda, 0, ',', '.') : '-' }}</td>
                <td class="px-4 py-3 text-center space-x-1">
                  <button class="btn-detail-selesai px-4 py-2 bg-gradient-to-r from-[#c9a44c] to-[#b28f45] text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-[#b28f45] hover:to-[#a07a3d] transition-all duration-300 ease-in-out border-2 border-[#c9a44c] hover:border-[#b28f45] cursor-pointer backface-visibility-hidden mr-2" data-peminjaman-id="{{ $p->id }}" data-kode-pinjam="{{ $p->kode_pinjam ?? '-' }}" data-username="{{ $p->user->username }}" data-nama-lengkap="{{ $p->nama_lengkap ?? '-' }}" data-alamat="{{ $p->alamat ?? '-' }}" data-no-hp="{{ $p->nomer_hp ?? $p->user->no_hp ?? '-' }}" data-buku="{{ $p->buku->judul }}" data-tgl-pinjam="{{ $p->tanggal_pinjam ? \Carbon\Carbon::parse($p->tanggal_pinjam)->format('Y-m-d') : '-' }}" data-tgl-dikembalikan="{{ $pengembalian->tanggal_kembali ? \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('Y-m-d') : '-' }}" data-kondisi="{{ $kondisiRaw ? ucfirst(str_replace(',', ', ', $kondisiRaw)) : '-' }}" data-denda="{{ $denda ? 'Rp ' . number_format($denda, 0, ',', '.') : 'Rp 0' }}" data-foto-ktp="{{ $p->foto_ktp ? asset('storage/' . $p->foto_ktp) : '' }}">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Detail
                  </button>
                  <button disabled class="px-4 py-2 bg-gradient-to-r from-gray-400 to-gray-500 text-white text-xs font-semibold rounded-xl shadow-lg border-2 border-gray-400 cursor-not-allowed opacity-60">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Selesai
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>
    </div>

  </main>
</div>

<script>
  // Simpan nomor asli saat halaman load
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#table-aktif tbody tr').forEach((row, index) => {
      row.setAttribute('data-original-no', index + 1);
    });
    document.querySelectorAll('#table-proses tbody tr').forEach((row, index) => {
      row.setAttribute('data-original-no', index + 1);
    });
    document.querySelectorAll('#table-selesai tbody tr').forEach((row, index) => {
      row.setAttribute('data-original-no', index + 1);
    });
  });

  function showTab(tab) {
    const tabs = ['aktif','proses','selesai'];
    tabs.forEach(t => {
      document.getElementById('tab-'+t).classList.remove('active');
      if(t !== 'aktif') {
        document.getElementById('table-'+t).classList.add('hidden');
      }
    });
    
    if(tab === 'aktif') {
      document.getElementById('table-aktif').classList.remove('hidden');
      document.getElementById('table-proses').classList.add('hidden');
      document.getElementById('table-selesai').classList.add('hidden');
    } else {
      document.getElementById('table-aktif').classList.add('hidden');
      document.getElementById('table-'+tab).classList.remove('hidden');
    }
    
    document.getElementById('tab-'+tab).classList.add('active');
    
    // Save active tab to localStorage (only for non-default tabs)
    if (tab !== 'aktif') {
      localStorage.setItem('manajemenBukuActiveTab', tab);
    } else {
      localStorage.removeItem('manajemenBukuActiveTab');
    }
    
    // Reset nomor urutan untuk semua tabel
    resetTableNumbers();
  }

  function navigateToLaporan() {
    // Detect active tab and navigate to specific laporan page
    const activeTab = document.querySelector('.tab-card.active');
    const routes = {
      'petugas.laporan.peminjaman_aktif': '{{ route("petugas.laporan.peminjaman_aktif") }}',
      'petugas.laporan.proses_pengembalian': '{{ route("petugas.laporan.proses_pengembalian") }}',
      'petugas.laporan.selesai': '{{ route("petugas.laporan.selesai") }}'
    };

    let routeName = 'petugas.laporan.peminjaman_aktif'; // default
    if (activeTab?.id === 'tab-proses') routeName = 'petugas.laporan.proses_pengembalian';
    if (activeTab?.id === 'tab-selesai') routeName = 'petugas.laporan.selesai';

    window.location.href = routes[routeName];
  }

  // Handle URL parameter and localStorage for tab activation
  document.addEventListener('DOMContentLoaded', function() {
    // Force clear any invalid localStorage data first
    const currentSaved = localStorage.getItem('manajemenBukuActiveTab');
    if (currentSaved && !['aktif', 'proses', 'selesai'].includes(currentSaved)) {
      localStorage.removeItem('manajemenBukuActiveTab');
    }
    
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    
    // If there's a valid URL parameter, use it
    if (tabParam && ['aktif', 'proses', 'selesai'].includes(tabParam)) {
      showTab(tabParam);
      return;
    }
    
    // If no URL parameter, check localStorage but be very strict
    const savedTab = localStorage.getItem('manajemenBukuActiveTab');
    if (savedTab === 'proses' || savedTab === 'selesai') {
      showTab(savedTab);
    } else {
      // Force default to 'aktif' and clean localStorage
      localStorage.removeItem('manajemenBukuActiveTab');
      // Ensure tab 'aktif' is active (should already be by default)
      document.getElementById('tab-aktif').classList.add('active');
      document.getElementById('tab-proses').classList.remove('active');
      document.getElementById('tab-selesai').classList.remove('active');
      document.getElementById('table-aktif').classList.remove('hidden');
      document.getElementById('table-proses').classList.add('hidden');
      document.getElementById('table-selesai').classList.add('hidden');
    }
  });

  function resetTableNumbers() {
    // Reset tabel aktif
    let nomorAktif = 1;
    document.querySelectorAll('#table-aktif tbody tr').forEach(row => {
      row.style.display = '';
      row.querySelector('td:first-child').textContent = nomorAktif++;
    });

    // Reset tabel proses
    let nomorProses = 1;
    document.querySelectorAll('#table-proses tbody tr').forEach(row => {
      row.style.display = '';
      row.querySelector('td:first-child').textContent = nomorProses++;
    });

    // Reset tabel selesai
    let nomorSelesai = 1;
    document.querySelectorAll('#table-selesai tbody tr').forEach(row => {
      row.style.display = '';
      row.querySelector('td:first-child').textContent = nomorSelesai++;
    });
  }

  // SEARCH
  const searchInput = document.getElementById('searchInput');
  const searchBtn = document.getElementById('searchBtn');

  function filterTable() {
    const query = searchInput.value.toLowerCase().trim();
    if(query === '') return alert('Masukkan kata kunci pencarian!');

    const rowsAktif = document.querySelectorAll('#table-aktif tbody tr');
    let nomorAktif = 1;
    rowsAktif.forEach(row => {
      const text = row.textContent.toLowerCase();
      const isVisible = text.includes(query);
      row.style.display = isVisible ? '' : 'none';
      if(isVisible) {
        row.querySelector('td:first-child').textContent = nomorAktif++;
      }
    });

    const rowsProses = document.querySelectorAll('#table-proses tbody tr');
    let nomorProses = 1;
    rowsProses.forEach(row => {
      const text = row.textContent.toLowerCase();
      const isVisible = text.includes(query);
      row.style.display = isVisible ? '' : 'none';
      if(isVisible) {
        row.querySelector('td:first-child').textContent = nomorProses++;
      }
    });

    const rowsSelesai = document.querySelectorAll('#table-selesai tbody tr');
    let nomorSelesai = 1;
    rowsSelesai.forEach(row => {
      const text = row.textContent.toLowerCase();
      const isVisible = text.includes(query);
      row.style.display = isVisible ? '' : 'none';
      if(isVisible) {
        row.querySelector('td:first-child').textContent = nomorSelesai++;
      }
    });
  }

  searchBtn.addEventListener('click', filterTable);
  searchInput.addEventListener('keypress', e => {
    if(e.key === 'Enter') filterTable();
  });

  // Download report button: navigate to unified laporan route
  // (Now using simple link instead)
</script>

<!-- DETAIL MODAL -->
<script>
  // All JavaScript for modals and interactions
  document.addEventListener('DOMContentLoaded', function(){
    // DETAIL MODAL FUNCTIONS
    function showDetail(id, username, bukuJudul, tglPinjam, tglKembali, status, telepon, namaLengkap, alamat, kodePinjam, fotoKtp, kondisi = 'Baik', denda = 0) {
      // Ensure no other modals are open
      const confirmModal = document.getElementById('confirmSelesaiModal');
      confirmModal.classList.add('hidden');
      confirmModal.classList.remove('flex');
      console.log('Opening detail modal for id:', id);
      const modal = document.getElementById('detailModal');
      document.getElementById('detailId').textContent = '#' + id;
      document.getElementById('detailKodePinjam').textContent = kodePinjam;
      document.getElementById('detailUsername').textContent = username;
      document.getElementById('detailNamaLengkap').textContent = namaLengkap;
      document.getElementById('detailAlamat').textContent = alamat;
      document.getElementById('detailNoHp').textContent = telepon;
      
      // Handle foto KTP
      const fotoKtpImg = document.getElementById('detailFotoKtpImg');
      const fotoKtpPlaceholder = document.getElementById('detailFotoKtpPlaceholder');
      if (fotoKtp && fotoKtp.trim() !== '') {
        fotoKtpImg.src = fotoKtp;
        fotoKtpImg.style.display = 'block';
        fotoKtpPlaceholder.style.display = 'none';
      } else {
        fotoKtpImg.style.display = 'none';
        fotoKtpPlaceholder.style.display = 'flex';
      }
      
      document.getElementById('detailBuku').textContent = bukuJudul;
      document.getElementById('detailTglPinjam').textContent = tglPinjam;
      document.getElementById('detailTglKembali').textContent = tglKembali || '-';
      
      let statusColor = 'bg-amber-100 text-amber-700';
      let statusIcon = '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
      if(status === 'dipinjam') {
        statusColor = 'bg-blue-100 text-blue-700';
        statusIcon = '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>';
      }
      if(status === 'terlambat') {
        statusColor = 'bg-red-100 text-red-700';
        statusIcon = '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>';
      }
      if(status === 'selesai') {
        statusColor = 'bg-green-100 text-green-700';
        statusIcon = '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
      }
      
      document.getElementById('detailStatusBadge').className = 'inline-block px-4 py-2 rounded-full font-semibold text-sm ' + statusColor;
      document.getElementById('detailStatusBadge').innerHTML = statusIcon + ' ' + status;
      
      // Handle pengembalian info for selesai status
      const pengembalianSection = document.getElementById('detailPengembalianSection');
      if(status === 'selesai') {
        pengembalianSection.classList.remove('hidden');
        
        // Calculate actual return date and duration
        const tglPinjam = new Date(data.tglPinjam);
        const tglKembali = new Date(data.tglKembali);
        const durasi = Math.max(0, Math.floor((tglKembali - tglPinjam) / (1000 * 60 * 60 * 24)));
        
        document.getElementById('detailTglDikembalikan').textContent = data.tglKembali || '-';
        document.getElementById('detailDurasi').textContent = durasi + ' Hari';
        document.getElementById('detailKondisi').textContent = kondisi || 'Baik';
        document.getElementById('detailDenda').textContent = denda && parseInt(denda) > 0 ? 'Rp ' + parseInt(denda).toLocaleString('id-ID') : 'Rp 0';
      } else {
        pengembalianSection.classList.add('hidden');
      }
      
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      console.log('Detail modal shown');
    }

    function closeDetail() {
      const modal = document.getElementById('detailModal');
      modal.style.display = 'none';
      console.log('Detail modal closed');
    }

    // Close detail modal on backdrop click
    document.getElementById('detailModal').addEventListener('click', function(e) {
      if(e.target === this) closeDetail();
    });

    // Close detail modal on close button click
    document.addEventListener('click', function(e){
      if(e.target.classList.contains('btn-close-detail') || e.target.closest('.btn-close-detail')){
        console.log('Close button clicked');
        closeDetail();
      }
    });

    // Auto-calc denda & poin
    const telatPerHari = {{ config('denda.telat_per_hari', 5000) }};
    const rusakFlat = {{ config('denda.rusak_flat', 50000) }};
    const hilangFlat = {{ config('denda.hilang_flat', 100000) }};

    function parseDate(s) {
      if(!s) return null;
      // Accepts 'YYYY-MM-DD' or 'YYYY-MM-DD HH:MM:SS' or full ISO.
      const datePart = (''+s).split(' ')[0];
      const parts = datePart.split('-');
      if(parts.length === 3) {
        return new Date(parts[0], parts[1]-1, parts[2]);
      }
      // fallback: try Date constructor
      const d = new Date(s);
      return isNaN(d.getTime()) ? null : d;
    }

    function diffDays(a,b){
      // diff b - a in days
      const _MS_PER_DAY = 1000*60*60*24;
      return Math.max(0, Math.floor((b - a) / _MS_PER_DAY));
    }

    function updateForm(form){
      const kondisiGroup = form.querySelector('.kondisi-group') || form;
      const dendaInput = form.querySelector('.denda-input');
      const peminjamanId = form.dataset.peminjamanId;
      if(!dendaInput) return;

      // read dates from kondisi-group dataset if present
      const tglSeharusnya = parseDate(kondisiGroup.dataset.tglSeharusnya || kondisiGroup.querySelector('.kondisi-select')?.dataset?.tglSeharusnya);
      const tglDikembalikan = parseDate(kondisiGroup.dataset.tglDikembalikan || kondisiGroup.querySelector('.kondisi-select')?.dataset?.tglDikembalikan) || new Date();
      const hariTelat = tglSeharusnya ? diffDays(tglSeharusnya, tglDikembalikan) : 0;

      // if there is lateness, prefer auto-select 'telat' unless rusak/hilang already chosen
      const telatInpLocal = form.querySelector('input.kondisi-checkbox[value="telat"]');
      const rusakInp = form.querySelector('input.kondisi-checkbox[value="rusak"]');
      const hilangInp = form.querySelector('input.kondisi-checkbox[value="hilang"]');
      const baikInp = form.querySelector('input.kondisi-checkbox[value="baik"]');
      if(telatInpLocal){
        if(hariTelat > 0){
          telatInpLocal.checked = true;
          if(baikInp){ baikInp.checked = false; baikInp.disabled = true; const bl = form.querySelector('label[for="'+baikInp.id+'"]'); bl?.classList.add('disabled'); }
        }
      }

      // read checked conditions (supports single legacy value or array)
      const checked = Array.from(form.querySelectorAll('input[name="kondisi_buku[]"]:checked')).map(i => i.value);
      let kalkDenda = 0;
      let poin = 0;

      // If nothing selected, default to 'baik'
      const kondisiArr = checked.length ? checked : ['baik'];

      // If 'baik' is selected together with others, treat as others (baik exclusive)
      const effective = kondisiArr.includes('baik') && kondisiArr.length > 1 ? kondisiArr.filter(k => k !== 'baik') : kondisiArr;

      // compute sum of denda & poin for multiple violations
      effective.forEach(kondisi => {
        if(kondisi === 'baik'){
          kalkDenda += (hariTelat > 0 ? hariTelat * telatPerHari : 0);
          poin += 0;
        } else if(kondisi === 'telat'){
          // only allow telat calculation when there is actual lateness
          if(hariTelat > 0) {
            kalkDenda += hariTelat * telatPerHari;
            poin += 10;
          }
        } else if(kondisi === 'rusak'){
          kalkDenda += rusakFlat;
          poin += 20;
        } else if(kondisi === 'hilang'){
          kalkDenda += hilangFlat;
          poin += 30;
        }
      });

      // enforce inputs to match effective selection (baik exclusive)
      const inputsAll = Array.from(form.querySelectorAll('input.kondisi-checkbox'));
      inputsAll.forEach(inp => {
        inp.checked = effective.includes(inp.value);
      });

      // ensure telat label shows disabled state when unchecked/disabled
      const telatInp = form.querySelector('.telat-checkbox');
      if(telatInp){
        const telatLabel = form.querySelector('label[for="' + telatInp.id + '"]');
        if(telatInp.disabled){
          telatLabel?.classList.add('disabled');
        } else {
          telatLabel?.classList.remove('disabled');
        }
      }

      // Ensure numeric and set default value (petugas can still edit before submit)
      kalkDenda = Number(kalkDenda) || 0;
      dendaInput.value = kalkDenda;
      // update formatted display
      const dendaDisplay = document.getElementById('denda-display-' + peminjamanId);
      if(dendaDisplay){
        dendaDisplay.textContent = 'Rp ' + kalkDenda.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      }

      // update top-add (new points only)
      const topAdd = document.getElementById('poin-top-add-' + peminjamanId);
      if(topAdd){
        topAdd.textContent = poin > 0 ? ('+ ' + poin) : '-';
        if(poin > 0) topAdd.classList.add('positive'); else topAdd.classList.remove('positive');
      }

      // update top poin summary (replace denda that was above)
      const poinTop = document.getElementById('poin-top-' + peminjamanId);
      const poinTopAdd = document.getElementById('poin-top-add-' + peminjamanId);
      // leave current top poin (server value) intact; only show addition in poinTopAdd
      // (poinTop exists in DOM with server-rendered value)
      if(poinTopAdd){
        poinTopAdd.textContent = poin > 0 ? ('+ ' + poin) : '';
      }

      // kondisi badge removed; no DOM update needed
    }

    // Attach listeners and extra behavior for checkboxes
    document.querySelectorAll('.proses-form').forEach(form => {
      // initialize
      updateForm(form);
      const group = form.querySelector('.kondisi-group');
      const telatCheckbox = form.querySelector('.telat-checkbox');
      const checkboxes = Array.from(form.querySelectorAll('input[name="kondisi_buku[]"]'));

      // enforce that 'telat' checkbox is disabled when there is no lateness
      if(group){
        const tglSeharusnya = parseDate(group.dataset.tglSeharusnya);
        const tglDikembalikan = parseDate(group.dataset.tglDikembalikan) || new Date();
        const hariTelat = tglSeharusnya ? diffDays(tglSeharusnya, tglDikembalikan) : 0;
        if(telatCheckbox){
          if(hariTelat <= 0){
            telatCheckbox.disabled = true;
            telatCheckbox.checked = false;
          } else {
            telatCheckbox.disabled = false;
          }
        }
        // If there is lateness, disable 'Baik' (cannot be both late and marked 'Baik')
        const baikInput = form.querySelector('input.kondisi-checkbox[value="baik"]');
        if(baikInput){
          if(hariTelat > 0){
            baikInput.disabled = true;
            baikInput.checked = false;
          } else {
            baikInput.disabled = false;
          }
          const baikLabel = form.querySelector('label[for="' + baikInput.id + '"]');
          if(baikInput.disabled) baikLabel?.classList.add('disabled'); else baikLabel?.classList.remove('disabled');
        }
      }

      checkboxes.forEach(cb => {
        cb.addEventListener('change', function(){
          // if 'baik' selected, uncheck others
          if(this.value === 'baik' && this.checked){
            checkboxes.forEach(c => { if(c.value !== 'baik') c.checked = false; });
          }
          // if any other selected, uncheck 'baik'
          if(this.value !== 'baik' && this.checked){
            checkboxes.forEach(c => { if(c.value === 'baik') c.checked = false; });
          }
          // rusak and hilang are mutually exclusive
          if(this.value === 'rusak' && this.checked){
            const hilang = form.querySelector('input.kondisi-checkbox[value="hilang"]'); if(hilang) hilang.checked = false;
          }
          if(this.value === 'hilang' && this.checked){
            const rusak = form.querySelector('input.kondisi-checkbox[value="rusak"]'); if(rusak) rusak.checked = false;
          }

          // if telat checked, ensure 'Baik' cannot be checked
          if(this.value === 'telat'){
            const baik = form.querySelector('input.kondisi-checkbox[value="baik"]');
            if(baik && this.checked){ baik.checked = false; baik.disabled = true; const lab = form.querySelector('label[for="' + baik.id + '"]'); lab?.classList.add('disabled'); }
            if(baik && !this.checked){ baik.disabled = false; const lab = form.querySelector('label[for="' + baik.id + '"]'); lab?.classList.remove('disabled'); }
          }

          updateForm(form);
        });
      });
    });

    // Event listener for Detail buttons
    document.addEventListener('click', function(e){
      if(e.target.classList.contains('btn-detail') || e.target.closest('.btn-detail')){
        e.preventDefault();
        const btn = e.target.classList.contains('btn-detail') ? e.target : e.target.closest('.btn-detail');
        const data = btn.dataset;
        console.log('Data attributes:', data);
        
        // Force show modal for testing
        const modal = document.getElementById('detailModal');
        modal.style.display = 'flex';
        console.log('Modal forced to show with display flex');
        
        showDetail(data.id, data.username, data.bukuJudul, data.tglPinjam, data.tglKembali, data.status, data.telepon, data.namaLengkap, data.alamat, data.kodePinjam, data.fotoKtp, data.kondisi || 'Baik', data.denda || '0');
      }
    });

    // Confirmation modal for Setujui using event delegation
    let pendingForm = null;
    document.addEventListener('click', function(e){
      if(e.target.classList.contains('btn-setujui') || e.target.closest('.btn-setujui')){
        e.preventDefault();
        const btn = e.target.classList.contains('btn-setujui') ? e.target : e.target.closest('.btn-setujui');
        // Close detail modal if open
        document.getElementById('detailModal').classList.add('hidden');
        const form = btn.closest('.selesai-form');
        if(!form) return;
        pendingForm = form;
        const id = form.dataset.peminjamanId;
        const prosesForm = document.querySelector('.proses-form[data-peminjaman-id="' + id + '"]');
        
        // Get data from proses form dataset or button dataset
        const data = btn.dataset;
        
        // Fill modal with detailed information
        document.getElementById('confirmId').textContent = '#' + String(id).padStart(6, '0');
        document.getElementById('confirmKodePinjam').textContent = data.kodePinjam || '-';
        document.getElementById('confirmUsername').textContent = data.username || '-';
        document.getElementById('confirmNamaLengkap').textContent = data.namaLengkap || '-';
        document.getElementById('confirmAlamat').textContent = data.alamat || '-';
        document.getElementById('confirmNoHp').textContent = data.telepon || '-';
        document.getElementById('confirmBuku').textContent = data.bukuJudul || '-';
        document.getElementById('confirmTglPinjam').textContent = data.tglPinjam || '-';
        document.getElementById('confirmTglDikembalikan').textContent = prosesForm ? prosesForm.querySelector('.kondisi-group')?.dataset?.tglDikembalikan || new Date().toISOString().substring(0, 10) : '-';
        
        // Status badge
        let statusColor = 'bg-blue-100 text-blue-700';
        let statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6v16zM18 6h-6v14h6a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/></svg>';
        document.getElementById('confirmStatusBadge').className = 'inline-block px-4 py-2 rounded-full font-semibold text-sm ' + statusColor;
        document.getElementById('confirmStatusBadge').innerHTML = statusIcon + ' Proses Pengembalian';
        
        // Get denda and poin
        const dendaInput = prosesForm ? prosesForm.querySelector('.denda-input') : null;
        const denda = dendaInput ? Number(dendaInput.value) : 0;
        const poinText = document.getElementById('poin-top-add-' + id)?.textContent || '-';
        let poin = 0;
        if(poinText && poinText.trim().startsWith('+')){
          poin = Number(poinText.replace(/\D/g,'')) || 0;
        }

        // conditions
        const kondisiChecked = prosesForm ? Array.from(prosesForm.querySelectorAll('input.kondisi-checkbox:checked')).map(i => {
          const lab = document.querySelector('label[for="' + i.id + '"]');
          return lab ? lab.textContent.trim() : i.value;
        }) : [];

        // fill summary section
        document.getElementById('confirmDenda').textContent = 'Rp ' + denda.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        document.getElementById('confirmPoin').textContent = poin > 0 ? ('+ ' + poin) : '-';
        const list = document.getElementById('confirmKondisiList'); list.innerHTML = '';
        if(kondisiChecked.length === 0) {
          const span = document.createElement('span'); span.className = 'kondisi-badge kondisi-baik'; span.textContent = 'Baik'; list.appendChild(span);
        } else {
          kondisiChecked.forEach(k => {
            const s = document.createElement('span'); s.className = 'kondisi-badge mr-2'; s.textContent = k; list.appendChild(s);
          });
        }

        // Populate hidden inputs in selesai-form with current data
        if(pendingForm) {
          const kondisiValue = kondisiChecked.length > 0 ? kondisiChecked.join(',') : 'baik';
          const kondisiInput = pendingForm.querySelector('input[name="kondisi_buku"]');
          const dendaInput = pendingForm.querySelector('input[name="denda"]');
          if(kondisiInput) kondisiInput.value = kondisiValue;
          if(dendaInput) dendaInput.value = denda;
        }

        // Show modal
        const modal = document.getElementById('confirmSelesaiModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        console.log('Confirm modal shown');
      }
    });

    // Close confirm modal on backdrop click
    document.getElementById('confirmSelesaiModal').addEventListener('click', function(e) {
      if(e.target === this) {
        const modal = document.getElementById('confirmSelesaiModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        pendingForm = null;
        console.log('Confirm modal closed via backdrop');
      }
    });

    // Close confirm modal on close button click
    document.addEventListener('click', function(e){
      if(e.target.classList.contains('btn-close-confirm') || e.target.closest('.btn-close-confirm')){
        const modal = document.getElementById('confirmSelesaiModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        pendingForm = null;
        console.log('Confirm modal closed via button');
      }
    });

    document.getElementById('cancelSelesaiBtn').addEventListener('click', function(){
      const modal = document.getElementById('confirmSelesaiModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      pendingForm = null;
      console.log('Confirm modal cancelled');
    });

    document.getElementById('confirmSelesaiBtn').addEventListener('click', function(){
      if(pendingForm) {
        pendingForm.submit();
      }
    });

    // MODAL KONFIRMASI SETUJUI PEMINJAMAN AKTIF
    let pendingSetujuiForm = null;
    document.addEventListener('click', function(e){
      if(e.target.classList.contains('btn-setujui-aktif') || e.target.closest('.btn-setujui-aktif')){
        e.preventDefault();
        const btn = e.target.classList.contains('btn-setujui-aktif') ? e.target : e.target.closest('.btn-setujui-aktif');
        const form = btn.closest('form');
        if(!form) return;
        pendingSetujuiForm = form;

        // Get data from button dataset
        const data = btn.dataset;
        document.getElementById('confirmSetujuiUsername').textContent = data.username || '-';
        document.getElementById('confirmSetujuiBuku').textContent = data.bukuJudul || '-';
        document.getElementById('confirmSetujuiTglPinjam').textContent = data.tglPinjam || '-';

        // Show modal
        const modal = document.getElementById('confirmSetujuiModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }
    });

    // MODAL KONFIRMASI TOLAK PEMINJAMAN AKTIF
    let pendingTolakForm = null;
    document.addEventListener('click', function(e){
      if(e.target.classList.contains('btn-tolak-aktif') || e.target.closest('.btn-tolak-aktif')){
        e.preventDefault();
        const btn = e.target.classList.contains('btn-tolak-aktif') ? e.target : e.target.closest('.btn-tolak-aktif');
        const form = btn.closest('form');
        if(!form) return;
        pendingTolakForm = form;

        // Get data from button dataset
        const data = btn.dataset;
        document.getElementById('confirmTolakUsername').textContent = data.username || '-';
        document.getElementById('confirmTolakBuku').textContent = data.bukuJudul || '-';
        document.getElementById('confirmTolakTglPinjam').textContent = data.tglPinjam || '-';

        // Show modal
        const modal = document.getElementById('confirmTolakModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }
    });

    // CLOSE MODAL SETUJUI
    document.getElementById('cancelSetujuiBtn').addEventListener('click', function(){
      const modal = document.getElementById('confirmSetujuiModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      pendingSetujuiForm = null;
    });

    // CLOSE MODAL TOLAK
    document.getElementById('cancelTolakBtn').addEventListener('click', function(){
      const modal = document.getElementById('confirmTolakModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      pendingTolakForm = null;
    });

    // CONFIRM SETUJUI
    document.getElementById('confirmSetujuiBtn').addEventListener('click', function(){
      if(pendingSetujuiForm) {
        pendingSetujuiForm.submit();
      }
    });

    // CONFIRM TOLAK
    document.getElementById('confirmTolakBtn').addEventListener('click', function(){
      if(pendingTolakForm) {
        pendingTolakForm.submit();
      }
    });

    // CLOSE MODAL ON BACKDROP CLICK
    document.getElementById('confirmSetujuiModal').addEventListener('click', function(e) {
      if(e.target === this) {
        this.classList.add('hidden');
        this.classList.remove('flex');
        pendingSetujuiForm = null;
      }
    });

    document.getElementById('confirmTolakModal').addEventListener('click', function(e) {
      if(e.target === this) {
        this.classList.add('hidden');
        this.classList.remove('flex');
        pendingTolakForm = null;
      }
    });

    // Event listener untuk tombol detail di tab selesai
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-detail-selesai')) {
            e.preventDefault();
            const peminjamanId = e.target.getAttribute('data-peminjaman-id');
            const kodePinjam = e.target.getAttribute('data-kode-pinjam');
            const username = e.target.getAttribute('data-username');
            const namaLengkap = e.target.getAttribute('data-nama-lengkap');
            const alamat = e.target.getAttribute('data-alamat');
            const noHp = e.target.getAttribute('data-no-hp');
            const buku = e.target.getAttribute('data-buku');
            const tglPinjam = e.target.getAttribute('data-tgl-pinjam');
            const tglDikembalikan = e.target.getAttribute('data-tgl-dikembalikan');
            const durasi = e.target.getAttribute('data-durasi');
            const kondisi = e.target.getAttribute('data-kondisi');
            const denda = e.target.getAttribute('data-denda');
            const fotoKtp = e.target.getAttribute('data-foto-ktp');

            showDetailSelesaiModal(peminjamanId, kodePinjam, username, namaLengkap, alamat, noHp, buku, tglPinjam, tglDikembalikan, durasi, kondisi, denda, fotoKtp);
        }
    });

    // Fungsi untuk menampilkan modal detail selesai
    function showDetailSelesaiModal(peminjamanId, kodePinjam, username, namaLengkap, alamat, noHp, buku, tglPinjam, tglDikembalikan, durasi, kondisi, denda, fotoKtp) {
        document.getElementById('detailSelesaiId').textContent = peminjamanId;
        document.getElementById('detailSelesaiKodePinjam').textContent = kodePinjam;
        document.getElementById('detailSelesaiUsername').textContent = username;
        document.getElementById('detailSelesaiNamaLengkap').textContent = namaLengkap;
        document.getElementById('detailSelesaiAlamat').textContent = alamat;
        document.getElementById('detailSelesaiNoHp').textContent = noHp;
        
        // Handle foto KTP
        const fotoKtpImg = document.getElementById('detailSelesaiFotoKtpImg');
        const fotoKtpPlaceholder = document.getElementById('detailSelesaiFotoKtpPlaceholder');
        if (fotoKtp && fotoKtp.trim() !== '') {
          fotoKtpImg.src = fotoKtp;
          fotoKtpImg.style.display = 'block';
          fotoKtpPlaceholder.style.display = 'none';
        } else {
          fotoKtpImg.style.display = 'none';
          fotoKtpPlaceholder.style.display = 'flex';
        }
        
        document.getElementById('detailSelesaiBuku').textContent = buku;
        document.getElementById('detailSelesaiTglPinjam').textContent = tglPinjam;
        document.getElementById('detailSelesaiTglDikembalikan').textContent = tglDikembalikan;
        document.getElementById('detailSelesaiDurasi').textContent = durasi;
        document.getElementById('detailSelesaiKondisi').textContent = kondisi;
        document.getElementById('detailSelesaiDenda').textContent = denda;

        document.getElementById('detailSelesaiModal').classList.remove('hidden');
        document.getElementById('detailSelesaiModal').classList.add('flex');
    }

    // Event listener untuk tombol close modal detail selesai
    document.querySelector('.btn-close-detail-selesai').addEventListener('click', function() {
        document.getElementById('detailSelesaiModal').classList.add('hidden');
        document.getElementById('detailSelesaiModal').classList.remove('flex');
    });

    // Event listener untuk klik di luar modal detail selesai
    document.getElementById('detailSelesaiModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
            this.classList.remove('flex');
        }
    });
  });
</script>

<script>
  // Image Modal Functions
  function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('imageModalImg');
    img.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  // Close image modal on backdrop click
  document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeImageModal();
    }
  });

  // Close image modal on escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeImageModal();
    }
  });
</script>

<!-- DETAIL MODAL -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 p-4">
  <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#c9a44c] to-[#8a6a3f] p-6 flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-bold text-white">Detail Peminjaman</h2>
        <p class="text-amber-50 text-sm mt-1">Informasi lengkap peminjaman buku</p>
      </div>
      <button class="btn-close-detail text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- CONTENT -->
    <div class="p-8">
      <!-- STATUS BADGE -->
      <div class="mb-6 flex items-center gap-3">
        <div id="detailStatusBadge" class="inline-block px-4 py-2 rounded-full font-semibold text-sm"></div>
        <span class="text-[#7a5c45] text-sm">ID Peminjaman: <strong id="detailId"></strong></span>
      </div>

      <!-- KODE PINJAM -->
      <div class="mb-6 p-4 bg-[#faf6ee] rounded-xl border-2 border-[#c9a44c]">
        <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Kode Peminjaman</p>
        <p id="detailKodePinjam" class="text-xl font-bold text-[#c9a44c] font-mono"></p>
      </div>

      <!-- TWO COLUMN LAYOUT -->
      <div class="grid grid-cols-2 gap-6 mb-6">
        <!-- KOLOM KIRI: DATA PEMINJAM -->
        <div>
          <h3 class="text-lg font-bold text-[#3e2a1f] mb-4 pb-2 border-b-2 border-[#e0d5c7] flex items-center gap-2">
            <svg class="w-5 h-5 text-[#c9a44c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Data Peminjam
          </h3>
          
          <div class="space-y-4">
            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Username</p>
              <p id="detailUsername" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Nama Lengkap</p>
              <p id="detailNamaLengkap" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Alamat</p>
              <p id="detailAlamat" class="text-sm font-semibold text-[#3e2a1f] leading-relaxed"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">No. Telepon</p>
              <p id="detailNoHp" class="text-sm font-semibold text-[#3e2a1f] font-mono">-</p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Foto Identitas</p>
              <div id="detailFotoKtp" class="mt-2">
                <img id="detailFotoKtpImg" src="" alt="Foto KTP/KIA/Kartu Pelajar" class="w-full h-48 object-cover rounded-xl border-2 border-[#e0d5c7] shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer" style="display: none;" onclick="openImageModal(this.src)">
                <div id="detailFotoKtpPlaceholder" class="w-full h-48 border-2 border-dashed border-[#e0d5c7] rounded-xl flex items-center justify-center bg-[#faf6ee]/50">
                  <div class="text-center">
                    <svg class="w-16 h-16 text-[#c9a44c] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-[#7a5c45] font-medium">Belum upload foto</p>
                    <p class="text-xs text-[#6b5a4a]">KTP/KIA/Kartu Pelajar</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- KOLOM KANAN: DATA BUKU -->
        <div>
          <h3 class="text-lg font-bold text-[#3e2a1f] mb-4 pb-2 border-b-2 border-[#e0d5c7] flex items-center gap-2">
            <svg class="w-5 h-5 text-[#c9a44c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Data Buku
          </h3>
          
          <div class="space-y-4">
            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Judul Buku</p>
              <p id="detailBuku" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Tanggal Pinjam</p>
              <p id="detailTglPinjam" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Tanggal Kembali (Seharusnya)</p>
              <p id="detailTglKembali" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- DETAIL MODAL SELESAI (khusus untuk peminjaman yang sudah selesai) -->
<div id="detailSelesaiModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 p-4">
  <div class="bg-white rounded-2xl max-w-3xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#c9a44c] to-[#8a6a3f] p-6 flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-bold text-white">Detail Peminjaman Selesai</h2>
        <p class="text-amber-50 text-sm mt-1">Informasi lengkap peminjaman dan pengembalian buku</p>
      </div>
      <button class="btn-close-detail-selesai text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- CONTENT -->
    <div class="p-8">
      <!-- STATUS BADGE -->
      <div class="mb-6 flex items-center gap-3">
        <div id="detailSelesaiStatusBadge" class="inline-block px-4 py-2 rounded-full font-semibold text-sm bg-green-100 text-green-700 flex items-center gap-1">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Selesai
        </div>
        <span class="text-[#7a5c45] text-sm">ID Peminjaman: <strong id="detailSelesaiId"></strong></span>
      </div>

      <!-- KODE PINJAM -->
      <div class="mb-6 p-4 bg-[#faf6ee] rounded-xl border-2 border-[#c9a44c]">
        <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Kode Peminjaman</p>
        <p id="detailSelesaiKodePinjam" class="text-xl font-bold text-[#c9a44c] font-mono"></p>
      </div>

      <!-- TWO COLUMN LAYOUT -->
      <div class="grid grid-cols-2 gap-6 mb-6">
        <!-- KOLOM KIRI: DATA PEMINJAM -->
        <div>
          <h3 class="text-lg font-bold text-[#3e2a1f] mb-4 pb-2 border-b-2 border-[#e0d5c7]">
            <svg class="w-5 h-5 text-[#c9a44c] inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Data Peminjam
          </h3>

          <div class="space-y-4">
            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Username</p>
              <p id="detailSelesaiUsername" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Nama Lengkap</p>
              <p id="detailSelesaiNamaLengkap" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Alamat</p>
              <p id="detailSelesaiAlamat" class="text-sm font-semibold text-[#3e2a1f] leading-relaxed"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">No. Telepon</p>
              <p id="detailSelesaiNoHp" class="text-sm font-semibold text-[#3e2a1f] font-mono">-</p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Foto Identitas</p>
              <div id="detailSelesaiFotoKtp" class="mt-2">
                <img id="detailSelesaiFotoKtpImg" src="" alt="Foto KTP/KIA/Kartu Pelajar" class="w-full h-48 object-cover rounded-xl border-2 border-[#e0d5c7] shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer" style="display: none;" onclick="openImageModal(this.src)">
                <div id="detailSelesaiFotoKtpPlaceholder" class="w-full h-48 border-2 border-dashed border-[#e0d5c7] rounded-xl flex items-center justify-center bg-[#faf6ee]/50">
                  <div class="text-center">
                    <svg class="w-16 h-16 text-[#c9a44c] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-[#7a5c45] font-medium">Belum upload foto</p>
                    <p class="text-xs text-[#6b5a4a]">KTP/KIA/Kartu Pelajar</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- KOLOM KANAN: DATA BUKU DAN PENGEMBALIAN -->
        <div>
          <h3 class="text-lg font-bold text-[#3e2a1f] mb-4 pb-2 border-b-2 border-[#e0d5c7] flex items-center gap-2">
            <svg class="w-5 h-5 text-[#c9a44c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Data Buku & Pengembalian
          </h3>

          <div class="space-y-4">
            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Judul Buku</p>
              <p id="detailSelesaiBuku" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Tanggal Pinjam</p>
              <p id="detailSelesaiTglPinjam" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Tanggal Dikembalikan</p>
              <p id="detailSelesaiTglDikembalikan" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Durasi Pinjaman</p>
              <p id="detailSelesaiDurasi" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Kondisi Buku</p>
              <p id="detailSelesaiKondisi" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Denda</p>
              <p id="detailSelesaiDenda" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL KONFIRMASI SETUJUI PEMINJAMAN -->
<div id="confirmSetujuiModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 p-4">
  <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl p-6">
    <div class="text-center">
      <!-- ICON -->
      <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
      </div>

      <!-- TITLE -->
      <h3 class="text-xl font-bold text-gray-900 mb-2">Setujui Peminjaman Buku</h3>
      <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menyetujui peminjaman buku ini?</p>

      <!-- INFO -->
      <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="text-sm space-y-2">
          <div class="flex justify-between">
            <span class="text-gray-600">Peminjam:</span>
            <span class="font-medium text-gray-900" id="confirmSetujuiUsername">-</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Buku:</span>
            <span class="font-medium text-gray-900" id="confirmSetujuiBuku">-</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Tanggal Pinjam:</span>
            <span class="font-medium text-gray-900" id="confirmSetujuiTglPinjam">-</span>
          </div>
        </div>
      </div>

      <!-- BUTTONS -->
      <div class="flex gap-3 justify-center">
        <button id="cancelSetujuiBtn" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition">
          Batal
        </button>
        <button id="confirmSetujuiBtn" class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
          <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Setujui
        </button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL KONFIRMASI TOLAK PEMINJAMAN -->
<div id="confirmTolakModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 p-4">
  <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl p-6">
    <div class="text-center">
      <!-- ICON -->
      <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </div>

      <!-- TITLE -->
      <h3 class="text-xl font-bold text-gray-900 mb-2">Tolak Peminjaman Buku</h3>
      <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menolak peminjaman buku ini?</p>

      <!-- INFO -->
      <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="text-sm space-y-2">
          <div class="flex justify-between">
            <span class="text-gray-600">Peminjam:</span>
            <span class="font-medium text-gray-900" id="confirmTolakUsername">-</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Buku:</span>
            <span class="font-medium text-gray-900" id="confirmTolakBuku">-</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Tanggal Pinjam:</span>
            <span class="font-medium text-gray-900" id="confirmTolakTglPinjam">-</span>
          </div>
        </div>
      </div>

      <!-- BUTTONS -->
      <div class="flex gap-3 justify-center">
        <button id="cancelTolakBtn" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition">
          Batal
        </button>
        <button id="confirmTolakBtn" class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
          <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
          Tolak
        </button>
      </div>
    </div>
  </div>
</div>
<div id="confirmSelesaiModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 p-4">
  <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
    <!-- HEADER -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-bold text-white">Konfirmasi Pengembalian Buku</h2>
        <p class="text-green-50 text-sm mt-1">Periksa detail sebelum menyetujui pengembalian</p>
      </div>
      <button class="btn-close-confirm text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- CONTENT -->
    <div class="p-8">
      <!-- STATUS BADGE -->
      <div class="mb-6 flex items-center gap-3">
        <div id="confirmStatusBadge" class="inline-block px-4 py-2 rounded-full font-semibold text-sm"></div>
        <span class="text-[#7a5c45] text-sm">ID Peminjaman: <strong id="confirmId"></strong></span>
      </div>

      <!-- KODE PINJAM -->
      <div class="mb-6 p-4 bg-[#faf6ee] rounded-xl border-2 border-green-600">
        <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Kode Peminjaman</p>
        <p id="confirmKodePinjam" class="text-xl font-bold text-green-600 font-mono"></p>
      </div>

      <!-- TWO COLUMN LAYOUT -->
      <div class="grid grid-cols-2 gap-6 mb-6">
        <!-- KOLOM KIRI: DATA PEMINJAM -->
        <div>
          <h3 class="text-lg font-bold text-[#3e2a1f] mb-4 pb-2 border-b-2 border-[#e0d5c7]">
            <svg class="w-5 h-5 text-[#c9a44c] inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Data Peminjam
          </h3>
          
          <div class="space-y-4">
            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Username</p>
              <p id="confirmUsername" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Nama Lengkap</p>
              <p id="confirmNamaLengkap" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Alamat</p>
              <p id="confirmAlamat" class="text-sm font-semibold text-[#3e2a1f] leading-relaxed"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">No. Telepon</p>
              <p id="confirmNoHp" class="text-sm font-semibold text-[#3e2a1f] font-mono">-</p>
            </div>
          </div>
        </div>

        <!-- KOLOM KANAN: DATA BUKU & RINGKASAN -->
        <div>
          <h3 class="text-lg font-bold text-[#3e2a1f] mb-4 pb-2 border-b-2 border-[#e0d5c7]">📖 Data Buku & Ringkasan</h3>
          
          <div class="space-y-4">
            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Judul Buku</p>
              <p id="confirmBuku" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Tanggal Pinjam</p>
              <p id="confirmTglPinjam" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <div>
              <p class="text-xs text-[#7a5c45] uppercase tracking-wider mb-1">Tanggal Dikembalikan</p>
              <p id="confirmTglDikembalikan" class="text-sm font-semibold text-[#3e2a1f]"></p>
            </div>

            <!-- RINGKASAN DENDA & POIN -->
            <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
              <h4 class="text-sm font-bold text-green-800 mb-3">💰 Ringkasan Pengembalian</h4>
              
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-xs text-green-700">Kondisi Buku:</span>
                  <div id="confirmKondisiList" class="flex gap-1"></div>
                </div>
                
                <div class="flex justify-between">
                  <span class="text-xs text-green-700">Total Denda:</span>
                  <span id="confirmDenda" class="text-sm font-bold text-red-600"></span>
                </div>
                
                <div class="flex justify-between">
                  <span class="text-xs text-green-700">Poin (Tambah):</span>
                  <span id="confirmPoin" class="text-sm font-bold text-[#9f1239]"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ACTION BUTTONS -->
      <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
        <button id="cancelSelesaiBtn" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition">
          Batal
        </button>
        <button id="confirmSelesaiBtn" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
          <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Konfirmasi & Setujui
        </button>
      </div>
    </div>
  </div>
</div>

<!-- IMAGE VIEWER MODAL -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 p-4">
  <div class="relative max-w-4xl max-h-full">
    <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition z-10">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
    <img id="imageModalImg" src="" alt="Foto Identitas" class="max-w-full max-h-full object-contain rounded-lg">
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg text-sm">
      Foto Identitas (KTP/KIA/Kartu Pelajar)
    </div>
  </div>
</div>

<script>
