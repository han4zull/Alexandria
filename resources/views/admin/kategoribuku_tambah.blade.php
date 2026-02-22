<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kategori (Admin)</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style> body { font-family: 'Inter', sans-serif; background: radial-gradient(circle at top, #f6f1ea, #e2d3c1); } .judul { font-family: 'Poppins', sans-serif } </style>
</head>
<body class="text-[#3e2a1f]">
  <div class="min-h-screen flex gap-6 p-6">
    @include('admin.layout.sidebar')

    <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">
      <h2 class="judul text-3xl mb-2">Tambah Kategori</h2>
      <p class="text-sm text-[#7a5c45] mb-6">Tambahkan kategori baru untuk buku.</p>

      <div class="bg-white rounded-xl p-6 shadow max-w-md">
        @if($errors->any())
          <div class="mb-4 text-red-700">
            <ul>
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.kategori.store') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label class="block text-sm mb-2">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="w-full px-4 py-3 border rounded" required>
          </div>

          <div class="flex gap-3">
            <button class="px-4 py-2 bg-[#c9a44c] text-white rounded">Simpan</button>
            <a href="{{ route('kategoribuku_admin') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
          </div>
        </form>
      </div>

    </main>
  </div>
</body>
</html>
