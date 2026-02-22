<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buku Tersimpan | Alexandria Library</title>
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
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
        </svg>
        Buku Tersimpan
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

    {{-- SAVED BOOKS GRID --}}
    @if($savedBooks->count() > 0)
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($savedBooks as $buku)
          <a href="{{ route('buku.detailbuku', $buku->id) }}" class="group book-card block">
            <div class="relative">
              <div class="absolute inset-0 bg-black/10 rounded-r-lg blur-md transform translate-x-0.5 translate-y-0.5" style="width: 90%; height: 90%;"></div>
              <div class="relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1 h-fit w-4/5">
                {{-- COVER --}}
                <div class="relative aspect-[3/4] bg-[#e8dcc8] overflow-hidden flex items-center justify-center">
                  @if($buku->cover)
                    <img src="{{ asset('storage/'.$buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                  @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#d4c4b0] to-[#c9a44c]">
                      <svg class="w-10 h-10 text-[#8b7355]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H6a1 1 0 110-2V4z"></path>
                      </svg>
                    </div>
                  @endif

                  {{-- REMOVE BUTTON --}}
                  <button type="button" 
                          onclick="event.stopPropagation(); openRemoveModal({{ $buku->id }}, '{{ addslashes($buku->judul) }}');"
                          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity p-2 bg-red-500 text-white rounded-full hover:bg-red-600 shadow-lg z-10">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            {{-- CONTENT --}}
            <div class="mt-3 text-left">
              <h4 class="text-sm font-bold text-[#3e2a1f] line-clamp-2 group-hover:text-[#c9a44c] transition-colors">
                {{ $buku->judul }}
              </h4>
              <p class="text-sm font-bold text-[#6b5a4a] line-clamp-1 mt-1">{{ $buku->penulis ?? '-' }}</p>
            </div>
          </a>
        @endforeach
      </div>

      {{-- PAGINATION --}}
      @if($savedBooks->hasPages())
        <div class="mt-8 flex justify-center">
          {{ $savedBooks->links() }}
        </div>
      @endif
    @else
      {{-- EMPTY STATE --}}
      <div class="flex flex-col items-center justify-center py-16">
        <div class="mb-4">
          <svg class="w-20 h-20 text-[#8b7355]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
          </svg>
        </div>
        <h2 class="judul text-2xl font-bold text-[#3e2a1f] mb-2">Belum Ada Buku Tersimpan</h2>
        <p class="text-[#6b5a4a] mb-6">Simpan buku favoritmu untuk membaca nanti!</p>
        <a href="{{ route('buku_user') }}" class="px-6 py-3 bg-gradient-to-r from-[#b08b33] to-[#8b6f47] text-white font-bold rounded-lg hover:shadow-lg transition-all">
          Jelajahi Koleksi Buku
        </a>
      </div>
    @endif

  </main>
</div>

<!-- Remove Book Confirmation Modal -->
<div id="remove-modal" class="fixed inset-0 hidden items-center justify-center z-50">
    <!-- Background with blur -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Modal Card -->
    <div class="bg-white rounded-3xl p-8 z-10 w-11/12 max-w-md shadow-2xl border border-[#e7dcc8] transform transition-all duration-300 scale-95 opacity-0" id="remove-modal-content">
        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-red-400 to-red-500 flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold text-center text-[#3e2a1f] mb-3 font-['Poppins']">Hapus dari Tersimpan</h3>

        <!-- Message -->
        <p class="text-center text-[#6b5a4a] mb-8 leading-relaxed">
            Apakah Anda yakin ingin menghapus buku <span id="book-title" class="font-semibold text-[#3e2a1f]"></span> dari daftar tersimpan?
        </p>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button id="remove-cancel"
                    class="flex-1 py-3 px-6 rounded-xl border-2 border-[#e7dcc8] text-[#6b5a4a]
                           font-semibold hover:bg-[#faf6ee] hover:border-[#c9a44c] transition-all duration-200
                           transform hover:scale-[1.02] active:scale-[0.98]">
                Batal
            </button>

            <button id="remove-confirm"
                    class="flex-1 py-3 px-6 rounded-xl bg-gradient-to-r from-red-500 to-red-600
                           text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-200
                           transform hover:scale-[1.02] active:scale-[0.98] hover:from-red-600 hover:to-red-700">
                <span class="flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </span>
            </button>
        </div>

        <!-- Decorative element -->
        <div class="mt-6 flex justify-center">
            <div class="w-12 h-1 bg-gradient-to-r from-red-400 to-red-500 rounded-full"></div>
        </div>
    </div>
</div>

<!-- Hidden form for remove action -->
<form id="remove-form" action="" method="POST" class="sr-only">
    @csrf
</form>

<script>
let currentBookId = null;

function openRemoveModal(bookId, bookTitle) {
    currentBookId = bookId;
    document.getElementById('book-title').textContent = bookTitle;
    document.getElementById('remove-form').action = `/buku/save/${bookId}`;

    const modal = document.getElementById('remove-modal');
    const modalContent = document.getElementById('remove-modal-content');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    // Trigger animation
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

document.addEventListener('DOMContentLoaded', function(){
    const modal = document.getElementById('remove-modal');
    const modalContent = document.getElementById('remove-modal-content');
    const cancel = document.getElementById('remove-cancel');
    const confirm = document.getElementById('remove-confirm');
    const form = document.getElementById('remove-form');

    function hideModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        // Wait for animation to complete before hiding
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    cancel && cancel.addEventListener('click', hideModal);
    modal && modal.addEventListener('click', function(e){
        if (e.target === modal) hideModal();
    });

    confirm && confirm.addEventListener('click', function(){
        // Add loading state to confirm button
        confirm.innerHTML = `
            <span class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menghapus...
            </span>
        `;
        confirm.disabled = true;
        form && form.submit();
    });

    // Keyboard support
    document.addEventListener('keydown', function(e) {
        if (modal.classList.contains('flex')) {
            if (e.key === 'Escape') {
                hideModal();
            }
        }
    });
});
</script>
