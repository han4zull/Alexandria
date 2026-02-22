<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page - Alexandria Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f4efe4; }
    .judul { font-family: 'Poppins', sans-serif; font-weight: 700; letter-spacing: 0.02em; }
  </style>
</head>
<body class="text-[#3e2a1f]">

<!-- NAVBAR -->
<nav class="bg-white shadow-md py-4 px-6">
  <div class="max-w-7xl mx-auto flex justify-between items-center">
    <div class="flex items-center gap-3">
      <svg viewBox="0 0 200 200" class="w-10 h-10">
        <circle cx="100" cy="100" r="88" stroke="#c9a44c" stroke-width="1.4" fill="none"/>
        <path d="M70 58 Q100 46 130 58 V142 Q100 154 70 142 Z" fill="none" stroke="#c9a44c" stroke-width="1.6"/>
      </svg>
      <span class="judul text-2xl text-[#c9a44c]">Alexandria</span>
    </div>
    <div class="flex gap-4">
      @auth('web')
        <a href="{{ route('br_user') }}" class="px-4 py-2 bg-[#c9a44c] text-white rounded-lg hover:bg-[#8a6a3f]">Beranda</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-4 py-2 text-red-600 hover:text-red-800">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
      @else
        <a href="{{ route('akun.masuk') }}" class="px-4 py-2 text-[#c9a44c] hover:text-[#8a6a3f]">Masuk</a>
        <a href="{{ route('akun.daftar') }}" class="px-4 py-2 bg-[#c9a44c] text-white rounded-lg hover:bg-[#8a6a3f]">Daftar</a>
      @endauth
    </div>
  </div>
</nav>

<!-- HERO SECTION -->
<section class="bg-gradient-to-br from-[#faf6ee] to-[#f4efe4] py-20 px-6">
  <div class="max-w-7xl mx-auto text-center">
    <h1 class="judul text-5xl md:text-6xl mb-4">Selamat Datang di Alexandria</h1>
    <p class="text-lg text-[#7a5c45] mb-8">Perpustakaan Digital Terpercaya — Jelajahi Dunia Melalui Buku</p>
    
    @auth('web')
      <a href="{{ route('br_user') }}" class="inline-block px-8 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-semibold hover:scale-105 transition">
        Lanjutkan ke Beranda
      </a>
    @else
      <a href="{{ route('akun.daftar') }}" class="inline-block px-8 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-semibold hover:scale-105 transition">
        Mulai Sekarang
      </a>
    @endauth
  </div>
</section>

<!-- FEATURES SECTION -->
<section class="py-16 px-6">
  <div class="max-w-7xl mx-auto">
    <h2 class="judul text-4xl text-center mb-12">Mengapa Memilih Alexandria?</h2>
    
    <div class="grid md:grid-cols-3 gap-8">
      <!-- Feature 1 -->
      <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
        <div class="w-16 h-16 bg-[#e7dcc8] rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-[#c9a44c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 6v12m-6-6h12"/>
          </svg>
        </div>
        <h3 class="judul text-xl mb-2">Koleksi Lengkap</h3>
        <p class="text-[#7a5c45]">Ribuan buku dari berbagai kategori siap untuk Anda jelajahi.</p>
      </div>

      <!-- Feature 2 -->
      <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
        <div class="w-16 h-16 bg-[#e7dcc8] rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-[#c9a44c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h3 class="judul text-xl mb-2">Mudah Digunakan</h3>
        <p class="text-[#7a5c45]">Interface yang intuitif membuat pencarian dan peminjaman buku menjadi sangat mudah.</p>
      </div>

      <!-- Feature 3 -->
      <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
        <div class="w-16 h-16 bg-[#e7dcc8] rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-[#c9a44c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h3 class="judul text-xl mb-2">Terpercaya & Aman</h3>
        <p class="text-[#7a5c45]">Data Anda aman dengan sistem keamanan terkini dan enkripsi tingkat tinggi.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA SECTION -->
<section class="bg-[#faf6ee] py-16 px-6">
  <div class="max-w-4xl mx-auto text-center">
    <h2 class="judul text-4xl mb-4">Siap Membaca?</h2>
    <p class="text-[#7a5c45] text-lg mb-8">Bergabunglah dengan ribuan pembaca yang telah menemukan buku impian mereka di Alexandria.</p>
    
    @auth('web')
      <a href="{{ route('buku_user') }}" class="inline-block px-8 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-semibold hover:scale-105 transition">
        Jelajahi Koleksi Buku
      </a>
    @else
      <a href="{{ route('akun.daftar') }}" class="inline-block px-8 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-semibold hover:scale-105 transition">
        Daftar Sekarang
      </a>
    @endauth
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-[#3e2a1f] text-white py-8 px-6">
  <div class="max-w-7xl mx-auto text-center">
    <p>&copy; 2026 Alexandria Library. Semua hak cipta dilindungi.</p>
  </div>
</footer>

</body>
</html>
