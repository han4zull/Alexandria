<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Ulasan Saya | Alexandria Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

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
    body { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; font-size:14px; line-height:1.65; color:var(--text); -webkit-font-smoothing:antialiased; }
    .serif { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
    .judul { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; letter-spacing:-0.5px; }

    h1,h2,h3,h4,h5{ font-family: 'Poppins', sans-serif; color:var(--accent); margin:0 0 .4rem 0; }
    p, li, label, input, button, a { font-family: 'Inter', sans-serif; color:var(--text); }
    .glass {
      background: rgba(255,255,255,0.65);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.5);
    }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .tab-active { border-bottom: 3px solid #b08b33; color: #b08b33; font-weight: 600; }
    .tab-inactive { border-bottom: 3px solid transparent; color: #6b5a4a; }

    /* Table content font size like petugas pages */
    .table-content {
      font-size: 0.85rem;
    }

    /* Apply table font size to all content like petugas pages */
    .page-content {
      font-size: 0.85rem;
    }
  </style>
</head>

<body class="text-[#3e2a1f]">
<div class="min-h-screen flex gap-6 p-6">

  {{-- SIDEBAR --}}
  @include('user.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto page-content">

    {{-- TOP BAR --}}
    <div class="flex items-center justify-between mb-8">
      <h1 class="judul text-3xl font-black text-[#8b6f47] flex items-center gap-2">
        <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
        Ulasan Saya
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

    {{-- CONTENT --}}
    @if($reviews->count() > 0)
      <div class="space-y-6">
        @foreach($reviews as $review)
          <div class="bg-white/80 rounded-xl shadow-md border-l-4 border-[#c9a44c] overflow-hidden">
            {{-- CARD CONTENT --}}
            <div class="p-6">
              {{-- BOOK INFO --}}
              <div class="flex flex-col sm:flex-row gap-4 mb-4">
                {{-- BOOK COVER --}}
                <div class="flex-shrink-0">
                  @if($review->buku->cover)
                    <img src="{{ asset('storage/'.$review->buku->cover) }}" alt="{{ $review->buku->judul }}" class="w-16 h-20 object-cover rounded-lg shadow-md">
                  @else
                    <div class="w-16 h-20 flex items-center justify-center bg-gradient-to-br from-[#d4c4b0] to-[#c9a44c] rounded-lg">
                      <svg class="w-8 h-8 text-[#8b7355]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 4.5A1.5 1.5 0 013.5 3h11A1.5 1.5 0 0116 4.5V16a1 1 0 01-1 1H3a1 1 0 01-1-1V4.5zM4 5v10h10V5H4z"/>
                      </svg>
                    </div>
                  @endif
                </div>

                {{-- BOOK DETAILS --}}
                <div class="flex-1 table-content">
                  <h3 class="serif text-lg font-bold text-[#3e2a1f] mb-1">{{ $review->buku->judul }}</h3>
                  <p class="text-sm text-[#8b6f47] font-medium mb-2">{{ $review->buku->penulis ?? 'Penulis tidak diketahui' }}</p>

                  {{-- RATING & DATE --}}
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                      {{-- STARS --}}
                      @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                      @endfor
                      <span class="text-sm text-[#6b5a4a] ml-1">{{ $review->rating }}/5</span>
                    </div>
                    <div class="text-xs text-[#6b5a4a]">
                      {{ $review->created_at->format('d M Y') }}
                    </div>
                  </div>
                </div>
              </div>

              {{-- REVIEW TEXT --}}
              <div class="bg-[#faf4ef] rounded-lg p-4">
                <p class="table-content text-[#3e2a1f] leading-relaxed">{{ $review->ulasan }}</p>
              </div>

              {{-- ACTIONS --}}
              <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('buku.detailbuku', $review->buku->id) }}#ulasan"
                   class="serif inline-flex items-center gap-2 px-3 py-2 rounded-md bg-gradient-to-r from-[#8b6f47] to-[#b08b33] text-white text-sm font-semibold hover:opacity-95 transition">
                  <i class="fa-solid fa-book-open"></i>
                  <span>Lihat Ulasan</span>
                </a>

                <form id="delete-ulasan-form-{{ $review->id }}" action="{{ route('ulasan.destroy', $review->buku->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="button" data-form-id="delete-ulasan-form-{{ $review->id }}" class="open-delete-modal serif inline-flex items-center gap-2 px-3 py-2 rounded-md bg-gradient-to-r from-[#b91c1c] to-[#991b1b] text-white text-sm font-semibold hover:opacity-95 transition">
                    <i class="fa-solid fa-trash"></i>
                    <span>Hapus Ulasan</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="bg-white/70 rounded-xl p-12 text-center shadow-md">
        <div class="mb-4">
          <svg class="w-20 h-20 text-[#8b7355] mx-auto" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
          </svg>
        </div>
        <p class="text-lg text-[#6b5a4a] mb-2">Belum ada ulasan</p>
        <p class="text-sm text-[#8b6f47]">Berikan ulasan untuk buku yang telah Anda pinjam!</p>
        <a href="{{ route('buku_user') }}" class="inline-block mt-4 px-4 py-2 bg-[#c9a44c] text-white rounded hover:bg-[#b08b33] transition">
          Jelajahi Buku
        </a>
      </div>
    @endif

  </main>
</div>

{{-- Delete confirmation modal --}}
<div id="delete-confirm-modal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4 z-50">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden modal-content opacity-0 scale-95 transform transition duration-150">
    <div class="bg-gradient-to-r from-[#b91c1c] to-[#991b1b] px-6 py-5">
      <h3 class="text-lg font-bold text-white flex items-center gap-3">
        <i class="fa-solid fa-triangle-exclamation"></i>
        Konfirmasi Hapus
      </h3>
    </div>

    <div class="p-6 space-y-4">
      <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
        <p class="text-[#3e2a1f] font-semibold mb-1">Yakin ingin menghapus ulasan ini?</p>
        <p class="text-sm text-[#6b5a4a]">Tindakan ini tidak dapat dibatalkan.</p>
      </div>
    </div>

    <div class="bg-[#faf4ef] px-6 py-4 flex gap-3 border-t border-[#e0d5c7]">
      <button id="cancel-delete" class="flex-1 px-4 py-3 rounded-lg border border-[#d9c6a3] text-[#5b4636] font-medium hover:bg-[#fffaf6] transition">Batal</button>
      <button id="confirm-delete" class="flex-1 px-4 py-3 rounded-lg bg-gradient-to-r from-[#b91c1c] to-[#991b1b] text-white font-medium hover:opacity-95 transition">Hapus</button>
    </div>
  </div>
</div>

{{-- SUCCESS/ERROR MESSAGES --}}
@if(session('success'))
  <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('error') }}
  </div>
@endif

<script>
// Auto-hide messages after 3 seconds
setTimeout(() => {
  const messages = document.querySelectorAll('.fixed.top-4.right-4');
  messages.forEach(msg => msg.style.display = 'none');
}, 3000);

// Delete confirmation modal logic with click-outside, Escape, and animation
(function(){
  let selectedFormId = null;
  const modal = document.getElementById('delete-confirm-modal');
  const content = modal ? modal.querySelector('.modal-content') : null;
  const cancelBtn = document.getElementById('cancel-delete');
  const confirmBtn = document.getElementById('confirm-delete');

  function openModal(formId){
    selectedFormId = formId;
    if (!modal || !content) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    requestAnimationFrame(() => {
      content.classList.remove('opacity-0','scale-95');
      content.classList.add('opacity-100','scale-100');
    });
  }

  function closeModal(){
    selectedFormId = null;
    if (!modal || !content) return;
    content.classList.add('opacity-0','scale-95');
    content.classList.remove('opacity-100','scale-100');
    setTimeout(() => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }, 160);
  }

  document.querySelectorAll('.open-delete-modal').forEach(btn => {
    btn.addEventListener('click', function(e){
      openModal(this.getAttribute('data-form-id'));
    });
  });

  if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
  if (confirmBtn) confirmBtn.addEventListener('click', function(){
    if (!selectedFormId) return;
    const form = document.getElementById(selectedFormId);
    if (form) form.submit();
  });

  // click outside to close
  if (modal) modal.addEventListener('click', function(e){
    if (e.target === modal) closeModal();
  });

  // ESC to close
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeModal();
  });
})();
</script>
</body>
</html>