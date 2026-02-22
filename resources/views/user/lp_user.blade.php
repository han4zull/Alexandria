<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Alexandria Digital Library</title>

  @php
    use Illuminate\Support\Str;
  @endphp

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter', sans-serif; }
    .heading { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .font-auth { font-family: 'Poppins', sans-serif; letter-spacing: 0.1em; }

    .logo-spin { animation: spin 12s linear infinite; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

    body {
      background-color: #f4efe4;
      background-image: 
        linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px);
      background-size: 20px 20px;
    }

    /* Wave belakang image */
    .wave-bg {
      filter: blur(40px);
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    /* Line clamp untuk judul buku */
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  </style>
</head>

<body class="text-[#3e2a1f] min-h-screen">

<!-- HEADER WITH LOGO AND AUTH -->
<div class="flex justify-between items-center pr-8 pl-0 py-2">

  <!-- LOGO + NAMA -->
  <div id="logo" class="flex items-center gap-2 bg-[#c9a44c] rounded-r-full px-6 py-2 shadow-md z-50">
    <div class="w-[70px] h-[70px]">
      <svg viewBox="0 0 200 200" class="w-full h-full logo-spin">
        <circle cx="100" cy="100" r="88" stroke="#fff" stroke-width="3" fill="none"/>
        <circle cx="100" cy="100" r="70" stroke="#fff" stroke-width="2" fill="none"/>
        <path d="M70 58 Q100 46 130 58 V142 Q100 154 70 142 Z" fill="none" stroke="#fff" stroke-width="3"/>
        <path d="M70 70 Q66 82 70 94 M70 104 Q66 116 70 128" stroke="#fff" stroke-width="1.5" fill="none"/>
        <path d="M130 70 Q134 82 130 94 M130 104 Q134 116 130 128" stroke="#fff" stroke-width="1.5" fill="none"/>
        <line x1="82" y1="78" x2="118" y2="78" stroke="#fff" stroke-width="2"/>
        <line x1="84" y1="92" x2="116" y2="92" stroke="#fff" stroke-width="1.5"/>
        <line x1="86" y1="106" x2="114" y2="106" stroke="#fff" stroke-width="1.5"/>
        <line x1="88" y1="120" x2="112" y2="120" stroke="#fff" stroke-width="1.2"/>
        <path d="M94 66 Q100 62 106 66" stroke="#fff" stroke-width="1.2" fill="none"/>
      </svg>
    </div>
    <span class="font-auth font-bold text-white text-xl tracking-wide">Alexandria</span>
  </div>

  <!-- AUTH -->
  <div id="auth" class="flex items-center gap-6 z-50 text-sm transform -translate-y-2">
    <a href="{{ route('akun.daftar') }}"
       class="font-auth font-semibold text-[#6b5a4a] hover:text-[#3e2a1f] transition">
       SIGN UP
    </a>

    <a href="{{ route('akun.masuk') }}"
       class="font-auth font-semibold px-4 py-2 rounded-full bg-[#c9a44c] text-white hover:bg-[#b08b33] transition shadow-sm">
       LOG IN
    </a>
  </div>

</div>


<!-- HERO -->
<section class="max-w-7xl mx-auto px-8 py-20">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

    <!-- TEXT -->
    <div class="space-y-6">
      <p class="text-sm uppercase tracking-[0.18em] text-[#6b5a4a]">Mari baca buku dan tingkatkan ilmu</p>
      <h1 class="heading text-4xl lg:text-5xl leading-[1.15]">
        Selamat Datang<br>
        di <span class="text-[#c9a44c]">Alexandria</span><br>
        Digital Library
      </h1>
      <p class="text-[#6b5a4a] max-w-md leading-relaxed text-[15px]">
        Menghidupkan kembali warisan ilmu pengetahuan dunia
        dalam satu perpustakaan digital bernuansa klasik
        dan kebijaksanaan Mesir kuno.
      </p>
      <div class="flex gap-4 pt-3">
        <a href="{{ route('akun.masuk') }}" class="px-7 py-3 rounded-lg text-sm font-semibold tracking-wide bg-[#c9a44c] text-white hover:bg-[#b08b33] transition">Mulai Meminjam</a>
        <a href="#" class="px-7 py-3 rounded-lg text-sm font-semibold tracking-wide border border-[#c9a44c] text-[#c9a44c] hover:bg-[#faf6ee] transition">Jelajahi Koleksi</a>
      </div>
    </div>

    <!-- IMAGE HERO DENGAN WAVE PAS DI BELAKANG -->
    <div class="relative flex justify-center">
      <!-- WAVE / BUBBLE -->
      <svg class="wave-bg w-[500px] h-[500px] -z-10" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="250" cy="250" rx="220" ry="150" fill="#c9a44c" fill-opacity="0.15"/>
        <ellipse cx="250" cy="250" rx="180" ry="120" fill="#c9a44c" fill-opacity="0.1"/>
        <ellipse cx="250" cy="250" rx="140" ry="90" fill="#c9a44c" fill-opacity="0.12"/>
        <ellipse cx="250" cy="250" rx="100" ry="60" fill="#c9a44c" fill-opacity="0.08"/>
      </svg>

      <!-- IMAGE HERO -->
      <img src="https://illustrations.popsy.co/amber/studying.svg"
           alt="Ilustrasi Membaca"
           class="w-[420px] max-w-full relative z-10">
    </div>

  </div>
</section>

<!-- CARA PEMINJAMAN -->
<section class="max-w-7xl mx-auto px-8 py-20">
  <div class="text-center mb-16">
    <h2 class="heading text-3xl lg:text-4xl text-[#3e2a1f] mb-4">Cara Meminjam Buku</h2>
    <p class="text-[#6b5a4a] max-w-2xl mx-auto text-[15px] leading-relaxed">
      Proses peminjaman buku di Alexandria Digital Library sangat mudah dan cepat.
      Ikuti langkah-langkah berikut untuk mulai membaca.
    </p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

    <!-- LANGKAH 1: DAFTAR -->
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50">
      <div class="w-16 h-16 bg-[#c9a44c] rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
        </svg>
      </div>
      <h3 class="font-bold text-xl text-[#3e2a1f] mb-3">1. Daftar Akun</h3>
      <p class="text-[#6b5a4a] text-sm leading-relaxed">
        Buat akun gratis untuk dapat mengakses semua fitur perpustakaan digital kami.
      </p>
    </div>

    <!-- LANGKAH 2: CARI BUKU -->
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50">
      <div class="w-16 h-16 bg-[#c9a44c] rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
      </div>
      <h3 class="font-bold text-xl text-[#3e2a1f] mb-3">2. Cari Buku</h3>
      <p class="text-[#6b5a4a] text-sm leading-relaxed">
        Jelajahi ribuan koleksi buku kami dengan fitur pencarian yang mudah dan cepat.
      </p>
    </div>

    <!-- LANGKAH 3: PINJAM -->
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50">
      <div class="w-16 h-16 bg-[#c9a44c] rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
      </div>
      <h3 class="font-bold text-xl text-[#3e2a1f] mb-3">3. Ajukan Peminjaman</h3>
      <p class="text-[#6b5a4a] text-sm leading-relaxed">
        Klik tombol pinjam dan tunggu konfirmasi dari petugas perpustakaan.
      </p>
    </div>

    <!-- LANGKAH 4: AMBIL BUKU -->
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50">
      <div class="w-16 h-16 bg-[#c9a44c] rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
      </div>
      <h3 class="font-bold text-xl text-[#3e2a1f] mb-3">4. Ambil Buku</h3>
      <p class="text-[#6b5a4a] text-sm leading-relaxed">
        Setelah disetujui, ambil buku di perpustakaan dengan menunjukkan QR code.
      </p>
    </div>

    <!-- LANGKAH 5: BACA -->
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50">
      <div class="w-16 h-16 bg-[#c9a44c] rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
      </div>
      <h3 class="font-bold text-xl text-[#3e2a1f] mb-3">5. Baca & Nikmati</h3>
      <p class="text-[#6b5a4a] text-sm leading-relaxed">
        Baca buku dengan tenang dan tingkatkan pengetahuan Anda.
      </p>
    </div>

    <!-- LANGKAH 6: KEMBALIKAN -->
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50">
      <div class="w-16 h-16 bg-[#c9a44c] rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
      </div>
      <h3 class="font-bold text-xl text-[#3e2a1f] mb-3">6. Kembalikan Tepat Waktu</h3>
      <p class="text-[#6b5a4a] text-sm leading-relaxed">
        Kembalikan buku sesuai tanggal yang ditentukan untuk menghindari denda.
      </p>
    </div>

  </div>

  <!-- CALL TO ACTION -->
  <div class="text-center mt-16">
    <a href="{{ route('akun.masuk') }}" class="inline-block px-8 py-4 bg-[#c9a44c] text-white font-semibold rounded-lg hover:bg-[#b08b33] transition shadow-lg">
      Mulai Meminjam Sekarang →
    </a>
  </div>
</section>

<!-- BUKU POPULER -->
<section class="max-w-7xl mx-auto px-8 py-20">
  <div class="text-center mb-16">
    <h2 class="heading text-3xl lg:text-4xl text-[#3e2a1f] mb-4">Buku Terpopuler</h2>
    <p class="text-[#6b5a4a] max-w-2xl mx-auto text-[15px] leading-relaxed">
      Buku-buku yang paling diminati oleh pembaca kami. Mulai petualangan membaca Anda dengan karya-karya terbaik ini.
    </p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
    @forelse($bukuPopuler ?? [] as $buku)
    <div class="bg-white/70 backdrop-blur-sm rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50 group max-w-xs mx-auto">
      <!-- COVER BUKU -->
      <div class="aspect-[3/4] bg-gray-100 relative overflow-hidden">
        @if($buku->cover)
          <img src="{{ asset('storage/' . $buku->cover) }}"
               alt="{{ $buku->judul }}"
               class="w-full h-full object-cover transition-transform duration-300">
        @else
          <div class="w-full h-full bg-gradient-to-br from-[#c9a44c] to-[#b08b33] flex items-center justify-center">
            <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
        @endif

        <!-- BADGE POPULER -->
        <div class="absolute top-2 right-2 bg-[#c9a44c] text-white text-xs font-semibold px-2 py-0.5 rounded-full">
          Populer
        </div>
      </div>

      <!-- INFO BUKU -->
      <div class="p-3">
        <h3 class="font-bold text-sm text-[#3e2a1f] mb-1 line-clamp-2 leading-tight">
          {{ $buku->judul }}
        </h3>

        <p class="text-[#6b5a4a] text-xs mb-0.5">
          <span class="font-medium">Penulis:</span> {{ $buku->penulis ?? 'Tidak diketahui' }}
        </p>

        <p class="text-[#6b5a4a] text-xs mb-2">
          <span class="font-medium">Tahun:</span> {{ $buku->tahun_terbit ?? 'Tidak diketahui' }}
        </p>

        <!-- TOMBOL LIHAT DETAIL -->
        <a href="{{ route('akun.masuk') }}"
           class="w-full block text-center px-2 py-1.5 bg-[#c9a44c] text-white font-semibold text-xs rounded-md hover:bg-[#b08b33] transition">
          Lihat Detail
        </a>
      </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
      <svg class="w-16 h-16 text-[#6b5a4a] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
      </svg>
      <p class="text-[#6b5a4a] text-lg">Belum ada data buku populer</p>
    </div>
    @endforelse
  </div>
</section>

<!-- ULASAN PENGGUNA -->
<section class="max-w-7xl mx-auto px-8 py-20">
  <div class="text-center mb-16">
    <h2 class="heading text-3xl lg:text-4xl text-[#3e2a1f] mb-4">Apa Kata Pembaca Kami</h2>
    <p class="text-[#6b5a4a] max-w-2xl mx-auto text-[15px] leading-relaxed">
      Dengarkan pengalaman membaca dari sesama pecinta buku di Alexandria Digital Library.
    </p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    @forelse($ulasanTerbaru ?? [] as $ulasan)
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50">
      <!-- HEADER ULASAN -->
      <div class="flex items-center gap-4 mb-4">
        <!-- AVATAR -->
        <div class="w-12 h-12 bg-[#c9a44c] rounded-full flex items-center justify-center">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
        </div>

        <!-- INFO USER -->
        <div class="flex-1">
          <h4 class="font-bold text-[#3e2a1f] text-lg">{{ $ulasan->user->name ?? 'Anonymous' }}</h4>
          <p class="text-[#6b5a4a] text-sm">Review untuk: <span class="font-medium">{{ Str::limit($ulasan->buku->judul, 30) }}</span></p>
        </div>

        <!-- RATING -->
        <div class="flex items-center gap-1">
          @for($i = 1; $i <= 5; $i++)
            <svg class="w-4 h-4 {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
          @endfor
          <span class="text-[#6b5a4a] text-sm ml-1">({{ $ulasan->rating }}/5)</span>
        </div>
      </div>

      <!-- ISI ULASAN -->
      <div class="text-[#3e2a1f] leading-relaxed">
        <p class="text-sm italic mb-2">"{{ Str::limit($ulasan->review ?? $ulasan->ulasan ?? 'Tidak ada review', 150) }}"</p>
      </div>

      <!-- FOOTER -->
      <div class="flex items-center justify-between text-xs text-[#6b5a4a] mt-4 pt-4 border-t border-gray-200">
        <span>{{ $ulasan->created_at->format('d M Y') }}</span>
        <div class="flex items-center gap-1">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
          </svg>
          Review
        </div>
      </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
      <svg class="w-16 h-16 text-[#6b5a4a] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
      </svg>
      <p class="text-[#6b5a4a] text-lg">Belum ada ulasan dari pengguna</p>
    </div>
    @endforelse
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-[#c9a44c] text-white py-12 mt-16">
  <div class="max-w-7xl mx-auto px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

      <!-- TENTANG ALEXANDRIA -->
      <div class="lg:col-span-2">
        <div class="flex items-center gap-2 mb-4">
          <div class="w-[35px] h-[35px]">
            <svg viewBox="0 0 200 200" class="w-full h-full">
              <!-- Eternal Ring -->
              <circle cx="100" cy="100" r="88" stroke="white" stroke-width="1.4" fill="none"/>
              <!-- Inner Ring -->
              <circle cx="100" cy="100" r="70" stroke="#ffffff" stroke-width="0.9" fill="none"/>
              <!-- Papyrus Sheet -->
              <path d="M70 58 Q100 46 130 58 V142 Q100 154 70 142 Z" fill="none" stroke="white" stroke-width="1.6"/>
              <!-- Papyrus Side Tears -->
              <path d="M70 70 Q66 82 70 94 M70 104 Q66 116 70 128" stroke="white" stroke-width="0.8" fill="none"/>
              <path d="M130 70 Q134 82 130 94 M130 104 Q134 116 130 128" stroke="white" stroke-width="0.8" fill="none"/>
              <!-- Ancient Script Lines -->
              <line x1="82" y1="78" x2="118" y2="78" stroke="white" stroke-width="1"/>
              <line x1="84" y1="92" x2="116" y2="92" stroke="white" stroke-width="0.9"/>
              <line x1="86" y1="106" x2="114" y2="106" stroke="white" stroke-width="0.9"/>
              <line x1="88" y1="120" x2="112" y2="120" stroke="white" stroke-width="0.8"/>
              <!-- Margin Glyph -->
              <path d="M94 66 Q100 62 106 66" stroke="white" stroke-width="0.8" fill="none"/>
            </svg>
          </div>
          <span class="font-auth font-bold text-white text-lg tracking-wide">Alexandria</span>
        </div>

        <p class="text-white leading-relaxed mb-4 text-sm max-w-md">
          Alexandria Digital Library menghidupkan kembali warisan ilmu pengetahuan dunia dalam satu perpustakaan digital bernuansa klasik.
        </p>

        <div class="flex gap-3">
          <a href="#" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition text-xs">
            <svg class="w-4 h-4 text-[#c9a44c]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
            </svg>
          </a>
          <a href="#" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition text-xs">
            <svg class="w-4 h-4 text-[#c9a44c]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
            </svg>
          </a>
          <a href="#" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition text-xs">
            <svg class="w-5 h-5 text-[#c9a44c]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- LAYANAN CEPAT -->
      <div>
        <h3 class="font-bold text-base mb-4">Layanan Cepat</h3>
        <ul class="space-y-2 text-white text-sm">
          <li><a href="{{ route('akun.masuk') }}" class="hover:text-white transition">Peminjaman Buku</a></li>
          <li><a href="#" class="hover:text-white transition">Pengembalian Buku</a></li>
          <li><a href="#" class="hover:text-white transition">Riwayat Peminjaman</a></li>
          <li><a href="#" class="hover:text-white transition">Daftar Buku</a></li>
        </ul>
      </div>

      <!-- KONTAK KAMI -->
      <div>
        <h3 class="font-bold text-base mb-4">Kontak Kami</h3>
        <ul class="space-y-3 text-white text-sm">
          <li class="flex items-start gap-2">
            <svg class="w-4 h-4 text-white mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span>Jl. Ilmu Pengetahuan No. 123<br>Jakarta Pusat, DKI Jakarta</span>
          </li>
          <li class="flex items-center gap-2">
            <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            <span>+62 21 1234 5678</span>
          </li>
          <li class="flex items-center gap-2">
            <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <span>info@alexandria-library.id</span>
          </li>
        </ul>
      </div>

    </div>

    <!-- BOTTOM BAR -->
    <div class="border-t border-white/20 mt-8 pt-6">
      <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-white text-xs text-center md:text-left">
          © 2026 Alexandria Digital Library. All rights reserved.
        </p>

        <div class="flex gap-4 text-xs text-white">
          <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
          <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
        </div>
      </div>
    </div>
  </div>
</footer>

</body>
</html>