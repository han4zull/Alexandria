<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Admin</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at top, #f6f1ea, #e2d3c1);
    }
    .judul { font-family: 'Poppins', sans-serif }
  </style>
</head>

<body class="text-[#3e2a1f]">

<div class="min-h-screen flex gap-6 p-6">

  {{-- SIDEBAR --}}
  @include('admin.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/90 rounded-3xl p-10 shadow-xl">

    <h2 class="judul text-3xl mb-2">Tambah Admin</h2>
    <p class="text-sm text-[#7a5c45] mb-10">
      Lengkapi data petugas agar dapat mengelola sistem
    </p>

   <form action="{{ route('admin.petugas.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="space-y-6"
      autocomplete="off">
  @csrf

  <!-- DUMMY FIELDS (Biar Browser Auto-fill Gagal) -->
  <input type="text" name="fakeusernameremembered" style="display:none">
  <input type="password" name="fakepasswordremembered" style="display:none">

  <!-- NAMA -->
  <div>
    <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
    <input type="text" name="nama" required autocomplete="off"
      class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
             focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
  </div>

  <!-- USERNAME -->
  <div>
    <label class="block text-sm font-medium mb-2">Username</label>
    <input type="text" name="username" required autocomplete="off"
      class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
             focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
  </div>

  <!-- EMAIL -->
  <div>
    <label class="block text-sm font-medium mb-2">Email</label>
    <input type="email" name="email" required autocomplete="off" autocapitalize="off"
      class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
             focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
  </div>

  <!-- TANGGAL DIBUAT -->
  <div>
    <label class="block text-sm font-medium mb-2">Tanggal Dibuat</label>
    <input type="date" name="tanggal_dibuat" autocomplete="off"
      class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1]
             bg-[#f3eee6] text-[#7a5c45] shadow">
  </div>

  <!-- FOTO PROFIL (1x1 + ZOOM + DRAG) -->
  <div>
    <label class="block text-sm font-medium mb-2">Foto Profil</label>

    <div class="flex flex-col gap-3">

      <!-- PREVIEW KOTAK 1x1 -->
      <div id="frame"
           class="w-48 h-48 border-2 border-dashed border-[#c9a44c] rounded-xl overflow-hidden bg-[#f3eee6] relative">
        <img id="previewFoto"
             class="absolute top-0 left-0 cursor-grab"
             src=""
             alt="Preview Foto"
             hidden>
        <span id="placeholderIcon"
              class="absolute inset-0 flex items-center justify-center text-xs text-[#7a5c45]">
          Preview
        </span>
      </div>

      <!-- ZOOM SLIDER -->
      <div class="flex items-center gap-3">
        <label class="text-sm text-[#7a5c45]">Zoom</label>
        <input id="zoomSlider" type="range" min="1" max="3" step="0.05" value="1"
               class="flex-1"
               oninput="zoomImage(this.value)">
      </div>

      <!-- INPUT FILE -->
      <input type="file"
             name="foto_profil"
             accept="image/*"
             onchange="previewImage(event)"
             class="px-4 py-3 rounded-xl border border-[#e2d3c1]
                    bg-white shadow focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">

      <p class="text-xs text-[#7a5c45] mt-1">
        JPG / PNG • Maks 2MB
      </p>
    </div>
  </div>

  <!-- PASSWORD (SHOW/HIDE) -->
  <div class="relative">
    <label class="block text-sm font-medium mb-2">Password</label>

    <input id="password"
           type="password"
           name="password"
           required
           autocomplete="new-password"
           class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                  focus:ring-2 focus:ring-[#c9a44c] focus:outline-none pr-12">

    <button type="button"
            onclick="togglePassword()"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7a5c45]">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      </svg>
    </button>
  </div>

  <!-- JENIS KELAMIN -->
  <div>
    <label class="block text-sm font-medium mb-2">Jenis Kelamin</label>
    <select name="jenis_kelamin" required
      class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
             focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
      <option value="">-- Pilih --</option>
      <option value="L">Laki-laki</option>
      <option value="P">Perempuan</option>
    </select>
  </div>

  <!-- ROLE -->
  <input type="hidden" name="role" value="admin">

  <!-- BUTTON -->
  <div class="flex justify-end gap-3 pt-6">
    <a href="{{ route('petugas_admin') }}"
       class="px-6 py-3 rounded-xl border border-[#c9a44c]
              text-[#7a5c45] hover:bg-[#efe5d3] transition">
      Batal
    </a>

    <button type="submit"
      class="px-8 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f]
             text-white rounded-xl shadow-lg hover:scale-[1.03] transition">
      Simpan Admin
    </button>
  </div>
</form>

  </main>
</div>

<!-- SCRIPT PREVIEW -->
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
    placeholder.classList.add('hidden');

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