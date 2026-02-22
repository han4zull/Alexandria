<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku | Alexandria Library</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background: radial-gradient(circle at top left, #fdf7ed, #f4efe4 45%, #ede3d6); background-attachment: fixed; }
        .glass { background: rgba(255,255,255,0.65); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.5); }
    </style>
</head>

<body class="text-[#3e2a1f]">

<div class="min-h-screen flex gap-6 p-6">

    {{-- SIDEBAR --}}
    @include('admin.layout.sidebar')

    {{-- MAIN --}}
    <main class="flex-1 glass rounded-3xl p-8 shadow-xl">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                <i class="fa-solid fa-pen text-[#c9a44c]"></i> Edit Buku
            </h1>
            <p class="text-sm text-[#6b5a4a] mt-1">Ubah data buku sesuai kebutuhan</p>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 text-green-800 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 p-4 text-red-800 bg-red-100 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Edit Buku -->
        <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-semibold text-gray-700">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn', $buku->isbn) }}" class="mt-1 w-full rounded-lg border-gray-300 px-4 py-3">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" class="mt-1 w-full rounded-lg border-gray-300 px-4 py-3">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="mt-1 w-full rounded-lg border-gray-300 px-4 py-3">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="mt-1 w-full rounded-lg border-gray-300 px-4 py-3">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Tahun Terbit</label>
                    <input type="text" name="tahun_terbit" inputmode="numeric" pattern="[0-9]{4}"
                           value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" placeholder="Contoh: 2023"
                           class="mt-1 w-full rounded-lg border-gray-300 px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Stok</label>
                    <input type="number" name="stok" min="1" value="{{ old('stok', $buku->stok) }}" class="mt-1 w-full rounded-lg border-gray-300 px-4 py-3">
                </div>
            </div>

            <!-- Kategori -->
            <div>
                <label class="text-sm font-semibold text-gray-700 mb-2 block">Kategori</label>

                <input type="hidden" name="kategori_id" id="kategoriInput" value="{{ $buku->kategori->first()?->id }}" required>

                <div id="kategoriList" class="flex flex-wrap gap-x-4 gap-y-2 text-sm p-3 rounded-lg bg-white border border-gray-300">
                    @foreach($kategori as $k)
                    <label class="kategori-label flex items-center gap-1 cursor-pointer text-gray-700 transition" data-id="{{ $k->id }}">
                        <input type="checkbox" class="kategori-checkbox accent-indigo-600"
                               {{ $buku->kategori->first()?->id == $k->id ? 'checked' : '' }}>
                        <span>{{ $k->nama_kategori }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Cover -->
            <div>
                <label class="text-sm font-semibold text-gray-700 mb-2 block">Cover Buku</label>
                <label for="cover" class="group cursor-pointer w-40 aspect-[2/3] flex items-center justify-center rounded-2xl border-2 border-dashed border-gray-300 bg-white hover:border-indigo-400 hover:bg-indigo-50 transition relative overflow-hidden">
                    @if($buku->cover)
                        <img id="coverPreview" src="{{ asset('storage/'.$buku->cover) }}" class="w-full h-full object-cover"/>
                    @else
                        <img id="coverPreview" class="hidden w-full h-full object-cover"/>
                    @endif
                    <div id="coverPlaceholder" class="text-center text-gray-500 group-hover:text-indigo-600 px-2 {{ $buku->cover ? 'hidden' : '' }}">
                        <i class="fa-solid fa-book-open text-3xl mb-2"></i>
                        <div class="text-xs font-medium">Upload Cover</div>
                    </div>
                    <input type="file" name="cover" id="cover" accept="image/*" class="hidden">
                </label>
                <p class="text-xs text-gray-500 mt-2">Rasio disarankan 2:3 (contoh: 400×600)</p>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="text-sm font-semibold text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="6" class="mt-1 w-full rounded-lg border-gray-300 px-4 py-3">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('buku_admin') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    <i class="fa-solid fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-7 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-lg">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
            </div>

        </form>
    </main>
</div>

<script>
const labels = document.querySelectorAll('.kategori-label');
const input = document.getElementById('kategoriInput');

// SET AWAL DARI HIDDEN INPUT
const selectedId = input.value;

labels.forEach(label => {
    const checkbox = label.querySelector('.kategori-checkbox');
    if (label.dataset.id === selectedId) {
        checkbox.checked = true;
        label.classList.add('font-semibold');
        labels.forEach(l => {
            if (l !== label) l.classList.add('opacity-40');
        });
    } else {
        label.classList.add('opacity-40');
    }
});

// CLICK HANDLER
labels.forEach(label => {
    label.addEventListener('click', e => {
        e.preventDefault();
        const checkbox = label.querySelector('.kategori-checkbox');
        const isActive = checkbox.checked;

        // reset semua
        labels.forEach(l => {
            l.querySelector('.kategori-checkbox').checked = false;
            l.classList.remove('font-semibold');
            l.classList.add('opacity-40');
        });

        if (!isActive) {
            checkbox.checked = true;
            label.classList.add('font-semibold');
            label.classList.remove('opacity-40');
            input.value = label.dataset.id;
        } else {
            input.value = '';
        }
    });
});

// Cover preview
const coverInput = document.getElementById('cover');
const preview = document.getElementById('coverPreview');
const placeholder = document.getElementById('coverPlaceholder');

coverInput.addEventListener('change', () => {
    const file = coverInput.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    }
});
</script>

</body>
</html>
