<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Manajemen Buku (Admin)</title>

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
    }

    .tab-card.active {
      opacity: 1;
      transform: translateY(-6px);
      background:
        linear-gradient(160deg, rgba(255,255,255,.18), rgba(255,255,255,.06)),
        linear-gradient(160deg, #c9a44c, #5a3d2b);
    }

    table th, table td {
      padding: 0.75rem;
      font-size: 0.85rem;
      vertical-align: top;
    }

    table th {
      letter-spacing: 0.5px;
    }

    .table-wrap {
      max-width: none;
    }

    .kategori-badge {
      border-radius: 8px;
    }

    .btn {
      padding: 8px 12px;
      border-radius: 10px;
      font-size: 0.8rem;
      font-weight: 600;
    }
  </style>
</head>

<body class="text-[#3e2a1f]">

<div class="min-h-screen flex gap-6 p-6">
  @include('admin.layout.sidebar')

  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    @section('page-icon')
    <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
    </svg>
    @endsection

    @section('page-title')
    Publikasi Buku
    @endsection

    @include('admin.layout.header')

     <!-- SEARCH + UNDUH + TAMBAH BUKU -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-5 gap-4">

      <!-- INPUT SEARCH -->
      <div class="flex items-center gap-3 w-full md:w-1/2">
        <input type="text" id="searchInput" placeholder="Cari buku..."
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
        <!-- UNDUH LAPORAN -->
        <a id="downloadBtn" href="{{ route('admin.laporan.buku_proses') }}"
           class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
            <path stroke-width="1.6" d="M4 21h16"/>
          </svg>
          Unduh Laporan
        </a>

        <!-- TAMBAH BUKU -->
        <a href="{{ route('admin.buku.tambah') }}"
           class="inline-flex items-center gap-2 px-5 py-3 bg-[#c9a44c] text-white rounded-xl font-medium shadow-lg hover:bg-[#b28f45] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          Tambah Buku
        </a>
      </div>

    </div>

    <!-- TAB CARD STATUS -->
    <div class="grid grid-cols-3 gap-8 mb-8">
      <!-- MENUNGGU -->
      <div onclick="showTab('menunggu')" data-status="menunggu" id="tab-menunggu" class="tab-card active flex justify-between items-center cursor-pointer">
        <div>
          <p class="text-sm opacity-80">Pengajuan</p>
          <h3 class="text-xl font-bold">Menunggu</h3>
          <p class="text-sm">({{ $buku->where('status','menunggu')->count() }} data)</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="1.6" d="M4 6a2 2 0 012-2h12v15a1 1 0 01-1 1H6a2 2 0 01-2-2z"/>
          <path stroke-width="1.6" d="M6 4v14"/>
        </svg>
      </div>

      <!-- DISETUJUI -->
      <div onclick="showTab('disetujui')" data-status="disetujui" id="tab-disetujui" class="tab-card flex justify-between items-center cursor-pointer">
        <div>
          <p class="text-sm opacity-80">Selesai</p>
          <h3 class="text-xl font-bold">Disetujui</h3>
          <p class="text-sm">({{ $buku->where('status','disetujui')->count() }} data)</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <circle cx="12" cy="12" r="9" stroke-width="1.6"/>
          <path stroke-width="1.6" stroke-linecap="round" d="M8.5 12.5l2.5 2.5l4.5-5"/>
        </svg>
      </div>

      <!-- DITOLAK -->
      <div onclick="showTab('ditolak')" data-status="ditolak" id="tab-ditolak" class="tab-card flex justify-between items-center cursor-pointer">
        <div>
          <p class="text-sm opacity-80">Revisi</p>
          <h3 class="text-xl font-bold">Ditolak</h3>
          <p class="text-sm">({{ $buku->where('status','ditolak')->count() }} data)</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="1.6" d="M6 18L18 6"/>
          <path stroke-width="1.6" d="M6 6l12 12"/>
        </svg>
      </div>
    </div>

    <!-- TABEL MENUNGGU -->
    <div id="table-menunggu">
      <div class="table-wrapper bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg">
        <div style="overflow-x: auto;">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-[#e7dcc8] to-[#d9cbbe]">
              <tr>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">ISBN</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Judul Buku</th>
                <th class="px-6 py-3 text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Cover</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @php $no = 1; @endphp
              @foreach($buku->where('status','menunggu') as $b)
              <tr class="hover:bg-[#faf6ee] transition-colors duration-200">
                <td class="px-6 py-3 text-sm font-medium text-[#3e2a1f]">{{ $no++ }}</td>
                <td class="px-6 py-3 text-sm font-medium text-[#3e2a1f]">{{ $b->isbn ?? '-' }}</td>
                <td class="px-6 py-3 text-sm font-medium text-[#3e2a1f]">
                  <div class="max-w-xs">
                    <div class="font-semibold">{{ Str::limit($b->judul ?? '-', 40) }}</div>
                    @if($b->deskripsi)
                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($b->deskripsi, 60) }}</div>
                    @endif
                  </div>
                </td>
                <td class="px-6 py-3 text-center">
                  @if($b->cover)
                    <img src="{{ asset('storage/'.$b->cover) }}"
                         class="w-12 h-16 object-cover rounded-lg shadow-md mx-auto">
                  @else
                    <span class="text-gray-400 text-sm">-</span>
                  @endif
                </td>
                <td class="px-6 py-3">
                  <div class="flex flex-wrap gap-1">
                    @foreach($b->kategori as $k)
                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                      {{ $k->nama_kategori }}
                    </span>
                    @endforeach
                  </div>
                </td>
                <td class="px-6 py-3 text-center relative">
                  <!-- SETUJUI BUTTON -->
                  <button type="button" 
                          class="btn-approve btn-approve-{{ $b->id }} block mb-2 inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-semibold rounded-lg shadow-lg hover:shadow-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 ease-in-out border-2 border-green-500 hover:border-green-600 cursor-pointer"
                          style="pointer-events: auto !important;"
                          data-book-id="{{ $b->id }}" 
                          data-book-title="{{ $b->judul ?? 'Buku' }}"
                          onclick="window.showApproveConfirmModal(this.dataset.bookId, this.dataset.bookTitle)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Setujui
                  </button>
                  
                  <!-- TOLAK BUTTON -->
                  <button type="button" 
                          class="btn-reject btn-reject-{{ $b->id }} block mb-2 inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold rounded-lg shadow-lg hover:shadow-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 ease-in-out border-2 border-red-500 hover:border-red-600 cursor-pointer"
                          style="pointer-events: auto !important;"
                          data-book-id="{{ $b->id }}" 
                          data-book-title="{{ $b->judul ?? 'Buku' }}"
                          onclick="window.showRejectReasonModal(this.dataset.bookId, this.dataset.bookTitle)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tolak
                  </button>

                  <!-- TOLAK FORM (HIDDEN) -->

                  <button onclick='openModal(@json($b))'
                          class="btn-detail block mb-2 inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-[#c9a44c] to-[#b28f45] text-white text-xs font-semibold rounded-lg shadow-lg hover:shadow-xl hover:from-[#b28f45] hover:to-[#a07a3d] transition-all duration-300 ease-in-out border-2 border-[#c9a44c] hover:border-[#b28f45] cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Lihat
                  </button>

                  <a href="{{ route('admin.buku.edit',$b->id) }}"
                     class="btn-edit block mb-2 inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-xs font-semibold rounded-lg shadow-lg hover:shadow-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 ease-in-out border-2 border-yellow-500 hover:border-yellow-600 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- TABEL DISETUJUI -->
    <div id="table-disetujui" class="hidden">
      <div class="table-wrapper bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg">
        <div style="overflow-x: auto;">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-[#e7dcc8] to-[#d9cbbe]">
              <tr>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">ISBN</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Judul Buku</th>
                <th class="px-6 py-3 text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Cover</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @php $no = 1; @endphp
              @foreach($buku->where('status','disetujui') as $b)
              <tr class="hover:bg-[#faf6ee] transition-colors duration-200">
                <td class="px-6 py-3 text-sm font-medium text-[#3e2a1f]">{{ $no++ }}</td>
                <td class="px-6 py-3 text-sm font-medium text-[#3e2a1f]">{{ $b->isbn ?? '-' }}</td>
                <td class="px-6 py-3 text-sm font-medium text-[#3e2a1f]">
                  <div class="max-w-xs">
                    <div class="font-semibold">{{ Str::limit($b->judul ?? '-', 40) }}</div>
                    @if($b->deskripsi)
                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($b->deskripsi, 60) }}</div>
                    @endif
                  </div>
                </td>
                <td class="px-6 py-3 text-center">
                  @if($b->cover)
                    <img src="{{ asset('storage/'.$b->cover) }}"
                         class="w-12 h-16 object-cover rounded-lg shadow-md mx-auto">
                  @else
                    <span class="text-gray-400 text-sm">-</span>
                  @endif
                </td>
                <td class="px-6 py-3">
                  <div class="flex flex-wrap gap-1">
                    @foreach($b->kategori as $k)
                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                      {{ $k->nama_kategori }}
                    </span>
                    @endforeach
                  </div>
                </td>
                <td class="px-6 py-3 text-center space-x-2">
                  <button onclick='openModal(@json($b))'
                          class="btn-detail inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-[#c9a44c] to-[#b28f45] text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-[#b28f45] hover:to-[#a07a3d] transition-all duration-300 ease-in-out border-2 border-[#c9a44c] hover:border-[#b28f45] cursor-pointer backface-visibility-hidden">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Lihat
                  </button>

                  <a href="{{ route('admin.buku.edit',$b->id) }}"
                     class="btn-edit inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 ease-in-out border-2 border-yellow-500 hover:border-yellow-600 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                  </a>

                  <form action="{{ route('admin.buku.destroy', $b->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="btn-delete inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-red-600 hover:to-red-700 transition-all duration-300 ease-in-out border-2 border-red-500 hover:border-red-600 cursor-pointer backface-visibility-hidden"
                            data-id="{{ $b->id }}"
                            data-judul="{{ $b->judul }}"
                            onclick="confirmDelete(this)">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- TABEL DITOLAK -->
    <div id="table-ditolak" class="hidden">
      <div class="table-wrapper bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg">
        <div style="overflow-x: auto;">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-[#e7dcc8] to-[#d9cbbe]">
              <tr>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">ISBN</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Judul Buku</th>
                <th class="px-6 py-3 text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Cover</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Alasan Tolak</th>
                <th class="px-6 py-3 text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @php $no = 1; @endphp
              @foreach($buku->where('status','ditolak') as $b)
              <tr class="hover:bg-[#faf6ee] transition-colors duration-200">
                <td class="px-6 py-3 text-sm font-medium text-[#3e2a1f]">{{ $no++ }}</td>
                <td class="px-6 py-3 text-sm font-medium text-[#3e2a1f]">{{ $b->isbn ?? '-' }}</td>
                <td class="px-6 py-3 text-sm font-medium text-[#3e2a1f]">
                  <div class="max-w-xs">
                    <div class="font-semibold">{{ Str::limit($b->judul ?? '-', 40) }}</div>
                    @if($b->deskripsi)
                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($b->deskripsi, 60) }}</div>
                    @endif
                  </div>
                </td>
                <td class="px-6 py-3 text-center">
                  @if($b->cover)
                    <img src="{{ asset('storage/'.$b->cover) }}"
                         class="w-12 h-16 object-cover rounded-lg shadow-md mx-auto">
                  @else
                    <span class="text-gray-400 text-sm">-</span>
                  @endif
                </td>
                <td class="px-6 py-3">
                  <div class="flex flex-wrap gap-1">
                    @foreach($b->kategori as $k)
                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                      {{ $k->nama_kategori }}
                    </span>
                    @endforeach
                  </div>
                </td>
                <td class="px-6 py-3 text-sm text-[#3e2a1f]">
                  <div class="max-w-xs">
                    {{ Str::limit($b->alasan_tolak ?? '-', 50) }}
                    @if($b->alasan_tolak && strlen($b->alasan_tolak) > 50)
                      <span class="text-xs text-gray-500">(klik Lihat untuk detail)</span>
                    @endif
                  </div>
                </td>
                <td class="px-6 py-3 text-center space-x-2">
                  <button onclick='openModal(@json($b))'
                          class="btn-detail inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-[#c9a44c] to-[#b28f45] text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-[#b28f45] hover:to-[#a07a3d] transition-all duration-300 ease-in-out border-2 border-[#c9a44c] hover:border-[#b28f45] cursor-pointer backface-visibility-hidden">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Lihat
                  </button>

                  <form action="{{ route('admin.buku.destroy', $b->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="btn-delete inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-red-600 hover:to-red-700 transition-all duration-300 ease-in-out border-2 border-red-500 hover:border-red-600 cursor-pointer backface-visibility-hidden"
                            data-id="{{ $b->id }}"
                            data-judul="{{ $b->judul }}"
                            onclick="confirmDelete(this)">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </main>
</div>
</div>

<!-- MODAL PREMIUM -->
<div id="detailModal"
     class="fixed inset-0 flex items-center justify-center h-screen bg-black/50 backdrop-blur-sm hidden z-50 transition-opacity duration-300">

  <div id="modalCard"
       class="bg-gradient-to-tr from-[#fff8f0] to-[#f4ece2] rounded-3xl w-full max-w-3xl p-8 relative shadow-2xl ring-1 ring-[#d1bfa0] transform scale-90 opacity-0 transition-all duration-300">

    <!-- CLOSE BUTTON -->
    <button onclick="closeModal()"
      class="absolute top-5 right-5 text-gray-500 hover:text-gray-700 text-2xl font-bold transition">×</button>

    <!-- HEADER -->
    <h3 class="judul text-3xl font-bold mb-4 text-[#5a3d2b] flex items-center gap-3">
      <i class="fa-solid fa-book-open text-[#c9a44c] text-2xl"></i>
      Detail Buku
    </h3>
    <hr class="border-t-2 border-[#e2c9a0] mb-6">

    <!-- CONTENT GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

      <!-- COVER -->
      <div class="col-span-1 flex justify-center md:justify-start relative">
        <div class="relative w-48 h-64 rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-transform duration-300">
          <img id="modalCover" class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
        </div>
      </div>

      <!-- DETAILS -->
      <div class="col-span-2 text-sm space-y-3 p-4 bg-white/20 rounded-xl backdrop-blur-sm shadow-inner">
        <p><span class="font-semibold text-[#5a3d2b]">Judul:</span> <span id="modalJudul" class="text-[#3e2a1f]"></span></p>
        <p><span class="font-semibold text-[#5a3d2b]">ISBN:</span> <span id="modalIsbn" class="text-[#3e2a1f]"></span></p>
        <p><span class="font-semibold text-[#5a3d2b]">Penulis:</span> <span id="modalPenulis" class="text-[#3e2a1f]"></span></p>
        <p><span class="font-semibold text-[#5a3d2b]">Penerbit:</span> <span id="modalPenerbit" class="text-[#3e2a1f]"></span></p>
        <p><span class="font-semibold text-[#5a3d2b]">Tahun:</span> <span id="modalTahun" class="text-[#3e2a1f]"></span></p>
        <p><span class="font-semibold text-[#5a3d2b]">Stok:</span> <span id="modalStok" class="text-[#3e2a1f]"></span></p>
        <p><span class="font-semibold text-[#5a3d2b]">Alasan Tolak:</span> <span id="modalAlasan" class="text-[#3e2a1f]"></span></p>
      </div>
    </div>

    <!-- DESKRIPSI -->
    <div class="mt-6 text-sm text-[#3e2a1f]">
      <p class="font-semibold text-[#5a3d2b] mb-2">Deskripsi:</p>
      <p id="modalDeskripsi" class="leading-relaxed text-justify"></p>
    </div>

    <!-- BUTTONS -->
    <div class="mt-6 flex justify-end gap-3">
      <button onclick="closeModal()"
              class="px-6 py-2.5 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-lg transition">
        <i class="fa-solid fa-arrow-left"></i> Tutup
      </button>
      <!-- HANYA GANTI $b->id DENGAN # -->
  <a href="#" id="editLink"
     class="px-6 py-2.5 rounded-lg bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white shadow-lg hover:scale-[1.03] transition-transform">
    <i class="fa-solid fa-pen"></i> Edit
  </a>
    </div>
  </div>
</div>

<!-- MODAL DELETE (GLOBAL, BUKAN DI DALAM MODAL DETAIL) -->
<div id="deleteModal"
  class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden z-50 transition-opacity duration-300">

  <div id="deleteCard"
    class="bg-gradient-to-tr from-[#fff8f0] to-[#f4ece2] rounded-3xl w-full max-w-md p-6 relative shadow-2xl ring-1 ring-[#d1bfa0] transform scale-90 opacity-0 transition-all duration-300">

    <button onclick="closeDeleteModal()"
      class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">×</button>

    <div class="flex justify-center mb-4">
      <svg class="w-16 h-16 text-red-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </div>

    <h3 class="text-2xl font-bold text-center text-[#5a3d2b] mb-2">
      Hapus Buku
    </h3>

    <p class="text-center text-[#7a5c45] mb-4">
      Buku ini akan dihapus permanen
    </p>

    <p id="deleteBookTitle"
      class="text-center font-semibold text-[#3e2a1f] mb-6"></p>

    <div class="flex justify-center gap-4">
      <button onclick="closeDeleteModal()"
        class="px-6 py-2.5 rounded-lg bg-[#e2d3c1] hover:bg-[#d1bfa0]">
        Batal
      </button>

      <form id="deleteForm" method="POST">
  @csrf
  @method('DELETE')

  <button type="button"
          onclick="submitDelete()"
          class="px-6 py-2.5 rounded-lg bg-red-600 text-white hover:bg-red-700">
    Ya, Hapus
  </button>
</form>
</div>

 
@if(session('success'))
<div id="successModal"
  class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-[999]">

  <div id="successCard"
    class="bg-gradient-to-tr from-[#fff8f0] to-[#f4ece2]
           rounded-3xl w-full max-w-md p-8
           shadow-2xl ring-1 ring-[#d1bfa0]
           transform scale-90 opacity-0 transition-all duration-300">

    <!-- ICON CEKLIS -->
    <div class="flex justify-center mb-5">
      <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center animate-bounce">
        <svg class="w-10 h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                d="M5 13l4 4L19 7"/>
        </svg>
      </div>
    </div>

    <!-- ICON -->
<div class="flex justify-center mb-6">
  <div class="w-20 h-20 rounded-full bg-green-50 ring-2 ring-green-500
              flex items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-10 h-10 text-green-600"
         fill="none" viewBox="0 0 24 24"
         stroke="currentColor">
      <path stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="3"
            d="M9 12l2 2 4-4"/>
    </svg>
  </div>
</div>

<h3 class="text-2xl font-semibold text-center text-[#4b3621] mb-2">
  Berhasil
</h3>


    <p id="successMessage" class="text-center text-[#7a5c45] mb-6">
      {{ session('success') }}
    </p>

    <div class="flex justify-center">
      <button onclick="closeSuccessModal()"
        class="px-8 py-2.5 rounded-xl
               bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f]
               text-white shadow-lg hover:scale-105 transition">
        Oke
      </button>
    </div>

  </div>
</div>
@endif

<!-- MODAL KONFIRMASI SETUJUI -->
<div id="approveConfirmModal"
     class="fixed inset-0 flex items-center justify-center h-screen bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none z-[9999] transition-opacity duration-300"
     style="display: none;">

  <div id="approveConfirmCard"
       class="bg-gradient-to-tr from-[#fff8f0] to-[#f4ece2] rounded-3xl w-full max-w-md p-6 relative shadow-2xl ring-1 ring-[#d1bfa0] transform scale-90 opacity-0 transition-all duration-300"
       onclick="event.stopPropagation()">

    <button onclick="window.closeApproveConfirmModal()"
      class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">×</button>

    <!-- ICON -->
    <div class="flex justify-center mb-4">
      <div class="w-16 h-16 rounded-full bg-green-50 ring-2 ring-green-500
                  flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-8 h-8 text-green-600"
             fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
          <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                d="M9 12l2 2 4-4"/>
        </svg>
      </div>
    </div>

    <h3 class="text-xl font-bold text-center text-[#5a3d2b] mb-2">
      Setujui Buku
    </h3>

    <p class="text-center text-[#7a5c45] mb-6">
      Apakah Anda yakin ingin menyetujui buku <strong id="approveBookTitle"></strong>?
    </p>

    <div class="flex justify-center gap-4">
      <button onclick="window.closeApproveConfirmModal()"
        class="px-6 py-2.5 rounded-lg bg-[#e2d3c1] hover:bg-[#d1bfa0] transition">
        Batal
      </button>

      <form id="approveForm" method="POST">
        @csrf
        <button type="button" onclick="submitApprove()"
                class="px-6 py-2.5 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
          Ya, Setujui
        </button>
      </form>
    </div>
  </div>
</div>



 </div>
</div>




<script>
const baseUrl = '{{ url("/") }}';

function escapeHtml(unsafe) {
  return String(unsafe)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function openModal(b) {
  const deleteModal = document.getElementById('deleteModal');
  if (!deleteModal.classList.contains('hidden')) {
    const deleteCard = document.getElementById('deleteCard');
    deleteCard.classList.add('scale-90', 'opacity-0');
    setTimeout(() => deleteModal.classList.add('hidden'), 300);
  }

  const modal = document.getElementById('detailModal');
  const card = document.getElementById('modalCard');

  modal.classList.remove('hidden');
  setTimeout(() => {
    card.classList.remove('scale-90', 'opacity-0');
    card.classList.add('scale-100', 'opacity-100');
  }, 10);

  document.getElementById('modalJudul').innerText = b.judul || '-';
  document.getElementById('modalIsbn').innerText = b.isbn || '-';
  document.getElementById('modalPenulis').innerText = b.penulis || '-';
  document.getElementById('modalPenerbit').innerText = b.penerbit || '-';
  document.getElementById('modalTahun').innerText = b.tahun_terbit || '-';
  document.getElementById('modalStok').innerText = b.stok || '-';

  const alasanFull = b.alasan_tolak || '-';
  document.getElementById('modalAlasan').innerHTML =
    alasanFull === '-' ? '-' : escapeHtml(alasanFull).replace(/\n/g, '<br>');

  document.getElementById('modalDeskripsi').innerText = b.deskripsi || '-';
  document.getElementById('modalCover').src =
    b.cover ? `/storage/${b.cover}` : 'https://via.placeholder.com/150x200?text=No+Cover';

  document.getElementById('editLink').href = `/admin/buku/${b.id}/edit`;
  document.getElementById('deleteBookTitle').innerText = b.judul;
  document.getElementById('deleteForm').action = `/admin/buku/${b.id}`;
}

function openDeleteModal(id, judul) {
  const detailModal = document.getElementById('detailModal');
  if (!detailModal.classList.contains('hidden')) {
    const detailCard = document.getElementById('modalCard');
    detailCard.classList.add('scale-90', 'opacity-0');
    setTimeout(() => detailModal.classList.add('hidden'), 300);
  }

  const modal = document.getElementById('deleteModal');
  const card = document.getElementById('deleteCard');
  const form = document.getElementById('deleteForm');

  document.getElementById('deleteBookTitle').innerText = judul;
  form.action = `/admin/buku/hapus/${id}`;

  modal.classList.remove('hidden');
  setTimeout(() => {
    card.classList.remove('scale-90', 'opacity-0');
    card.classList.add('scale-100', 'opacity-100');
  }, 10);
}

function closeModal() {
  const modal = document.getElementById('detailModal');
  const card = document.getElementById('modalCard');
  card.classList.add('scale-90', 'opacity-0');
  setTimeout(() => modal.classList.add('hidden'), 300);
}

function closeDeleteModal() {
  const modal = document.getElementById('deleteModal');
  const card = document.getElementById('deleteCard');
  card.classList.add('scale-90', 'opacity-0');
  setTimeout(() => modal.classList.add('hidden'), 300);
}

function confirmDelete(button) {
  const id = button.getAttribute('data-id');
  const judul = button.getAttribute('data-judul');
  openDeleteModal(id, judul);
}

document.addEventListener('DOMContentLoaded', () => {

  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      openDeleteModal(btn.dataset.id, btn.dataset.judul);
    });
  });

  showTab('menunggu');
});

function submitDelete() {
  const form = document.getElementById('deleteForm');

  fetch(form.action, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: new FormData(form)
  })
  .then(response => {
    if (!response.ok) throw new Error('Gagal hapus');
    return response.json();
  })
  .then(data => {
    if (data.success) {
      closeDeleteModal();
      alert(data.message);
      window.location.reload();
    }
  })
  .catch(err => {
    alert('Gagal menghapus buku');
    console.error(err);
  });
}

function toggleStatus(id) {
  document.querySelectorAll('[id^="statusBox-"]').forEach(el => {
    if (el.id !== `statusBox-${id}`) el.classList.add('hidden');
  });
  document.getElementById(`statusBox-${id}`).classList.toggle('hidden');
}

function toggleTolak(id) {
  const box = document.getElementById(`tolakBox-${id}`);
  const hidden = box.classList.toggle('hidden');
  box.style.pointerEvents = hidden ? 'none' : 'auto';
}

/* =======================
   REJECT REASON MODAL
======================= */

window.showRejectReasonModal = function(bookId, bookTitle) {
  console.log('showRejectReasonModal called with:', bookId, bookTitle);

  // Create overlay
  const overlay = document.createElement('div');
  overlay.id = 'rejectOverlay';
  overlay.style.position = 'fixed';
  overlay.style.top = '0';
  overlay.style.left = '0';
  overlay.style.width = '100%';
  overlay.style.height = '100%';
  overlay.style.background = 'rgba(0,0,0,0.5)';
  overlay.style.display = 'flex';
  overlay.style.alignItems = 'center';
  overlay.style.justifyContent = 'center';
  overlay.style.zIndex = '2147483646';

  // Create card
  const card = document.createElement('div');
  card.id = 'rejectCard';
  card.style.background = 'white';
  card.style.borderRadius = '16px';
  card.style.maxWidth = '400px';
  card.style.width = '90%';
  card.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
  card.style.padding = '24px';
  card.style.zIndex = '2147483647';
  card.innerHTML = `
    <div style="text-align: center;">
      <!-- ICON -->
      <div style="width: 64px; height: 64px; border-radius: 50%; background: #fef2f2; border: 2px solid #ef4444; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
        <svg style="width: 32px; height: 32px; color: #dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </div>

      <!-- TITLE -->
      <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 8px; color: #111827;">Tolak Buku</h3>
      <p style="color: #6b7280; font-size: 14px; margin-bottom: 16px;">Pilih alasan penolakan dan konfirmasi.</p>

      <!-- INFO -->
      <div style="background: #f9fafb; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
        <div style="font-size: 14px; display: flex; justify-content: space-between; margin-bottom: 12px;">
          <span style="color: #6b7280;">Judul Buku:</span>
          <span style="font-weight: 500; color: #111827;">${bookTitle}</span>
        </div>
        <div style="margin-bottom: 8px;">
          <label style="font-size: 14px; color: #6b7280; display: block; margin-bottom: 4px;">Alasan Penolakan:</label>
          <select id="rejectReasonSelect" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #111827;">
            <option value="">-- Pilih Alasan --</option>
            <option value="Data tidak lengkap">Data tidak lengkap</option>
            <option value="ISBN sudah terdaftar">ISBN sudah terdaftar</option>
            <option value="Judul buku tidak sesuai kategori">Judul buku tidak sesuai kategori</option>
            <option value="Cover buku tidak jelas">Cover buku tidak jelas</option>
            <option value="Konten buku tidak sesuai standar">Konten buku tidak sesuai standar</option>
          </select>
        </div>
      </div>

      <!-- BUTTONS -->
      <div style="display: flex; gap: 12px; justify-content: center;">
        <button onclick="closeRejectModal()" style="padding: 10px 24px; border-radius: 8px; background: #e5e7eb; border: none; cursor: pointer; font-weight: 600; color: #374151; transition: background-color 0.2s;">Batal</button>
        <button onclick="submitReject(${bookId})" style="padding: 10px 24px; border-radius: 8px; background: linear-gradient(to right, #dc2626, #b91c1c); border: none; cursor: pointer; font-weight: 600; color: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.2s;">
          <svg style="width: 16px; height: 16px; display: inline; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
          Tolak
        </button>
      </div>
    </div>
  `;

  overlay.appendChild(card);
  document.body.appendChild(overlay);

  // Add click outside to close
  overlay.addEventListener('click', function(e) {
    if (e.target === overlay) {
      closeRejectModal();
    }
  });

  console.log('Reject modal created and appended');
};

window.closeRejectReasonModal = function() {
  const overlay = document.getElementById('rejectOverlay');
  if (overlay) overlay.remove();
};

function closeRejectModal() {
  window.closeRejectReasonModal();
}

function submitReject(bookId) {
  const select = document.getElementById('rejectReasonSelect');
  const selectedReason = select.value;

  if (!selectedReason) {
    alert('Silakan pilih alasan penolakan terlebih dahulu.');
    return;
  }

  // Create hidden form and submit
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = `/admin/buku/${bookId}/tolak`;

  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const csrfInput = document.createElement('input');
  csrfInput.type = 'hidden';
  csrfInput.name = '_token';
  csrfInput.value = csrfToken;
  form.appendChild(csrfInput);

  const reasonInput = document.createElement('input');
  reasonInput.type = 'hidden';
  reasonInput.name = 'alasan_tolak';
  reasonInput.value = selectedReason;
  form.appendChild(reasonInput);

  document.body.appendChild(form);
  form.submit();
}

/* =======================
   TAB SYSTEM
======================= */

function showTab(tab) {
  ['menunggu','disetujui','ditolak'].forEach(t => {
    document.getElementById(`table-${t}`).classList.add('hidden');
    document.getElementById(`tab-${t}`).classList.remove('active');
  });

  document.getElementById(`table-${tab}`).classList.remove('hidden');
  document.getElementById(`tab-${tab}`).classList.add('active');

  updateDownloadLink(tab);
}

function updateDownloadLink(tab) {
  const btn = document.getElementById('downloadBtn');

  if (tab === 'menunggu')
    btn.href = '{{ route("admin.laporan.buku_proses") }}';
  else if (tab === 'disetujui')
    btn.href = '{{ route("admin.laporan.buku_disetujui") }}';
  else
    btn.href = '{{ route("admin.laporan.buku_ditolak") }}';
}

/* =======================
   APPROVE CONFIRM
======================= */

window.showApproveConfirmModal = function(bookId, bookTitle) {
  console.log('showApproveConfirmModal called with:', bookId, bookTitle);

  // Create overlay
  const overlay = document.createElement('div');
  overlay.id = 'approveOverlay';
  overlay.style.position = 'fixed';
  overlay.style.top = '0';
  overlay.style.left = '0';
  overlay.style.width = '100%';
  overlay.style.height = '100%';
  overlay.style.background = 'rgba(0,0,0,0.5)';
  overlay.style.display = 'flex';
  overlay.style.alignItems = 'center';
  overlay.style.justifyContent = 'center';
  overlay.style.zIndex = '2147483646';

  // Create card
  const card = document.createElement('div');
  card.id = 'approveCard';
  card.style.background = 'white';
  card.style.borderRadius = '16px';
  card.style.maxWidth = '400px';
  card.style.width = '90%';
  card.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
  card.style.padding = '24px';
  card.style.zIndex = '2147483647';
  card.innerHTML = `
    <div style="text-align: center;">
      <!-- ICON -->
      <div style="width: 64px; height: 64px; border-radius: 50%; background: #f0fdf4; border: 2px solid #22c55e; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
        <svg style="width: 32px; height: 32px; color: #16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4"/>
        </svg>
      </div>

      <!-- TITLE -->
      <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 8px; color: #111827;">Setujui Buku</h3>
      <p style="color: #6b7280; font-size: 14px; margin-bottom: 16px;">Apakah Anda yakin ingin menyetujui buku ini?</p>

      <!-- INFO -->
      <div style="background: #f9fafb; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        <div style="font-size: 14px; display: flex; justify-content: space-between; margin-bottom: 8px;">
          <span style="color: #6b7280;">Judul Buku:</span>
          <span style="font-weight: 500; color: #111827;">${bookTitle}</span>
        </div>
      </div>

      <!-- BUTTONS -->
      <div style="display: flex; gap: 12px; justify-content: center;">
        <button onclick="closeApproveModal()" style="padding: 10px 24px; border-radius: 8px; background: #e5e7eb; border: none; cursor: pointer; font-weight: 600; color: #374151; transition: background-color 0.2s;">Batal</button>
        <button onclick="submitApprove()" style="padding: 10px 24px; border-radius: 8px; background: linear-gradient(to right, #16a34a, #15803d); border: none; cursor: pointer; font-weight: 600; color: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.2s;">
          <svg style="width: 16px; height: 16px; display: inline; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Setujui
        </button>
      </div>
    </div>
  `;

  overlay.appendChild(card);
  document.body.appendChild(overlay);

  // Set form action
  document.getElementById('approveForm').action = `/admin/buku/${bookId}/setujui`;

  // Add click outside to close
  overlay.addEventListener('click', function(e) {
    if (e.target === overlay) {
      closeApproveModal();
    }
  });

  console.log('Modal created and appended');
};

window.closeApproveConfirmModal = function() {
  const overlay = document.getElementById('approveOverlay');
  if (overlay) overlay.remove();
};

function closeApproveModal() {
  window.closeApproveConfirmModal();
}

function submitApprove() {
  document.getElementById('approveForm').submit();
}


</script>
</body>
</html>
