<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Koleksi Buku | Alexandria Library</title>
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
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

    .kategori-btn.active {
      background-color: #c9a44c !important;
      color: white !important;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
    }
  </style>
</head>

<body class="text-[#3e2a1f]">
<div class="min-h-screen flex gap-6 p-6">

  {{-- SIDEBAR --}}
  @include('user.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    {{-- TOP BAR --}}
    <div class="flex items-center justify-between mb-8">
      <h1 class="judul text-3xl font-black text-[#8b6f47] flex items-center gap-2">
        <svg class="w-6 h-6 text-[#8b6f47]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        Koleksi Buku
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

    {{-- SEARCH BAR --}}
    <div class="flex justify-start mb-8">
      <form method="GET" class="flex items-center gap-3 w-full max-w-md">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku atau penulis..."
               class="w-full px-4 py-3 text-sm bg-white shadow border border-[#e2d3c1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c9a44c]">
        <button type="submit"
                class="px-5 py-3 bg-[#c9a44c] rounded-xl hover:bg-[#b28f45] transition shadow flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <circle cx="11" cy="11" r="7" stroke-width="1.6"/>
            <path stroke-width="1.6" d="M20 20l-3-3"/>
          </svg>
        </button>
      </form>
    </div>

    {{-- KATEGORI --}}
    <div class="mb-4">
      <div id="kategoriContainer" class="flex flex-wrap gap-2 max-h-[40px] overflow-hidden transition-all duration-300">
        <button data-kategori="all"
           class="kategori-btn px-4 py-2 rounded-full text-sm font-bold text-center transition active bg-[#c9a44c] text-white shadow">
          All
        </button>

        @foreach($kategori as $k)
          <button data-kategori="{{ $k->nama_kategori }}" 
             class="kategori-btn px-4 py-2 rounded-full text-sm font-bold text-center transition bg-white text-[#6b5a4a] hover:bg-[#f3e9d7]">
            {{ $k->nama_kategori }}
          </button>
        @endforeach
      </div>
      <button id="toggleKategori"
              class="mt-2 px-4 py-2 rounded-full text-sm font-bold text-center bg-white text-[#6b5a4a] shadow hover:bg-[#f3e9d7] transition">
        Lihat Semua
      </button>
    </div>

    {{-- KOLEKSI BUKU SESUAI KATEGORI --}}
    <div>
      <h2 class="judul text-2xl mb-6 text-[#3e2a1f] flex items-center gap-2">
        <svg class="w-6 h-6 text-[#c9a44c]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        Koleksi Buku
      </h2>

      @if($buku && count($buku) > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
          @foreach($buku as $bukuItem)
          <a href="{{ route('buku.detailbuku', $bukuItem->id) }}" class="group book-card" data-kategori="{{ $bukuItem->kategori->pluck('nama_kategori')->implode(',') }}">
              <div class="relative">
                <div class="absolute inset-0 bg-black/10 rounded-r-lg blur-md transform translate-x-0.5 translate-y-0.5" style="width: 90%; height: 90%;"></div>
                <div class="relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1 h-fit w-4/5">
                  <div class="relative aspect-[3/4] bg-[#e8dcc8] overflow-hidden flex items-center justify-center">
                    @if($bukuItem->cover)
                      <img src="{{ asset('storage/' . $bukuItem->cover) }}" 
                           alt="{{ $bukuItem->judul }}" class="w-full h-full object-cover">
                    @else
                      <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#d4c4b0] to-[#c9a44c]">
                        <svg class="w-10 h-10 text-[#8b7355]" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H6a1 1 0 110-2V4z"></path>
                        </svg>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="mt-3 text-left">
                <h4 class="text-sm font-bold text-[#3e2a1f] line-clamp-2 group-hover:text-[#c9a44c] transition-colors">
                  {{ $bukuItem->judul }}
                </h4>
                <p class="text-sm font-bold text-[#6b5a4a] line-clamp-1 mt-1">{{ $bukuItem->penulis ?? '-' }}</p>
              </div>
            </a>
          @endforeach
        </div>

        <div id="noResultsKategori" class="hidden bg-white rounded-2xl shadow-lg p-12 text-center mt-6">
          <p class="text-[#9a8b7a]">Tidak ada buku dalam kategori ini</p>
        </div>

      @else
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
          <p class="text-[#9a8b7a]">Buku tidak tersedia di kategori ini</p>
        </div>
      @endif
    </div>

  </main>
</div>

<script>
  const toggleBtn = document.getElementById('toggleKategori');
  const kategoriContainer = document.getElementById('kategoriContainer');

  toggleBtn.addEventListener('click', () => {
    if (kategoriContainer.style.maxHeight === 'none') {
      kategoriContainer.style.maxHeight = '40px';
      toggleBtn.textContent = 'Lihat Semua';
    } else {
      kategoriContainer.style.maxHeight = 'none';
      toggleBtn.textContent = 'Sembunyikan';
    }
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const kategoriBtns = document.querySelectorAll('.kategori-btn');
  const bookCards = document.querySelectorAll('.book-card');

  kategoriBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      // Remove active from all
      kategoriBtns.forEach(b => b.classList.remove('active'));

      // Add active to this
      this.classList.add('active');

      const selected = this.dataset.kategori;
      console.log('Selected kategori:', selected);
      let hasVisible = false;

      bookCards.forEach(card => {
        const cardKat = card.dataset.kategori;
        console.log('Card kategori:', cardKat);
        if (selected === 'all' || cardKat.includes(selected)) {
          card.style.display = 'block';
          hasVisible = true;
        } else {
          card.style.display = 'none';
        }
      });

      const noResults = document.getElementById('noResultsKategori');
      if (hasVisible) {
        noResults.classList.add('hidden');
      } else {
        noResults.classList.remove('hidden');
      }
    });
  });
});
</script>

</body>
</html>
