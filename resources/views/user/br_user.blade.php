<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard User | Alexandria Library</title>

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
    .serif { font-family: 'Poppins', sans-serif; }
    .judul { font-family: 'Poppins', sans-serif; }
    .glass {
      background: rgba(255,255,255,0.65);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.5);
    }

    .welcome-banner {
      background:
        linear-gradient(160deg, rgba(255,255,255,.18), rgba(255,255,255,.06)),
        linear-gradient(160deg, #c9a44c, #5a3d2b);
      box-shadow: 0 8px 18px rgba(62,42,31,.18);
      border: 1px solid rgba(255,255,255,.15);
    }
  </style>
</head>

<body class="text-[#3e2a1f]">

<div class="min-h-screen flex gap-6 p-6">

  {{-- SIDEBAR --}}
  @include('user.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    <!-- TOP BAR -->
    <div class="flex items-center justify-between mb-8">
      <h1 class="judul text-3xl font-black text-[#8b6f47] flex items-center gap-2">
        <svg class="w-6 h-6 text-[#8b6f47]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10.5L12 3l9 7.5M5 10v9a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1v-9"/>
        </svg>
        Dashboard
      </h1>

      {{-- PROFILE --}}
      <div class="flex items-center gap-3">
        <div class="text-right">
          <div class="text-xs text-[#6b5a4a]">Hai,</div>
          <div class="text-sm font-semibold">{{ Auth::user()->username ?? Auth::user()->name ?? 'User' }}</div>
        </div>
        @if(Auth::user()->foto_profil)
          <img src="{{ asset('storage/'.Auth::user()->foto_profil) }}" class="w-12 h-12 rounded-full object-cover shadow-lg border-2 border-[#c9a44c]">
        @else
          <div class="w-12 h-12 rounded-full bg-[#b08b33] text-white flex items-center justify-center font-semibold shadow-lg border-2 border-[#c9a44c]">
            {{ strtoupper(substr(Auth::user()->email ?? 'U', 0, 1)) }}
          </div>
        @endif
      </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="flex justify-start mb-8">
      <div class="flex items-center gap-3 w-full max-w-md">
        <input type="text" id="searchInput" placeholder="Cari judul buku atau penulis..."
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
    <div class="welcome-banner mb-10 p-8 rounded-3xl text-white shadow-2xl">
      <h1 class="serif text-2xl mb-2">
        Selamat datang, <span class="italic">{{ Auth::user()->username ?? Auth::user()->name ?? 'User' }}</span>!
      </h1>
      <p class="text-sm opacity-90 max-w-xl mb-6">
        Temukan inspirasi dari koleksi buku terbaik kami. Jelajahi cerita baru, perluas wawasan, dan nikmati pengalaman membaca yang tak terlupakan.
      </p>

      <div class="flex gap-3 flex-wrap">
        <a href="{{ route('buku_user') }}" 
           class="px-5 py-2.5 rounded-full bg-white/95 text-[#8b6f47] font-semibold text-sm hover:bg-white transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <circle cx="11" cy="11" r="7" stroke-width="2"/>
            <path stroke-width="2" d="M20 20l-3-3"/>
          </svg>
          Jelajahi Koleksi
        </a>
        <a href="{{ route('simpan_user') }}" 
           class="px-5 py-2.5 rounded-full bg-white/20 backdrop-blur-sm text-white font-semibold text-sm border border-white/40 hover:bg-white/30 transition-all duration-200 flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
          </svg>
          Koleksi Saya
        </a>
      </div>
    </div>

    <!-- GRID BUKU POPULER -->
    <div>
      <h2 class="serif text-2xl mb-6 text-[#3e2a1f] flex items-center gap-2">
        <svg class="w-6 h-6 text-[#c9a44c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        Buku Populer
      </h2>

      @if($buku && count($buku) > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
          @foreach($buku as $bukuItem)
            @if($bukuItem->is_populer)
            <a href="{{ route('buku.detailbuku', $bukuItem->id) }}" class="group">
              <div class="relative">
                <div class="absolute inset-0 bg-black/10 rounded-r-lg blur-md transform translate-x-0.5 translate-y-0.5" style="width: 90%; height: 90%;"></div>

                <div class="relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1 h-fit w-4/5">
                  <div class="relative aspect-[3/4] bg-[#e8dcc8] overflow-hidden flex items-center justify-center">
                    @if($bukuItem->cover)
                      <img src="{{ asset('storage/' . $bukuItem->cover) }}" 
                           alt="{{ $bukuItem->judul }}" 
                           class="w-full h-full object-cover">
                    @else
                      <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#d4c4b0] to-[#c9a44c]">
                        <svg class="w-10 h-10 text-[#8b7355]" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H6a1 1 0 110-2V4z"></path>
                        </svg>
                      </div>
                    @endif

                    <div class="absolute top-1.5 right-1.5">
                      <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-semibold bg-[#c9a44c] text-white">⭐</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-3 text-left">
                <h4 class="text-xs font-semibold text-[#3e2a1f] line-clamp-2 group-hover:text-[#c9a44c] transition-colors">
                  {{ $bukuItem->judul }}
                </h4>
                <p class="text-xs text-[#6b5a4a] line-clamp-1 mt-1">
                  {{ $bukuItem->pengarang ?? '-' }}
                </p>
              </div>
            </a>
            @endif
          @endforeach
        </div>

        <div id="noResults" class="hidden bg-white rounded-2xl shadow-lg p-12 text-center mt-6">
          <p class="text-[#9a8b7a]">Tidak ada buku yang ditemukan untuk pencarian Anda.</p>
        </div>

      @else
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
          <p class="text-[#9a8b7a]">Belum ada buku populer saat ini</p>
        </div>
      @endif
    </div>

  </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const searchBtn = document.getElementById('searchBtn');
  const bookCards = document.querySelectorAll('.grid > a');
  const noResults = document.getElementById('noResults');

  function filterBooks() {
    const query = searchInput.value.toLowerCase().trim();
    let hasVisible = false;
    
    bookCards.forEach(card => {
      const title = card.querySelector('h4').textContent.toLowerCase();
      const author = card.querySelector('p').textContent.toLowerCase();
      
      if (title.includes(query) || author.includes(query)) {
        card.style.display = 'block';
        hasVisible = true;
      } else {
        card.style.display = 'none';
      }
    });

    if (hasVisible) {
      noResults.classList.add('hidden');
    } else {
      noResults.classList.remove('hidden');
    }
  }

  searchInput.addEventListener('input', filterBooks);
  searchBtn.addEventListener('click', filterBooks);
});
</script>

</body>
</html>
