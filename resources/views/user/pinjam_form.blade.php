<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Form Pinjam | Alexandria Library</title>
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
    
    /* Modal Animations */
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .modal-enter {
      animation: slideUp 0.3s ease-out;
    }
    
    .modal-overlay {
      transition: opacity 0.3s ease-out;
    }
  </style>
</head>
<body class="text-[#3e2a1f]">
  <div class="min-h-screen flex gap-6 p-6">
    @include('user.layout.sidebar')

    <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">
      <div class="flex items-center justify-between mb-6">
        <h1 class="judul text-3xl font-black text-[#8b6f47] flex items-center gap-2">
          <svg class="w-6 h-6 text-[#8b6f47]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
          Form Peminjaman
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

      <div class="w-full bg-white/70 rounded-2xl p-6 shadow">
        <h2 class="text-lg font-semibold judul mb-4">{{ $buku->judul }}</h2>
        <div class="flex gap-8">
          <div class="w-32 flex-shrink-0">
            @if($buku->cover)
              <img src="{{ asset('storage/'.$buku->cover) }}" alt="{{ $buku->judul }}" class="w-full aspect-[2/3] object-cover rounded-lg shadow">
            @else
              <div class="w-full aspect-[2/3] flex items-center justify-center bg-gradient-to-br from-[#d4c4b0] to-[#c9a44c] rounded-lg">
                <svg class="w-16 h-16 text-[#8b7355]" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H6a1 1 0 110-2V4z"></path>
                </svg>
              </div>
            @endif
          </div>
          <div class="flex-1">
            <form action="{{ route('buku.pinjam.submit', ['id' => $buku->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="grid grid-cols-2 gap-4 mb-3">
                <div>
                  <label class="block text-xs font-medium text-gray-700">Username</label>
                  <input type="text" readonly disabled value="{{ Auth::user()->username ?? '' }}" class="mt-1 w-full border rounded px-3 py-2 bg-gray-100 text-sm cursor-not-allowed">
                </div>
                <div>
                  <label class="block text-xs font-medium text-gray-700">Email</label>
                  <input type="text" readonly disabled value="{{ Auth::user()->email ?? '' }}" class="mt-1 w-full border rounded px-3 py-2 bg-gray-100 text-sm cursor-not-allowed">
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-medium text-gray-700">No. Anggota</label>
                  <input type="text" name="no_anggota" readonly value="{{ Auth::user()->no_anggota ?? '' }}" class="mt-1 w-full border rounded px-3 py-2 bg-gray-50 text-sm">
                </div>
                <div>
                  <label class="block text-xs font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                  <input type="text" name="nama_lengkap" id="input_nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->nama_lengkap ?? '') }}" readonly class="mt-1 w-full border rounded px-3 py-2 bg-gray-100">
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4 mt-3">
                <div>
                  <label class="block text-xs font-medium text-gray-700">Alamat <span class="text-red-500">*</span></label>
                  <input type="text" name="alamat" id="input_alamat" value="{{ old('alamat', Auth::user()->alamat ?? '') }}" readonly class="mt-1 w-full border rounded px-3 py-2 bg-gray-100">
                </div>
                <div>
                  <label class="block text-xs font-medium text-gray-700">Nomor HP <span class="text-red-500">*</span></label>
                  <input type="text" name="nomer_hp" id="input_nomer_hp" value="{{ old('nomer_hp', Auth::user()->nomer_hp ?? '') }}" readonly class="mt-1 w-full border rounded px-3 py-2 bg-gray-100">
                </div>
              </div>

              <div class="mt-3">
                <label class="block text-xs font-medium text-gray-700">Foto KTP/Kartu Pelajar/KIA <span class="text-red-500">*</span></label>
                <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*" required class="mt-1 w-full border rounded px-3 py-2 text-sm">
                <p class="text-xs text-gray-500 mt-1">Upload gambar KTP, Kartu Pelajar, atau KIA untuk verifikasi identitas</p>
              </div>

              <input type="hidden" name="username" value="{{ Auth::user()->username ?? '' }}">
              <input type="hidden" name="email" value="{{ Auth::user()->email ?? '' }}">

              <div class="grid grid-cols-3 gap-4 mt-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                  <input id="tanggal_pinjam" name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam', now()->toDateString()) }}" min="{{ now()->toDateString() }}" class="mt-1 w-full border rounded px-3 py-2 text-sm">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Durasi (hari)</label>
                  <input type="text" readonly disabled value="7" class="mt-1 w-full border rounded px-3 py-2 bg-gray-100 text-sm cursor-not-allowed font-semibold text-center">
                  <input type="hidden" name="durasi" value="7">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                  <input id="tanggal_kembali" name="tanggal_kembali" type="date" value="{{ old('tanggal_kembali', now()->addDays(7)->toDateString()) }}" readonly class="mt-1 w-full border rounded px-3 py-2 bg-gray-100 text-sm cursor-not-allowed">
                </div>
              </div>

              <p class="mt-4 text-xs text-[#6b5a4a] bg-yellow-50 border-l-2 border-yellow-400 p-2 rounded">
                <svg class="inline w-4 h-4 mr-2 align-middle text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 11-9 9 9 9 0 019-9z"></path>
                </svg>
                Catatan: Jika terlambat 1 hari denda Rp5.000, rusak Rp50.000, hilang Rp100.000
              </p>

              <div class="mt-5 flex gap-3">
                <button type="button" id="openModalBtn" class="flex-1 px-4 py-2 bg-[#8b6f47] text-white rounded font-medium hover:bg-[#705a35]">Pinjam Buku</button>
                <a href="{{ route('buku.detailbuku', ['id' => $buku->id]) }}" class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded font-medium text-center hover:bg-gray-50">Batal</a>
              </div>

              <!-- Hidden submit button -->
              <button type="submit" id="realSubmit" class="hidden"></button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Confirmation Modal -->
  <div id="confirmModal" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden modal-overlay">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 modal-enter">
      <!-- Header -->
      <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white p-6 rounded-t-2xl">
        <h3 class="text-xl font-bold">Konfirmasi Peminjaman</h3>
        <p class="text-sm text-amber-100 mt-1">Periksa kembali data Anda sebelum melanjutkan</p>
      </div>

      <!-- Content -->
      <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
        <!-- Book -->
        <div class="border-l-4 border-blue-500 pl-4">
          <p class="text-xs font-semibold text-gray-600 uppercase">Buku yang Dipinjam</p>
          <p class="font-bold text-gray-900">{{ $buku->judul }}</p>
        </div>

        <!-- User Info -->
        <div class="border-l-4 border-purple-500 pl-4">
          <p class="text-xs font-semibold text-gray-600 uppercase">Data Peminjam</p>
          <div class="text-sm text-gray-700 space-y-1 mt-2">
            <p><strong>Nama:</strong> <span id="confirmNama">{{ Auth::user()->nama_lengkap ?? '-' }}</span></p>
            <p><strong>No. HP:</strong> <span id="confirmHP">{{ Auth::user()->nomer_hp ?? '-' }}</span></p>
            <p><strong>Alamat:</strong> <span id="confirmAlamat">{{ Auth::user()->alamat ?? '-' }}</span></p>
          </div>
        </div>

        <!-- Dates -->
        <div class="border-l-4 border-green-500 pl-4">
          <p class="text-xs font-semibold text-gray-600 uppercase">Periode Peminjaman</p>
          <div class="text-sm text-gray-700 space-y-1 mt-2">
            <p><strong>Pinjam:</strong> <span id="confirmTanggalPinjam">-</span></p>
            <p><strong>Kembali:</strong> <span id="confirmTanggalKembali">-</span></p>
            <p><strong>Durasi:</strong> 7 Hari</p>
          </div>
        </div>

        <!-- Warning -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mt-4">
          <p class="text-xs text-red-700"><strong>
            <svg class="inline w-4 h-4 mr-1 align-middle text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 11-9 9 9 9 0 019-9z"></path>
            </svg>
            Perhatian:</strong> Pastikan data di atas sudah benar. Jika ada kesalahan, silakan batal dan periksa kembali profil Anda.</p>
        </div>
      </div>

      <!-- Footer -->
      <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex gap-3 border-t">
        <button type="button" id="confirmCancelBtn" class="flex-1 px-4 py-2 bg-gray-300 text-gray-800 rounded-lg font-medium hover:bg-gray-400 transition">Batal</button>
        <button type="button" id="confirmSubmitBtn" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">Ya, Pinjam Buku!</button>
      </div>
    </div>
  </div>

  <!-- Profile Modal -->
  <div id="profileModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-40 hidden">
    <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-lg">
      <h3 class="text-lg font-bold mb-2">Lengkapi Data Profil</h3>
      <p class="text-sm text-gray-700 mb-4">Untuk melakukan peminjaman, silakan lengkapi Nama Lengkap, Alamat, dan Nomor HP di halaman profil Anda.</p>
      <div class="flex justify-end gap-3">
        <a href="{{ route('profile_user') }}" class="px-4 py-2 bg-green-600 text-white rounded">Isi Profil</a>
      </div>
    </div>
  </div>

  <script>
  const openModalBtn = document.getElementById('openModalBtn');
  const confirmModal = document.getElementById('confirmModal');
  const profileModal = document.getElementById('profileModal');
  const confirmCancelBtn = document.getElementById('confirmCancelBtn');
  const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
  const realSubmit = document.getElementById('realSubmit');
  const tanggalPinjamInput = document.getElementById('tanggal_pinjam');
  const tanggalKembaliInput = document.getElementById('tanggal_kembali');

  // ===== UPDATE TANGGAL KEMBALI OTOMATIS =====
  function updateReturnDate(){
    const sd = new Date(tanggalPinjamInput.value);
    sd.setDate(sd.getDate() + 7);
    const y = sd.getFullYear();
    const m = String(sd.getMonth()+1).padStart(2,'0');
    const d = String(sd.getDate()).padStart(2,'0');
    tanggalKembaliInput.value = `${y}-${m}-${d}`;
  }

  tanggalPinjamInput.addEventListener('change', updateReturnDate);
  updateReturnDate();

  // ===== CEK PROFIL KOSONG =====
  function anyProfileEmpty() {
    return (
      !document.getElementById('input_nama_lengkap')?.value?.trim() ||
      !document.getElementById('input_alamat')?.value?.trim() ||
      !document.getElementById('input_nomer_hp')?.value?.trim()
    );
  }

  // ===== BUKA MODAL PROFIL JIKA PROFIL KOSONG SAAT PAGE LOAD =====
  document.addEventListener('DOMContentLoaded', () => {
    if (anyProfileEmpty()) {
      profileModal.classList.remove('hidden');
    }
  });

  // ===== TOMBOL PINJAM: BUKA MODAL KONFIRMASI =====
  openModalBtn.addEventListener('click', function(e){
    e.preventDefault();

    // Cek profil dulu
    if (anyProfileEmpty()) {
      profileModal.classList.remove('hidden');
      return;
    }

    // Isi data konfirmasi dari form
    document.getElementById('confirmNama').textContent =
      document.getElementById('input_nama_lengkap').value;
    document.getElementById('confirmHP').textContent =
      document.getElementById('input_nomer_hp').value;
    document.getElementById('confirmAlamat').textContent =
      document.getElementById('input_alamat').value;
    document.getElementById('confirmTanggalPinjam').textContent =
      new Date(tanggalPinjamInput.value).toLocaleDateString('id-ID');
    document.getElementById('confirmTanggalKembali').textContent =
      new Date(tanggalKembaliInput.value).toLocaleDateString('id-ID');

    // Buka modal
    confirmModal.classList.remove('hidden');
  });

  // ===== BATAL: TUTUP MODAL =====
  confirmCancelBtn.addEventListener('click', () => {
    confirmModal.classList.add('hidden');
  });

  // ===== YA PINJAM: TRIGGER FORM SUBMIT =====
  confirmSubmitBtn.addEventListener('click', function(){
    realSubmit.click();
  });
</script>

</body>
</html>