<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Petugas | Alexandria Library</title>

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

    .welcome-banner {
      background:
        linear-gradient(160deg, rgba(255,255,255,.18), rgba(255,255,255,.06)),
        linear-gradient(160deg, #c9a44c, #5a3d2b);
      box-shadow: 0 8px 18px rgba(62,42,31,.18);
      border: 1px solid rgba(255,255,255,.15);
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
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10.5L12 3l9 7.5M5 10v9a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1v-9"/>
    </svg>
    @endsection

    @section('page-title')
    Dashboard
    @endsection

    @include('petugas.layout.header')

    <!-- SEARCH BAR -->
    <div class="flex justify-start mb-8">
      <div class="flex items-center gap-3 w-full max-w-md">
        <input type="text" id="searchInput" placeholder="Cari data peminjaman atau buku..."
               class="w-full px-4 py-3 text-sm bg-white shadow border border-[#e2d3c1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c9a44c]">
        <button id="searchBtn"
                class="px-5 py-3 bg-[#c9a44c] rounded-xl hover:bg-[#b28f45] transition shadow flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <circle cx="11" cy="11" r="7" stroke-width="1.6"/>
            <path stroke-width="1.6" d="M20 20l-3-3"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- WELCOME BANNER -->
    <div class="welcome-banner mb-10 p-10 rounded-3xl text-white shadow-2xl">
      <h1 class="judul text-3xl mb-2">
        Selamat datang,
        {{ auth('petugas')->user()->jenis_kelamin === 'L' ? 'Pak' : 'Bu' }}
        <span class="italic">{{ auth('petugas')->user()->nama ?? 'Petugas' }}</span>
      </h1>
      <p class="text-sm opacity-90 max-w-xl">
        Dashboard Alexandria Library — kelola peminjaman, pengembalian, dan publikasi buku dengan mudah & efisien.
      </p>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">

      <div class="p-6 rounded-2xl bg-white shadow-lg">
        <p class="text-xs text-[#6b5a4a]">Permintaan Peminjaman</p>
        <h3 class="text-3xl font-semibold">{{ $stats['pending'] ?? 0 }}</h3>
        <p class="text-xs text-[#9a8b7a] mt-2">Menunggu konfirmasi</p>
      </div>

      <div class="p-6 rounded-2xl bg-white shadow-lg">
        <p class="text-xs text-[#6b5a4a]">Peminjaman Aktif</p>
        <h3 class="text-3xl font-semibold">{{ $stats['dipinjam'] ?? 0 }}</h3>
        <p class="text-xs text-[#9a8b7a] mt-2">Sedang dipinjam</p>
      </div>

      <div class="p-6 rounded-2xl bg-white shadow-lg">
        <p class="text-xs text-[#6b5a4a]">Permintaan Pengembalian</p>
        <h3 class="text-3xl font-semibold">{{ $stats['proses_kembali'] ?? 0 }}</h3>
        <p class="text-xs text-[#9a8b7a] mt-2">Sedang dikembalikan</p>
      </div>

      <div class="p-6 rounded-2xl bg-white shadow-lg">
        <p class="text-xs text-[#6b5a4a]">Sudah Dikembalikan</p>
        <h3 class="text-3xl font-semibold">{{ $stats['dikembalikan'] ?? 0 }}</h3>
        <p class="text-xs text-[#9a8b7a] mt-2">Selesai dipinjam</p>
      </div>

    </div>

    <!-- RINGKASAN PUBLIKASI & PEMINJAMAN -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <div class="p-6 bg-white rounded-2xl shadow-lg">
        <h4 class="judul text-lg mb-4 flex items-center gap-2">
          <svg class="w-5 h-5 text-[#c9a44c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-6-6h12"/>
          </svg>
          Publikasi Buku
        </h4>
        <ul class="text-sm space-y-2">
          <li>Menunggu: <b>{{ $stats['pending'] ?? 0 }}</b></li>
          <li>Disetujui: <b>{{ $stats['approved'] ?? 0 }}</b></li>
          <li>Ditolak: <b>{{ $stats['rejected'] ?? 0 }}</b></li>
        </ul>
      </div>

      <div class="p-6 bg-white rounded-2xl shadow-lg">
        <h4 class="judul text-lg mb-4 flex items-center gap-2">
          <svg class="w-5 h-5 text-[#c9a44c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          Manajemen Peminjaman
        </h4>
        <ul class="text-sm space-y-2">
          <li>Dipinjam: <b>{{ $stats['dipinjam'] ?? 0 }}</b></li>
          <li>Proses Kembali: <b>{{ $stats['proses_kembali'] ?? 0 }}</b></li>
          <li>Dikembalikan: <b>{{ $stats['dikembalikan'] ?? 0 }}</b></li>
        </ul>
      </div>

      <div class="p-6 bg-white rounded-2xl shadow-lg">
        <h4 class="judul text-lg mb-4 flex items-center gap-2">
          <svg class="w-5 h-5 text-[#c9a44c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          Akun
        </h4>
        <ul class="text-sm space-y-2">
          <li>User Aktif: <b>{{ $stats['user'] ?? 0 }}</b></li>
        </ul>
      </div>

    </div>

  </main>

</div>

<script>
// SEARCH FUNCTIONALITY
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();

    if (searchTerm === '') {
        // Reset all highlights
        document.querySelectorAll('.highlight-search').forEach(el => {
            el.classList.remove('highlight-search');
        });
        return;
    }

    // Simple search functionality for dashboard
    // You can expand this to search through stats or content
    console.log('Searching for:', searchTerm);
});

document.getElementById('searchBtn').addEventListener('click', function() {
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput.value.trim();

    if (searchTerm === '') {
        searchInput.focus();
        return;
    }

    // For now, just show an alert that search is not fully implemented
    alert('Fitur pencarian di dashboard sedang dalam pengembangan. Gunakan menu navigasi untuk mencari data spesifik.');
    searchInput.focus();
});
</script>

</body>
</html>