<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Admin</title>

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
  @include('admin.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/90 rounded-3xl p-10 shadow-xl">

    <div class="flex items-center justify-between mb-8">
      <div>
        <h2 class="judul text-3xl mb-2">Edit Admin</h2>
        <p class="text-sm text-[#7a5c45]">Perbarui data admin</p>
      </div>

      <!-- PROFILE DI KANAN ATAS -->
      <div class="flex items-center gap-3">
        <div class="text-right">
          <div class="text-xs text-[#6b5a4a]">Hai,</div>
          <div class="text-sm font-semibold">{{ auth('admin')->user()->nama ?? 'Admin' }}</div>
        </div>

        @if(auth('admin')->user() && auth('admin')->user()->foto_profil)
          <img src="{{ asset('storage/'.auth('admin')->user()->foto_profil) }}"
               class="w-12 h-12 rounded-full object-cover shadow-lg border-2 border-[#c9a44c]">
        @else
          <div class="w-12 h-12 rounded-full bg-[#b08b33] text-white
                      flex items-center justify-center font-semibold shadow-lg border-2 border-[#c9a44c]">
            {{ strtoupper(substr(auth('admin')->user()->nama ?? 'A', 0, 1)) }}
          </div>
        @endif
      </div>
    </div>

    @if(session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-xl border border-green-200">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-xl border border-red-200">
        {{ session('error') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-xl border border-red-200">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.update', $admin->id) }}"
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
               value="{{ old('nama', $admin->nama) }}"
               class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                      focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
      </div>

      <!-- EMAIL -->
      <div>
        <label class="block text-sm font-medium mb-2">Email</label>
        <input type="email" name="email" required autocomplete="off"
               value="{{ old('email', $admin->email) }}"
               class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                      focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
      </div>

      <!-- JENIS KELAMIN -->
      <div>
        <label class="block text-sm font-medium mb-2">Jenis Kelamin</label>
        <select name="jenis_kelamin"
                class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                       focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
          <option value="">Pilih Jenis Kelamin</option>
          <option value="L" {{ old('jenis_kelamin', $admin->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
          <option value="P" {{ old('jenis_kelamin', $admin->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
      </div>

      <!-- PASSWORD (OPTIONAL) -->
      <div>
        <label class="block text-sm font-medium mb-2">Password Baru (Opsional)</label>
        <input type="password" name="password" autocomplete="off"
               class="w-full px-4 py-3 rounded-xl border border-[#e2d3c1] shadow
                      focus:ring-2 focus:ring-[#c9a44c] focus:outline-none">
        <p class="text-xs text-[#7a5c45] mt-1">Kosongkan jika tidak ingin mengubah password</p>
      </div>

      <!-- FOTO PROFIL -->
      <div>
        <label class="block text-sm font-medium mb-2">Foto Profil</label>
        <div class="flex flex-col gap-3">

          <div id="frame" class="w-48 h-48 border-2 border-dashed border-[#c9a44c] rounded-xl overflow-hidden bg-[#f3eee6] relative">
            <img id="previewFoto" class="absolute top-0 left-0 cursor-grab"
                 src="{{ $admin->foto_profil ? asset('storage/'.$admin->foto_profil) : '' }}"
                 alt="Preview Foto"
                 @if(!$admin->foto_profil) hidden @endif>
            <span id="placeholderIcon" class="absolute inset-0 flex items-center justify-center text-xs text-[#7a5c45]"
                  @if($admin->foto_profil) style="display:none;" @endif>
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
        </div>
      </div>

      <!-- BUTTONS -->
      <div class="flex gap-4 pt-6">
        <a href="{{ route('admin.profile') }}"
           class="px-6 py-3 bg-gray-500 text-white rounded-xl font-medium shadow-lg hover:bg-gray-600 transition">
          Batal
        </a>
        <button type="submit"
                class="px-6 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:from-[#d4af55] hover:to-[#936d42] transition">
          Simpan Perubahan
        </button>
      </div>

    </form>

  </main>
</div>

<script>
function previewImage(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('previewFoto').src = e.target.result;
      document.getElementById('previewFoto').hidden = false;
      document.getElementById('placeholderIcon').style.display = 'none';
    };
    reader.readAsDataURL(file);
  }
}

function zoomImage(value) {
  const img = document.getElementById('previewFoto');
  img.style.transform = `scale(${value})`;
}
</script>

</body>
</html>