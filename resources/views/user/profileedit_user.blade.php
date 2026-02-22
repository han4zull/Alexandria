<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil | Alexandria Library</title>

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
  </style>
</head>
<body class="text-[#3e2a1f]">
<div class="min-h-screen flex gap-6 p-6">

  {{-- SIDEBAR --}}
  @include('user.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    <div class="flex items-center justify-between mb-8">
      <h1 class="judul text-3xl font-black text-[#8b6f47] flex items-center gap-2">
        <svg class="w-6 h-6 text-[#8b6f47]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Edit Profil
      </h1>

      <!-- PROFILE DI KANAN ATAS -->
      <div class="flex items-center gap-3">
        <div class="text-right">
          <div class="text-xs text-[#6b5a4a]">Hai,</div>
          <div class="text-sm font-semibold">{{ auth('web')->user()->nama_lengkap ?? 'User' }}</div>
        </div>

        @if(auth('web')->user()->foto_profil)
          <img src="{{ asset('storage/'.auth('web')->user()->foto_profil) }}"
               class="w-12 h-12 rounded-full object-cover shadow-lg border-2 border-[#c9a44c]">
        @else
          <div class="w-12 h-12 rounded-full bg-[#b08b33] text-white
                      flex items-center justify-center font-semibold shadow-lg border-2 border-[#c9a44c]">
            {{ strtoupper(substr(auth('web')->user()->nama_lengkap ?? 'U', 0, 1)) }}
          </div>
        @endif
      </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" autocomplete="off">
      @csrf

      <!-- NAMA LENGKAP -->
      <div>
        <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" required autocomplete="off"
               value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
               class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                      focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
        @error('nama_lengkap')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- EMAIL -->
      <div>
        <label class="block text-sm font-medium mb-2">Email</label>
        <input type="email" name="email" required autocomplete="off"
               value="{{ old('email', $user->email) }}"
               class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                      focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
        @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- NOMER HP -->
      <div>
        <label class="block text-sm font-medium mb-2">Nomer HP</label>
        <input type="text" name="nomer_hp" autocomplete="off"
               value="{{ old('nomer_hp', $user->nomer_hp) }}"
               class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                      focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
        @error('nomer_hp')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- ALAMAT -->
      <div>
        <label class="block text-sm font-medium mb-2">Alamat</label>
        <textarea name="alamat" rows="3" autocomplete="off"
                  class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                         focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">{{ old('alamat', $user->alamat) }}</textarea>
        @error('alamat')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- FOTO PROFIL -->
      <div>
        <label class="block text-sm font-medium mb-2">Foto Profil</label>
        <div class="flex flex-col gap-3">

          <div id="frame" class="w-48 h-48 border-2 border-dashed border-[#c9a44c] rounded-xl overflow-hidden bg-[#f3eee6] relative">
            <img id="previewFoto" class="absolute top-0 left-0 cursor-grab"
                 src="{{ $user->foto_profil ? asset('storage/'.$user->foto_profil) : '' }}"
                 alt="Preview Foto"
                 @if(!$user->foto_profil) hidden @endif>
            <span id="placeholderIcon" class="absolute inset-0 flex items-center justify-center text-xs text-[#7a5c45]"
                  @if($user->foto_profil) style="display:none;" @endif>
              Preview
            </span>
          </div>

          <div class="flex items-center gap-3">
            <label class="text-sm text-[#7a5c45]">Zoom</label>
            <input id="zoomSlider" type="range" min="1" max="3" step="0.05" value="1"
                   class="flex-1" oninput="zoomImage(this.value)">
          </div>

          <input type="file"
                 name="foto_profil"
                 accept="image/*"
                 onchange="previewImage(event)"
                 class="px-4 py-3 rounded-xl border border-[#e2d3c1] bg-white shadow focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
          <p class="text-xs text-[#7a5c45] mt-1">JPG / PNG • Maks 2MB</p>
          @error('foto_profil')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- PASSWORD (kosong = tidak diubah) -->
      <div class="relative">
        <label class="block text-sm font-medium mb-2">Password Baru</label>
        <input id="password" type="password" name="password" autocomplete="off"
               class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow focus:ring-2 focus:ring-[#c9a44c] focus:outline-none pr-12"
               placeholder="Kosongkan jika tidak ingin mengubah password">
        <button type="button" onclick="togglePassword()"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7a5c45]">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
        </button>
        @error('password')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- BUTTONS -->
      <div class="flex justify-end gap-4 pt-8">
        <a href="{{ route('profile_user') }}"
           class="px-8 py-3 bg-white border-2 border-[#c9a44c] text-[#7a5c45] rounded-xl
                  font-semibold shadow-md hover:bg-[#c9a44c] hover:text-white
                  hover:shadow-lg hover:scale-[1.02] transition-all duration-300
                  flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
          Batal
        </a>
        <button type="submit"
                class="px-8 py-3 bg-gradient-to-r from-[#c9a44c] via-[#b08b33] to-[#8a6a3f]
                       text-white rounded-xl font-semibold shadow-lg
                       hover:shadow-xl hover:scale-[1.05] hover:from-[#b08b33] hover:via-[#8a6a3f] hover:to-[#6a4f2b]
                       transition-all duration-300 flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Perbarui Profil
        </button>
      </div>
    </form>

    </main>
  </div>
<script>
  let currentScale = 1;
  let posX = 0;
  let posY = 0;
  let dragging = false;
  let startX, startY;

  function previewImage(event) {
    const img = document.getElementById('previewFoto');
    const placeholder = document.getElementById('placeholderIcon');
    const slider = document.getElementById('zoomSlider');

    const file = event.target.files[0];
    if (!file) return;

    img.src = URL.createObjectURL(file);
    img.hidden = false;
    placeholder.style.display = 'none';

    currentScale = 1;
    slider.value = 1;
    posX = 0;
    posY = 0;

    img.style.transform = `translate(${posX}px, ${posY}px) scale(${currentScale})`;
  }

  function zoomImage(value) {
    const img = document.getElementById('previewFoto');
    currentScale = value;
    img.style.transform = `translate(${posX}px, ${posY}px) scale(${currentScale})`;
  }

  const img = document.getElementById('previewFoto');
  const frame = document.getElementById('frame');

  frame.addEventListener('mousedown', (e) => {
    if (img.hidden) return;
    dragging = true;
    startX = e.clientX;
    startY = e.clientY;
    img.style.cursor = 'grabbing';
  });

  window.addEventListener('mousemove', (e) => {
    if (!dragging) return;
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;
    startX = e.clientX;
    startY = e.clientY;
    posX += dx;
    posY += dy;
    img.style.transform = `translate(${posX}px, ${posY}px) scale(${currentScale})`;
  });

  window.addEventListener('mouseup', () => {
    dragging = false;
    img.style.cursor = 'grab';
  });

  function togglePassword() {
    const pw = document.getElementById('password');
    pw.type = pw.type === 'password' ? 'text' : 'password';
  }
</script>
</body>
</html>
