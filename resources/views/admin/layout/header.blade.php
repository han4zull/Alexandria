{{-- TOP BAR --}}
<div class="flex items-center justify-between mb-8">
  <h1 class="judul text-3xl font-black text-[#8b6f47] flex items-center gap-2">
    @yield('page-icon')
    @yield('page-title')
  </h1>

  {{-- PROFILE --}}
  <div class="flex items-center gap-3">
    <div class="text-right">
      <div class="text-xs text-[#6b5a4a]">Hai,</div>
      <div class="text-sm font-semibold">{{ auth('admin')->user()->nama ?? 'Admin' }}</div>
    </div>
    @if(auth('admin')->user() && auth('admin')->user()->foto_profil)
      <img src="{{ asset('storage/'.auth('admin')->user()->foto_profil) }}" class="w-12 h-12 rounded-full object-cover shadow-lg border-2 border-[#c9a44c]">
    @else
      <div class="w-12 h-12 rounded-full bg-[#b08b33] text-white flex items-center justify-center font-semibold shadow-lg border-2 border-[#c9a44c]">
        {{ strtoupper(substr(auth('admin')->user()->nama ?? 'A', 0, 1)) }}
      </div>
    @endif
  </div>
</div>