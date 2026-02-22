<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile Petugas | Alexandria Library</title>

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
  @include('petugas.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    @section('page-icon')
    <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    @endsection

    @section('page-title')
    Edit Profile
    @endsection

    @include('petugas.layout.header')

    <form action="{{ route('petugas.update', $petugas->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6"
          autocomplete="off">
      @csrf
      @method('PUT')

      <!-- NAMA -->
      <div>
        <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
        <input type="text" name="nama" required autocomplete="off"
               value="{{ old('nama', $petugas->nama) }}"
               class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                      focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
        @error('nama')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- EMAIL -->
      <div>
        <label class="block text-sm font-medium mb-2">Email</label>
        <input type="email" name="email" required autocomplete="off"
               value="{{ old('email', $petugas->email) }}"
               class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                      focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
        @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- JENIS KELAMIN -->
      <div>
        <label class="block text-sm font-medium mb-2">Jenis Kelamin</label>
        <select name="jenis_kelamin" required class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
          <option value="">-- Pilih --</option>
          <option value="L" {{ old('jenis_kelamin', $petugas->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
          <option value="P" {{ old('jenis_kelamin', $petugas->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- FOTO PROFIL -->
      <div>
        <label class="block text-sm font-medium mb-2">Foto Profil</label>
        <div class="flex flex-col gap-3">

          <div id="frame" class="w-48 h-48 border-2 border-dashed border-[#c9a44c] rounded-xl overflow-hidden bg-[#f3eee6] relative">
            <img id="previewFoto" class="absolute top-0 left-0 cursor-grab"
                 src="{{ $petugas->foto ? asset('storage/'.$petugas->foto) : '' }}"
                 alt="Preview Foto"
                 @if(!$petugas->foto) hidden @endif>
            <span id="placeholderIcon" class="absolute inset-0 flex items-center justify-center text-xs text-[#7a5c45]"
                  @if($petugas->foto) style="display:none;" @endif>
              Preview
            </span>
          </div>

          <div class="flex items-center gap-3">
            <label class="text-sm text-[#7a5c45]">Zoom</label>
            <input id="zoomSlider" type="range" min="1" max="3" step="0.05" value="1"
                   class="flex-1" oninput="zoomImage(this.value)">
          </div>

          <input type="file"
                 name="foto"
                 accept="image/*"
                 onchange="previewImage(event)"
                 class="px-4 py-3 rounded-xl border border-[#e2d3c1] bg-white shadow focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
          <p class="text-xs text-[#7a5c45] mt-1">JPG / PNG • Maks 2MB</p>
          @error('foto')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- BUTTONS -->
      <div class="flex justify-end gap-4 pt-8">
        <a href="{{ route('profile_petugas') }}"
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
          Perbarui Profile
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
</script>

</body>
</html>
