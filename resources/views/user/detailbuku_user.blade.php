<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Buku | Alexandria Library</title>
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
    :root{
      --text: #3e2a1f;
      --muted: #6b5a4a;
      --accent: #8b6f47;
    }
    body { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; font-size:16px; line-height:1.6; color:var(--text); -webkit-font-smoothing:antialiased; }
    .serif { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
    .judul { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; letter-spacing:-0.4px; }

    h1,h2,h3{ font-family: 'Poppins', sans-serif; color:var(--accent); margin:0 0 .4rem 0; }
    p, li, label, input, button, a { font-family: 'Inter', sans-serif; color:var(--text); }
    .card-content { font-size: 0.85rem; }
    /* Ulasan section - match content above */
    #ulasan textarea { font-family: 'Inter', sans-serif; border: 2px solid #c9a44c !important; background-color: #fafaf8; }
    #ulasan textarea:focus { outline: none; border-color: #8b6f47; box-shadow: 0 0 0 3px rgba(201, 164, 76, 0.1); }
    /* Ulasan section */
    #ulasan { border-top: 2px solid #c9a44c; padding-top: 2rem; }
    .glass {
      background: rgba(255,255,255,0.65);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.5);
    }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

    textarea {
  font-family: 'Inter', sans-serif;
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
        Detail Buku
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

    {{-- DETAIL BUKU --}}
    <div class="flex flex-col gap-8">

      {{-- TOP SECTION: COVER + INFO --}}
      <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- COVER & STATUS --}}
        <div class="lg:w-1/3 w-full flex flex-col gap-2.5">
          {{-- BOOK COVER --}}
          <div class="bg-[#e8dcc8] rounded-2xl overflow-hidden shadow-lg" style="max-width: 260px;">
            @if($buku->cover)
              <img src="{{ asset('storage/'.$buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-auto object-cover aspect-[2/3]">
            @else
              <div class="w-full aspect-[2/3] flex items-center justify-center bg-gradient-to-br from-[#d4c4b0] to-[#c9a44c]">
                <svg class="w-16 h-16 text-[#8b7355]" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H6a1 1 0 110-2V4z"></path>
                </svg>
              </div>
            @endif
          </div>
        </div>

        {{-- INFO BUKU --}}
        <div class="lg:w-2/3 w-full flex flex-col gap-2.5 card-content">
        {{-- JUDUL & METADATA --}}
        <div>
          <h2 class="judul text-4xl font-bold text-[#3e2a1f] mb-2">{{ $buku->judul }}</h2>
          <p class="text-lg text-[#8b6f47] font-medium">{{ $buku->penulis ?? 'Penulis tidak diketahui' }}</p>
          <p class="text-sm text-[#6b5a4a] mt-1">{{ $buku->penerbit ?? '-' }} • {{ $buku->tahun_terbit ?? '-' }}</p>
        </div>

        {{-- INFO GRID --}}
        <div class="grid grid-cols-3 gap-3">
          <div class="p-3 bg-white/80 rounded-lg shadow-sm">
            <p class="text-sm text-[#6b5a4a] font-semibold mb-1">PENERBIT</p>
            <p class="text-sm font-medium text-[#3e2a1f]">{{ $buku->penerbit ?? '-' }}</p>
          </div>
          <div class="p-3 bg-white/80 rounded-lg shadow-sm">
            <p class="text-sm text-[#6b5a4a] font-semibold mb-1">TAHUN</p>
            <p class="text-sm font-medium text-[#3e2a1f]">{{ $buku->tahun_terbit ?? '-' }}</p>
          </div>
          <div class="p-3 bg-white/80 rounded-lg shadow-sm">
            <p class="text-sm text-[#6b5a4a] font-semibold mb-1">HALAMAN</p>
            <p class="text-sm font-medium text-[#3e2a1f]">{{ $buku->halaman ?? '-' }}</p>
          </div>
          <div class="p-3 bg-white/80 rounded-lg shadow-sm">
            <p class="text-sm text-[#6b5a4a] font-semibold mb-1">ISBN</p>
            <p class="text-sm font-medium text-[#3e2a1f] break-all">{{ $buku->isbn ?? '-' }}</p>
          </div>
          <div class="p-3 bg-white/80 rounded-lg shadow-sm">
            <p class="text-sm text-[#6b5a4a] font-semibold mb-1">KATEGORI</p>
            <p class="text-sm font-medium text-[#3e2a1f]">{{ $buku->kategori->pluck('nama_kategori')->join(', ') ?: '-' }}</p>
          </div>
          <div class="p-3 bg-white/80 rounded-lg shadow-sm border-l-4 border-[#c9a44c]">
            <p class="text-sm text-[#6b5a4a] font-semibold mb-1">KETERSEDIAAN</p>
            @if($buku->stok > 0)
              <p class="text-base font-bold text-green-600">{{ $buku->stok }} Tersedia</p>
            @else
              <p class="text-base font-bold text-red-600">Habis</p>
            @endif
          </div>
        </div>

        {{-- DESKRIPSI --}}
        <div class="p-4 bg-white/80 rounded-lg shadow-md border-l-4 border-[#d4c4b0]">
          <h3 class="font-bold text-[#3e2a1f] mb-2 text-base flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Deskripsi
          </h3>
          <p class="text-sm text-[#3e2a1f] leading-relaxed">{{ $buku->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}</p>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex flex-col sm:flex-row gap-3 pt-2">
          @if($buku->stok > 0)
            @auth
              <a href="{{ route('buku.pinjam', ['id' => $buku->id]) }}" class="flex-1 px-5 py-3 rounded-lg bg-gradient-to-r from-[#b08b33] to-[#8b6f47] text-white font-bold text-base text-center hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span>Pinjam Buku</span>
              </a>
            @else
              <button id="guestPinjamBtn" class="flex-1 px-5 py-3 rounded-lg bg-gradient-to-r from-[#b08b33] to-[#8b6f47] text-white font-bold text-base text-center hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span>Pinjam Buku</span>
              </button>
            @endauth
          @else
            <div class="flex-1 px-5 py-3 rounded-lg bg-gray-400 text-white font-bold text-base text-center cursor-not-allowed opacity-75 flex items-center justify-center gap-2">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
              </svg>
              <span>Stok Habis</span>
            </div>
          @endif
          
          {{-- SAVE BUTTON --}}
          <form action="{{ route('buku.save', ['id' => $buku->id]) }}" method="POST" class="flex-1">
            @csrf
            @php
              $isSaved = auth()->user()->savedBooks()->where('buku_id', $buku->id)->exists();
            @endphp
            <button type="submit" class="w-full px-5 py-3 rounded-lg font-bold text-base transition-all duration-200 flex items-center justify-center gap-2 {{ $isSaved ? 'bg-yellow-100 text-yellow-700 border-2 border-yellow-400 hover:bg-yellow-200' : 'bg-white/80 text-[#8b6f47] border-2 border-[#c9a44c] hover:bg-[#f9f5f0]' }}">
              <svg class="w-4 h-4 {{ $isSaved ? 'fill-current' : '' }}" fill="{{ $isSaved ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
              <span>{{ $isSaved ? 'Disimpan' : 'Simpan' }}</span>
            </button>
          </form>
          
          <a href="{{ route('buku_user') }}" class="flex-1 px-5 py-3 rounded-lg bg-white/80 text-[#8b6f47] font-bold text-base border-2 border-[#c9a44c] hover:bg-[#f9f5f0] transition-all duration-200 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
          </a>
        </div>

        </div>
        {{-- END INFO BUKU --}}

      </div>
      {{-- END TOP SECTION --}}

      {{-- ULASAN SECTION --}}
      <div id="ulasan" class="mt-8">
        <h3 class="judul text-2xl font-bold text-[#3e2a1f] mb-6 flex items-center gap-2">
          <svg class="w-5 h-5 text-yellow-400 fill-current" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
          </svg>
          Ulasan Pembaca
        </h3>

        @auth
          @php
            $myReviews = \App\Models\UlasanBuku::where('buku_id', $buku->id)->where('user_id', auth()->id())->get();
          @endphp
          
          @if($hasReturnedBook)
            <div class="mb-4 bg-yellow-50 border-2 border-yellow-400 p-4 rounded-lg shadow-sm">
              <p class="text-sm text-yellow-700 font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                Kamu sudah mengembalikan buku ini. Lihat ulasanmu di bawah atau beri ulasan di halaman Riwayat.
              </p>
            </div>
          @endif
        @endauth

        @php
          $reviews = \App\Models\UlasanBuku::where('buku_id', $buku->id)->latest()->get();
        @endphp

        @if($reviews->count() > 0)
          <div class="space-y-4">
            @foreach($reviews as $review)
              <div class="bg-white/70 rounded-lg p-4 shadow-md border-l-4 border-[#c9a44c]">
                <div class="flex items-start justify-between mb-2">
                  <div>
                    <p class="font-semibold text-[#3e2a1f]">{{ $review->user->username ?? 'Anonim' }}</p>
                    <p class="text-xs text-[#6b5a4a]">{{ $review->created_at->format('d M Y') }}</p>
                  </div>
                  <div class="flex gap-1">
                    @for($i = 1; $i <= 5; $i++)
                      <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                      </svg>
                    @endfor
                  </div>
                </div>
                <p class="text-base text-[#3e2a1f] leading-relaxed">{{ $review->ulasan ?? $review->review }}</p>
              </div>
            @endforeach
          </div>
        @else
          <div class="bg-white/70 rounded-lg p-6 text-center shadow-md">
            <p class="text-[#6b5a4a] flex items-center justify-center gap-2">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Belum ada ulasan untuk buku ini. Jadilah yang pertama memberikan ulasan di halaman Riwayat!
            </p>
          </div>
        @endif
      </div>
      {{-- END ULASAN SECTION --}}
    {{-- END DETAIL BUKU --}}

  </main>
</div>

{{-- LOGIN PROMPT MODAL --}}
<div id="loginPromptModal" class="fixed inset-0 bg-black/60 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 mx-4">
    <h3 class="text-lg font-bold mb-2">Silakan Masuk</h3>
    <p class="text-sm text-gray-700 mb-4">Untuk meminjam buku, kamu harus masuk terlebih dahulu.</p>
    <div class="flex gap-3 justify-end">
      <a href="{{ route('akun.masuk') }}" class="px-4 py-2 bg-[#c9a44c] text-white rounded">Masuk</a>
      <a href="{{ route('akun.daftar') }}" class="px-4 py-2 bg-gray-100 rounded">Daftar</a>
      <button id="loginPromptClose" class="px-4 py-2 bg-gray-200 rounded">Batal</button>
    </div>
  </div>
</div>

<script>
  (function(){
    const btn = document.getElementById('guestPinjamBtn');
    const modal = document.getElementById('loginPromptModal');
    const close = document.getElementById('loginPromptClose');
    if(btn){
      btn.addEventListener('click', function(){
        modal.classList.remove('hidden');
      });
    }
    if(close){
      close.addEventListener('click', function(){ modal.classList.add('hidden'); });
    }
    if(modal){
      modal.addEventListener('click', function(e){ if(e.target === modal) modal.classList.add('hidden'); });
    }
  })();

  // Star rating functionality - Global function
  function selectRating(rating) {
    // Update hidden input
    const ratingInput = document.getElementById('rating-input');
    if (ratingInput) {
      ratingInput.value = rating;
    }

    // Update button styles
    document.querySelectorAll('.star-btn').forEach((btn, index) => {
      const btnRating = parseInt(btn.dataset.rating);
      if (btnRating <= rating) {
        btn.classList.add('bg-[#c9a44c]', 'border-[#c9a44c]', 'text-white');
        btn.classList.remove('border-gray-300', 'text-gray-400', 'hover:border-[#c9a44c]', 'hover:text-[#c9a44c]');
      } else {
        btn.classList.remove('bg-[#c9a44c]', 'border-[#c9a44c]', 'text-white');
        btn.classList.add('border-gray-300', 'text-gray-400', 'hover:border-[#c9a44c]', 'hover:text-[#c9a44c]');
      }
    });
  }

  // Initialize rating on page load
  document.addEventListener('DOMContentLoaded', function() {
    const currentRating = document.getElementById('rating-input').value;
    if (currentRating) {
      selectRating(parseInt(currentRating));
    }
  });
</script>
</body>
</html>
