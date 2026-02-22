<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Riwayat Peminjaman | Alexandria Library</title>
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
    body { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; font-size:16px; line-height:1.65; color:var(--text); -webkit-font-smoothing:antialiased; }
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
        <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Riwayat Peminjaman
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

    {{-- CONTENT --}}
    @php
      $query = auth()->user()->peminjaman()->with('buku');
      
      if (request('search')) {
        $query->whereHas('buku', function($q) {
          $q->where('judul', 'like', '%'.request('search').'%');
        });
      }

      $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->get();
    @endphp

    @if($peminjaman->count() > 0)
      <div class="space-y-6">
        @foreach($peminjaman as $item)
          <div class="bg-white/80 rounded-xl shadow-md border-l-4 border-[#c9a44c] overflow-hidden relative">
            {{-- STATUS BADGE - TOP RIGHT CORNER --}}
            <div class="absolute top-4 right-4 z-10">
              @php
                $statusLower = strtolower($item->status ?? '');
              @endphp
              @if($statusLower === 'menunggu konfirmasi' || str_contains($statusLower, 'menunggu konfirmasi'))
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 9H9V5h2v6z"/></svg>
                  Menunggu Konfirmasi Peminjaman
                </span>
              @elseif($statusLower === 'ditolak' || $statusLower === 'batal' || $statusLower === 'expired' || $statusLower === 'cancelled' || str_contains($statusLower, 'tolak') || str_contains($statusLower, 'batal'))
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                  Ditolak
                </span>
              @elseif($statusLower === 'dipinjam')
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 4.5A1.5 1.5 0 013.5 3h11A1.5 1.5 0 0116 4.5V16a1 1 0 01-1 1H3a1 1 0 01-1-1V4.5zM4 5v10h10V5H4z"/></svg>
                  Dipinjam
                </span>
              @elseif($statusLower === 'proses pengembalian' || str_contains($statusLower, 'pengembalian'))
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4v6h2V5h8v10H8v-5H6v6a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H6a2 2 0 00-2 2z"/></svg>
                  Menunggu Konfirmasi Pengembalian
                </span>
              @else
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                  Selesai
                </span>
              @endif
            </div>

            {{-- CARD CONTENT --}}
            <div class="p-6">
              {{-- MAIN LAYOUT --}}
              <div class="flex flex-col sm:flex-row gap-6">
                {{-- BOOK COVER --}}
                <div class="flex-shrink-0">
                          @if($item->buku->cover)
                              <img src="{{ asset('storage/'.$item->buku->cover) }}" alt="{{ $item->buku->judul }}" class="w-24 h-32 object-cover rounded-lg shadow-md">
                            @else
                              <div class="w-24 h-32 flex items-center justify-center bg-gradient-to-br from-[#d4c4b0] to-[#c9a44c] rounded-lg">
                                <svg class="w-10 h-10 text-[#8b7355]" fill="currentColor" viewBox="0 0 20 20">
                                  <path d="M2 4.5A1.5 1.5 0 013.5 3h11A1.5 1.5 0 0116 4.5V16a1 1 0 01-1 1H3a1 1 0 01-1-1V4.5zM4 5v10h10V5H4z" />
                                </svg>
                              </div>
                            @endif
                </div>

                {{-- BOOK & BORROW INFO --}}
                <div class="flex-1">
                  <h3 class="serif text-xl font-bold text-[#3e2a1f] mb-1">{{ $item->buku->judul }}</h3>
                  <p class="text-sm text-[#8b6f47] font-medium mb-4">{{ $item->buku->penulis ?? 'Penulis tidak diketahui' }}</p>

                  {{-- BORROW DETAILS --}}
                  <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-sm">
                    <div>
                      <p class="text-xs text-[#6b5a4a] font-semibold uppercase">Tgl Pinjam</p>
                      <p class="font-medium text-[#3e2a1f]">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</p>
                    </div>
                    <div>
                      <p class="text-xs text-[#6b5a4a] font-semibold uppercase">Tgl Kembali</p>
                      <p class="font-medium text-[#3e2a1f]">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</p>
                    </div>
                    <div>
                      <p class="text-xs text-[#6b5a4a] font-semibold uppercase">Durasi</p>
                      <p class="font-medium text-[#3e2a1f]">{{ $item->durasi }} Hari</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

              <div class="border-t border-[#e0d5c7] bg-[#faf4ef] px-6 py-4 grid grid-cols-2 gap-3 items-center">
{{-- Bukti Peminjaman --}}
                @php
                  $s = strtolower($item->status ?? '');
                @endphp

                {{-- Left: Bukti (always active) --}}
                <button type="button" onclick="openBuktiModal({{ $item->id }}, '{{ $item->kode_pinjam }}', '#{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}', '{{ $item->status }}', '{{ $item->created_at->format('d M Y H:i') }}', '{{ $item->buku->judul }}', '{{ $item->buku->penulis ?? 'Penulis tidak diketahui' }}', '{{ $item->nama_lengkap }}', '{{ $item->alamat }}', '{{ $item->nomer_hp }}', '{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}', '{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}')" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-[#8b6f47] text-white text-sm font-semibold shadow transition duration-150 hover:shadow-lg hover:bg-[#7a5c3b]">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  <span>Bukti</span>
                </button>

                {{-- Right: depends on status --}}
                @if($s === 'menunggu konfirmasi' || $s === 'menunggu' || str_contains($s, 'menunggu konfirmasi'))
                  <button type="button" disabled class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-gray-200 text-gray-500 text-sm font-semibold shadow cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Menunggu Konfirmasi Peminjaman</span>
                  </button>
                @elseif($s === 'ditolak' || $s === 'batal' || $s === 'expired' || $s === 'cancelled' || str_contains($s, 'tolak') || str_contains($s, 'batal'))
                  <button type="button" disabled class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-gray-200 text-gray-500 text-sm font-semibold shadow cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728m0-12.728l12.728 12.728"/>
                      <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                    <span>Peminjaman Ditolak</span>
                  </button>
                @elseif($s === 'dipinjam')
                  <button type="button" onclick="openKembaliModal({{ $item->id }}, '{{ $item->buku->judul }}')" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-[#c9a44c] text-white text-sm font-semibold shadow transition duration-150 hover:shadow-lg hover:bg-[#b08b33]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Kembalikan</span>
                  </button>
                @elseif($s === 'proses pengembalian' || str_contains($s, 'pengembalian'))
                  <button type="button" disabled class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-gray-200 text-gray-500 text-sm font-semibold shadow cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Menunggu Konfirmasi Pengembalian</span>
                  </button>
                @else
                  @php
                    // Cek ulasan berdasarkan peminjaman_id (baru) atau buku_id (lama)
                    $hasReviewed = \App\Models\UlasanBuku::where('user_id', auth()->id())
                        ->where(function($q) use ($item) {
                            $q->where('peminjaman_id', $item->id)
                              ->orWhere(function($subQ) use ($item) {
                                  $subQ->where('buku_id', $item->buku->id)
                                       ->whereNull('peminjaman_id');
                              });
                        })
                        ->exists();
                  @endphp
                  @if($hasReviewed)
                    <button type="button" disabled class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-gray-200 text-gray-500 text-sm font-semibold cursor-not-allowed">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                      <span>Sudah Diulas</span>
                    </button>
                  @else
                    <button type="button" onclick="openUlasanModal({{ $item->id }}, {{ $item->buku->id }}, '{{ addslashes($item->buku->judul) }}')" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-yellow-100 text-[#8b6f47] text-sm font-semibold shadow-sm hover:bg-yellow-200 transition duration-150">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                      <span>Ulasan</span>
                    </button>
                  @endif
                @endif
              </div>knp
          </div>
        @endforeach
      </div>
    @else
      <div class="bg-white/70 rounded-xl p-12 text-center shadow-md">
        <div class="mb-4">
          <svg class="w-20 h-20 text-[#8b7355] mx-auto" fill="currentColor" viewBox="0 0 20 20"><path d="M2 4.5A1.5 1.5 0 013.5 3h11A1.5 1.5 0 0116 4.5V16a1 1 0 01-1 1H3a1 1 0 01-1-1V4.5zM4 5v10h10V5H4z"/></svg>
        </div>
        <p class="text-lg text-[#6b5a4a] mb-2">Belum ada riwayat peminjaman</p>
        <p class="text-sm text-[#8b6f47]">Mulai pinjam buku sekarang!</p>
      </div>
    @endif

  </main>
</div>

{{-- MODAL BUKTI PEMINJAMAN --}}
<div id="buktiModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4 z-50">
  <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden max-h-[90vh] overflow-y-auto">
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-[#8b6f47] to-[#b08b33] px-8 py-8 sticky top-0 z-10">
      <h2 class="text-3xl font-bold text-white">Bukti Peminjaman</h2>
      <p class="text-white/80 text-sm mt-2">Alexandria Library</p>
    </div>

    {{-- CONTENT --}}
    <div class="p-8 space-y-8">
      {{-- KODE PEMINJAMAN --}}
      <div class="text-center bg-[#faf4ef] rounded-xl p-6 border-2 border-[#b08b33]">
        <p class="text-xs tracking-widest font-semibold text-[#8b6f47] uppercase mb-3">Kode Peminjaman</p>
        <p class="font-mono font-bold text-4xl text-[#b08b33] tracking-wide" id="modal-kode"></p>
      </div>

      {{-- DIVIDER --}}
      <div class="h-px bg-[#e0d5c7]"></div>

      {{-- DATA PEMINJAM --}}
      <div class="space-y-4">
        <h3 class="font-semibold text-[#8b6f47] text-sm uppercase tracking-wide">Data Peminjam</h3>
        <div class="grid grid-cols-2 gap-4">
          <div class="flex justify-between pb-3 border-b border-[#e0d5c7]">
            <span class="text-xs font-semibold text-[#8b6f47] uppercase">Status</span>
            <span class="font-semibold text-sm" id="modal-status"></span>
          </div>
          <div class="flex justify-between pb-3 border-b border-[#e0d5c7] col-span-2">
            <span class="text-xs font-semibold text-[#8b6f47] uppercase">Nama</span>
            <span class="text-sm font-medium text-[#3e2a1f]" id="modal-nama"></span>
          </div>
          <div class="flex justify-between pb-3 border-b border-[#e0d5c7] col-span-2">
            <span class="text-xs font-semibold text-[#8b6f47] uppercase">Alamat</span>
            <span class="text-sm font-medium text-[#3e2a1f] text-right" id="modal-alamat"></span>
          </div>
          <div class="flex justify-between pb-3 border-b border-[#e0d5c7] col-span-2">
            <span class="text-xs font-semibold text-[#8b6f47] uppercase">No. HP</span>
            <span class="font-mono text-sm font-bold text-[#3e2a1f]" id="modal-hp"></span>
          </div>
        </div>
      </div>

      {{-- DIVIDER --}}
      <div class="h-px bg-[#e0d5c7]"></div>

      {{-- DATA BUKU --}}
      <div class="space-y-4">
        <h3 class="font-semibold text-[#8b6f47] text-sm uppercase tracking-wide">Data Buku</h3>
        <div class="space-y-3">
          <div class="flex justify-between pb-3 border-b border-[#e0d5c7]">
            <span class="text-xs font-semibold text-[#8b6f47] uppercase">Judul</span>
            <span class="text-sm font-medium text-[#3e2a1f] text-right" id="modal-judul"></span>
          </div>
          <div class="flex justify-between pb-3 border-b border-[#e0d5c7]">
            <span class="text-xs font-semibold text-[#8b6f47] uppercase">Penulis</span>
            <span class="text-sm font-medium text-[#3e2a1f] text-right" id="modal-penulis"></span>
          </div>
        </div>
      </div>

      {{-- DIVIDER --}}
      <div class="h-px bg-[#e0d5c7]"></div>

      {{-- JADWAL PEMINJAMAN --}}
      <div class="space-y-4">
        <h3 class="font-semibold text-[#8b6f47] text-sm uppercase tracking-wide">Jadwal Peminjaman</h3>
        <div class="grid grid-cols-2 gap-4">
          <div class="flex justify-between pb-3 border-b border-[#e0d5c7]">
            <span class="text-xs font-semibold text-[#8b6f47] uppercase">Tanggal Pinjam</span>
            <span class="text-sm font-medium text-[#3e2a1f]" id="modal-tanggal-pinjam"></span>
          </div>
          <div class="flex justify-between pb-3 border-b border-[#e0d5c7]">
            <span class="text-xs font-semibold text-[#8b6f47] uppercase">Tanggal Kembali</span>
            <span class="text-sm font-medium text-[#3e2a1f]" id="modal-tanggal-kembali"></span>
          </div>
        </div>
      </div>

      {{-- NOTE --}}
      <div class="bg-white rounded-lg p-4 border border-[#e9dac6]">
          <p class="text-xs text-[#6b5a4a] leading-relaxed">Simpan bukti ini untuk referensi. Tunjukkan saat mengambil atau mengembalikan buku di perpustakaan.</p>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="bg-[#faf4ef] px-8 py-6 flex gap-3 border-t border-[#e0d5c7] sticky bottom-0">
      <button onclick="closeBuktiModal()" class="flex-1 px-4 py-3 rounded-lg border border-[#d9c6a3] text-[#5b4636] font-medium hover:bg-[#fffaf6] transition">
        Tutup
      </button>
      <button onclick="printBukti()" class="flex-1 px-4 py-3 rounded-lg bg-gradient-to-r from-[#8b6f47] to-[#b08b33] text-white font-medium hover:opacity-95 transition">
        <i class="fa-solid fa-print mr-2"></i> Cetak
      </button>
    </div>
  </div>
</div>

{{-- MODAL KONFIRMASI PENGEMBALIAN --}}
<div id="kembaliModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4 z-50">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-[#b91c1c] to-[#991b1b] px-8 py-8">
      <h2 class="text-2xl font-bold text-white flex items-center gap-3">
        <i class="fa-solid fa-triangle-exclamation"></i>
        Konfirmasi Pengembalian
      </h2>
    </div>

    {{-- CONTENT --}}
    <div class="p-8 space-y-6">
      <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
        <p class="text-[#3e2a1f] font-semibold mb-2">Apakah Anda yakin ingin mengembalikan buku ini?</p>
        <p class="text-sm text-[#6b5a4a]">Buku: <span id="kembali-judul" class="font-semibold"></span></p>
      </div>

      <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
        <p class="text-sm text-[#3e2a1f]">
          <i class="fa-solid fa-info-circle text-blue-600 mr-2"></i>
          Setelah dikonfirmasi, buku akan masuk ke status <strong>Proses Pengembalian</strong> dan Anda perlu membawanya ke perpustakaan untuk konfirmasi akhir.
        </p>
      </div>
    </div>

    {{-- FOOTER --}}
    <div class="bg-[#faf4ef] px-8 py-6 flex gap-3 border-t border-[#e0d5c7]">
      <button onclick="closeKembaliModal()" class="flex-1 px-4 py-3 rounded-lg border border-[#d9c6a3] text-[#5b4636] font-medium hover:bg-[#fffaf6] transition">
        Batal
      </button>
      <button onclick="submitKembali()" class="flex-1 px-4 py-3 rounded-lg bg-gradient-to-r from-[#b91c1c] to-[#991b1b] text-white font-medium hover:opacity-95 transition">
        <i class="fa-solid fa-check mr-2"></i> Kembalikan
      </button>
    </div>
  </div>
</div>

{{-- MODAL ULASAN --}}
<div id="ulasanModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4 z-50">
  <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg mx-4">
    <div class="p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-[#3e2a1f] flex items-center gap-2">
          <svg class="w-5 h-5 text-yellow-400 fill-current" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
          </svg>
          Beri Ulasan
        </h3>
        <button onclick="closeUlasanModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="mb-4">
        <p class="text-sm text-[#6b5a4a] font-medium">Buku:</p>
        <p class="text-base font-semibold text-[#3e2a1f]" id="ulasan-judul"></p>
      </div>
      <form id="ulasanForm" method="POST">
        @csrf
        <div id="ulasan-error" class="hidden text-sm text-red-600 mb-3"></div>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-semibold text-[#3e2a1f] mb-2">Nilai</label>
            <div class="flex gap-1">
              @for($r = 1; $r <= 5; $r++)
                <button type="button" 
                        class="ulasan-star w-10 h-10 rounded-full border-2 flex items-center justify-center transition-all duration-200 cursor-pointer border-gray-300 text-gray-400 hover:border-[#c9a44c] hover:text-[#c9a44c]" 
                        data-rating="{{ $r }}"
                        onclick="selectUlasanRating({{ $r }})">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                  </svg>
                </button>
              @endfor
            </div>
            <input type="hidden" name="rating" id="ulasan-rating-input">
          </div>

          <div>
            <label class="block text-sm font-semibold text-[#3e2a1f] mb-2">Ulasan</label>
            <textarea name="review" rows="4" class="w-full rounded-lg border-2 border-gray-300 p-3 text-sm focus:border-[#c9a44c] focus:outline-none" placeholder="Tulis ulasan minimal 10 karakter..."></textarea>
          </div>
        </div>

        <div class="flex gap-3 mt-6">
          <button type="button" onclick="closeUlasanModal()" class="flex-1 px-4 py-3 rounded-lg border border-[#d9c6a3] text-[#5b4636] font-medium hover:bg-[#fffaf6] transition">
            Batal
          </button>
          <button type="submit" class="flex-1 px-4 py-3 rounded-lg bg-gradient-to-r from-[#b08b33] to-[#8b6f47] text-white font-medium hover:opacity-95 transition">
            Kirim Ulasan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Store current kembali modal data
  let kembaliModalData = {};

  function openKembaliModal(id, judulBuku) {
    kembaliModalData = { id, judulBuku };
    document.getElementById('kembali-judul').textContent = judulBuku;
    
    const modal = document.getElementById('kembaliModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeKembaliModal() {
    const modal = document.getElementById('kembaliModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    kembaliModalData = {};
  }

  function submitKembali() {
    if (!kembaliModalData.id) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/peminjaman/' + kembaliModalData.id + '/kembalikan';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = '_token';
      input.value = csrfToken.getAttribute('content');
      form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
  }

  // Close modal when clicking outside
  document.getElementById('kembaliModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
      closeKembaliModal();
    }
  });

  // Close with ESC key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeKembaliModal();
    }
  });
</script>

<script>
  function openBuktiModal(id, kode, idPad, status, createdAt, judul, penulis, nama, alamat, hp, tanggalPinjam, tanggalKembali) {
    const modal = document.getElementById('buktiModal');
    document.getElementById('modal-kode').textContent = kode;
    document.getElementById('modal-judul').textContent = judul;
    document.getElementById('modal-penulis').textContent = penulis;
    document.getElementById('modal-nama').textContent = nama;
    document.getElementById('modal-alamat').textContent = alamat;
    document.getElementById('modal-hp').textContent = hp;

    // Tanggal pinjam / kembali (already formatted server-side)
    document.getElementById('modal-tanggal-pinjam').textContent = tanggalPinjam || '-';
    document.getElementById('modal-tanggal-kembali').textContent = tanggalKembali || '-';

    // For the bukti modal we only show approved/rejected status as 'Disetujui' or 'Ditolak'.
    // Treat several status values as approved (dipinjam/selesai/proses pengembalian/true/1)
    const s = String(status).toLowerCase();
    const approvedValues = ['dipinjam','selesai','proses pengembalian','true','1','approved'];
    const rejectedValues = ['ditolak','false','0','rejected'];
    let display = '';
    if (approvedValues.includes(s)) {
      display = 'Disetujui';
    } else if (rejectedValues.includes(s)) {
      display = 'Ditolak';
    } else {
      // fallback: show capitalized original status (replace hyphens/underscores)
      display = s.replace(/[-_]/g, ' ');
      display = display.charAt(0).toUpperCase() + display.slice(1);
    }
    document.getElementById('modal-status').textContent = display;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeBuktiModal() {
    const modal = document.getElementById('buktiModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function openUlasanModal(peminjamanId, bukuId, judulBuku) {
    // Set modal content
    document.getElementById('ulasan-judul').textContent = judulBuku;
    
    // Set form action with peminjaman_id
    const form = document.getElementById('ulasanForm');
    form.action = '/buku/' + bukuId + '/review/' + peminjamanId;
    
    // Reset form
    form.reset();
    document.getElementById('ulasan-rating-input').value = '';
    document.querySelectorAll('.ulasan-star').forEach(btn => {
      btn.classList.remove('bg-[#c9a44c]', 'border-[#c9a44c]', 'text-white');
      btn.classList.add('border-gray-300', 'text-gray-400');
    });
    
    // Show modal
    const modal = document.getElementById('ulasanModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeUlasanModal() {
    const modal = document.getElementById('ulasanModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function selectUlasanRating(rating) {
    // Update hidden input
    const ratingInput = document.getElementById('ulasan-rating-input');
    if (ratingInput) {
      ratingInput.value = rating;
    }

    // Update button styles
    document.querySelectorAll('.ulasan-star').forEach((btn, index) => {
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

  // Client-side validation for ulasan form
  document.getElementById('ulasanForm')?.addEventListener('submit', function(e) {
    const ratingInput = document.getElementById('ulasan-rating-input');
    const reviewTextarea = this.querySelector('textarea[name="review"]');
    const errBox = document.getElementById('ulasan-error');

    let errors = [];
    if (!ratingInput || !ratingInput.value) {
      errors.push('Silakan pilih rating (1–5).');
    }
    if (!reviewTextarea || reviewTextarea.value.trim().length < 10) {
      errors.push('Ulasan minimal 10 karakter.');
    }

    if (errors.length > 0) {
      e.preventDefault();
      if (errBox) {
        errBox.innerHTML = errors.join('<br>');
        errBox.classList.remove('hidden');
      } else {
        alert(errors.join('\n'));
      }
      return false;
    }

    // hide error box if validation passed
    if (errBox) { errBox.classList.add('hidden'); errBox.innerHTML = ''; }
  });

  function printBukti() {
    const kode = document.getElementById('modal-kode').textContent;
    const status = document.getElementById('modal-status').innerText;
    const judul = document.getElementById('modal-judul').textContent;
    const nama = document.getElementById('modal-nama').textContent;
    const alamat = document.getElementById('modal-alamat').textContent;
    const hp = document.getElementById('modal-hp').textContent;
    
    const printContent = `
      <!DOCTYPE html>
      <html lang="id">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bukti Peminjaman - Alexandria Library</title>
        <style>
          * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
          }
          
          body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: white;
            padding: 40px 20px;
          }
          
          .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
          }
          
          .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #b08b33;
          }
          
          .header-title {
            font-size: 28px;
            font-weight: 700;
            color: #8b6f47;
            margin-bottom: 5px;
            letter-spacing: 1px;
          }
          
          .header-subtitle {
            font-size: 13px;
            color: #8b6f47;
            opacity: 0.8;
          }
          
          .kode-section {
            text-align: center;
            margin: 30px 0;
            padding: 25px;
            background: #faf4ef;
            border: 2px dashed #b08b33;
            border-radius: 8px;
          }
          
          .kode-label {
            font-size: 11px;
            font-weight: 600;
            color: #8b6f47;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
          }
          
          .kode-value {
            font-size: 36px;
            font-weight: 700;
            color: #b08b33;
            font-family: 'Courier New', monospace;
            letter-spacing: 3px;
            word-break: break-all;
          }
          
          .section {
            margin: 25px 0;
          }
          
          .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #8b6f47;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #b08b33;
          }
          
          .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid #e0d5c7;
          }
          
          .info-label {
            font-size: 10px;
            font-weight: 600;
            color: #8b6f47;
            text-transform: uppercase;
            letter-spacing: 1px;
            flex: 0 0 35%;
          }
          
          .info-value {
            font-size: 12px;
            font-weight: 600;
            color: #3e2a1f;
            flex: 1;
            text-align: right;
          }
          
          .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 3px solid #b08b33;
            font-size: 11px;
            color: #8b6f47;
          }
          
          .footer p {
            margin: 6px 0;
            line-height: 1.4;
          }
          
          .print-date {
            font-size: 10px;
            color: #b08b33;
            opacity: 0.7;
            margin-top: 12px;
          }
          
          @media print {
            body {
              padding: 0;
            }
          }
        </style>
      </head>
      <body>
        <div class="container">
          <div class="header">
            <div class="header-title">BUKTI PEMINJAMAN</div>
            <div class="header-subtitle">Alexandria Library</div>
          </div>
          
          <div class="kode-section">
            <div class="kode-label">Kode Peminjaman</div>
            <div class="kode-value">${kode}</div>
          </div>
          
          <div class="section">
            <div class="section-title">Data Peminjam</div>
            <div class="info-row">
              <span class="info-label">Nama</span>
              <span class="info-value">${nama}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Alamat</span>
              <span class="info-value">${alamat}</span>
            </div>
            <div class="info-row">
              <span class="info-label">No. HP</span>
              <span class="info-value">${hp}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Status</span>
              <span class="info-value">${status}</span>
            </div>
          </div>
          
          <div class="section">
            <div class="section-title">Data Buku</div>
            <div class="info-row">
              <span class="info-label">Judul</span>
              <span class="info-value">${judul}</span>
            </div>
          </div>
          
          <div class="section">
            <div class="section-title">Jadwal Peminjaman</div>
            <div class="info-row">
              <span class="info-label">Tanggal</span>
              <span class="info-value">${tanggal}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Jam</span>
              <span class="info-value">${jam}</span>
            </div>
          </div>
          
          <div class="footer">
            <p>Simpan bukti ini untuk referensi Anda</p>
            <p>Tunjukkan saat mengambil atau mengembalikan buku</p>
            <div class="print-date">Dicetak: ${new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</div>
          </div>
        </div>
      </body>
      </html>
    `;
    
    const printWindow = window.open('', '', 'width=800,height=900');
    printWindow.document.write(printContent);
    printWindow.document.close();
    setTimeout(() => {
      printWindow.print();
    }, 250);
  }

  // Close modal when clicking outside
  document.getElementById('buktiModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
      closeBuktiModal();
    }
  });

  // Close ulasan modal when clicking outside
  document.getElementById('ulasanModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
      closeUlasanModal();
    }
  });

  // Close with ESC key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeBuktiModal();
      closeUlasanModal();
    }
  });
</script>

</body>
</html>
