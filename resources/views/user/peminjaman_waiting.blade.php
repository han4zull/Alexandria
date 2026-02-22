<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Menunggu Konfirmasi | Alexandria Library</title>
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
    
    /* Animations */
    @keyframes slideInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin-slow {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    @keyframes pulse-dot {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.4; }
    }
    
    .animate-slide-in { animation: slideInDown 0.6s ease-out; }
    .animate-spin-slow { animation: spin-slow 3s linear infinite; }
    .animate-pulse-dot { animation: pulse-dot 1.5s ease-in-out infinite; }
    
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 16px;
      background: #fef3c7;
      border: 2px solid #f59e0b;
      border-radius: 9999px;
      color: #92400e;
      font-weight: 600;
      font-size: 14px;
    }
    
    .spinner {
      width: 40px;
      height: 40px;
      border: 4px solid #f0f0f0;
      border-top: 4px solid #f59e0b;
      border-radius: 50%;
    }
  </style>
</head>
<body class="text-[#3e2a1f]">
  <div class="min-h-screen flex gap-6 p-6">
    @include('user.layout.sidebar')

    <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

      {{-- TOP BAR --}}
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="judul text-3xl mb-2">Menunggu Konfirmasi</h2>
          <p class="text-sm text-[#7a5c45]">Status permohonan peminjaman buku Anda</p>
        </div>

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

      {{-- WAITING HEADER --}}
      <div class="mb-6 animate-slide-in">
        <div class="glass rounded-3xl p-8 shadow-xl text-center border-2 border-amber-200 relative">
          <div class="flex justify-center mb-4">
            <div class="spinner animate-spin-slow"></div>
          </div>
          <h1 class="judul text-3xl font-bold text-amber-700 mb-2">Menunggu Konfirmasi</h1>
          <p class="text-[#6b5a4a]">Permohonan peminjaman Anda sedang diproses oleh petugas perpustakaan</p>
        </div>
      </div>

      <!-- Main Content -->
      <div class="grid grid-cols-3 gap-6">
        <!-- Left: Book Details -->
        <div class="col-span-2">
          <div class="glass rounded-3xl p-8 shadow-xl">
            <h2 class="judul text-2xl font-bold mb-6 text-[#8b6f47]">Detail Permohonan Peminjaman</h2>

            <div class="flex gap-6 mb-8">
              <!-- Book Cover -->
              <div class="w-48 flex-shrink-0">
                @if($buku->cover)
                  <img src="{{ asset('storage/'.$buku->cover) }}" alt="{{ $buku->judul }}" class="w-full aspect-[2/3] object-cover rounded-xl shadow-lg">
                @else
                  <div class="w-full aspect-[2/3] flex items-center justify-center bg-gradient-to-br from-[#d4c4b0] to-[#c9a44c] rounded-xl">
                    <svg class="w-16 h-16 text-[#8b7355]" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H6a1 1 0 110-2V4z"></path>
                    </svg>
                  </div>
                @endif
              </div>

              <!-- Book Info -->
              <div class="flex-1">
                <h3 class="judul text-2xl font-bold text-[#3e2a1f] mb-1">{{ $buku->judul }}</h3>
                <p class="text-[#6b5a4a] mb-6">{{ $buku->penulis ?? '-' }}</p>

                <!-- Status Info -->
                <div class="mb-6">
                  <p class="text-sm text-[#6b5a4a] mb-3">Status Permohonan:</p>
                  <div class="status-badge">
                    <div class="spinner" style="width: 12px; height: 12px; border-width: 2px;"></div>
                    <span>Menunggu Konfirmasi</span>
                  </div>
                </div>

                <!-- Timeline -->
                <div class="space-y-3 mb-6">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">1</div>
                    <div>
                      <p class="text-sm text-[#6b5a4a]">Tanggal Peminjaman</p>
                      <p class="font-semibold text-[#3e2a1f]">{{ $tanggal_pinjam->format('d/m/Y') }}</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold">2</div>
                    <div>
                      <p class="text-sm text-[#6b5a4a]">Batas Pengembalian</p>
                      <p class="font-semibold text-[#3e2a1f]">{{ $tanggal_kembali->format('d/m/Y') }}</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold">3</div>
                    <div>
                      <p class="text-sm text-[#6b5a4a]">Durasi Peminjaman</p>
                      <p class="font-semibold text-[#3e2a1f]">7 Hari</p>
                    </div>
                  </div>
                </div>

                <!-- Booking Code -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-4">
                  <p class="text-xs text-blue-600 uppercase tracking-wider">Kode Permohonan</p>
                  <p class="font-mono text-2xl font-bold text-blue-700 mt-1">{{ $peminjaman->kode_pinjam ?? 'N/A' }}</p>
                  <p class="text-xs text-blue-600 mt-2">Simpan kode ini untuk referensi</p>
                </div>
              </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-5 rounded-lg mb-6">
              <h4 class="font-semibold text-blue-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                Informasi
              </h4>
              <ul class="space-y-2 text-sm text-blue-800">
                <li>✓ Permohonan Anda telah diterima dan sedang diproses</li>
                <li>✓ Petugas perpustakaan akan memeriksa ketersediaan buku</li>
                <li>✓ Anda akan diberitahu setelah disetujui atau ditolak</li>
                <li>✓ QR code akan ditampilkan setelah persetujuan</li>
              </ul>
            </div>

            <!-- What to do next -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-lg">
              <h4 class="font-semibold text-amber-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                Langkah Selanjutnya:
              </h4>
              <ol class="space-y-2 text-sm text-amber-800">
                <li><strong>1.</strong> Tunggu notifikasi dari petugas perpustakaan</li>
                <li><strong>2.</strong> Periksa halaman riwayat peminjaman untuk update status</li>
                <li><strong>3.</strong> Jika disetujui, ambil buku di perpustakaan dengan membawa kartu pelajar/identitas</li>
                <li><strong>4.</strong> Tunjukkan QR code yang sudah digenerate kepada petugas</li>
              </ol>
            </div>
          </div>
        </div>

        <!-- Right: Status Card -->
        <div class="space-y-6">
          <!-- Status Card -->
          <div class="glass rounded-3xl p-6 shadow-xl text-center">
            <div class="mb-4">
              <div class="spinner animate-spin-slow mx-auto" style="width: 60px; height: 60px; border-width: 5px;"></div>
            </div>
            <h3 class="judul font-bold text-[#8b6f47] mb-2">Sedang Diproses</h3>
            <p class="text-sm text-[#6b5a4a] mb-4">Permohonan Anda sedang ditinjau oleh petugas perpustakaan</p>
            
            <div class="space-y-3 text-left">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <span class="text-sm text-[#6b5a4a]">Permohonan Diterima</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0 animate-pulse-dot">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <span class="text-sm text-[#6b5a4a]">Menunggu Verifikasi</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 flex-shrink-0">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </div>
                <span class="text-sm text-gray-400">Siap Diambil</span>
              </div>
            </div>
          </div>

          <div class="glass rounded-3xl p-6 shadow-xl">
            <h3 class="judul font-bold text-[#8b6f47] mb-4 flex items-center gap-2">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 100-2h-1a1 1 0 100 2h1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 100-2H4a1 1 0 000 2h1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4.522 4.522 0 00-2.477-.859l-.002.001a4.502 4.502 0 00-2.477.86c.269.212.462.518.477.858h2.477z"></path>
              </svg>
              Tips
            </h3>
            <div class="space-y-3 text-sm text-[#6b5a4a]">
              <p>Proses persetujuan biasanya membutuhkan waktu <strong>1-3 jam kerja</strong>.</p>
              <p>Pastikan data profil Anda sudah lengkap agar proses lebih cepat.</p>
              <p>Anda dapat melakukan permohonan peminjaman lagi setelah yang sebelumnya selesai.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="mt-8 flex gap-3 justify-center">
        <a href="{{ route('riwayat_user') }}" class="px-8 py-3 bg-[#c9a44c] text-white rounded-xl font-semibold hover:bg-[#b39340] transition shadow-lg">Lihat Riwayat Peminjaman</a>
        <a href="{{ route('buku_user') }}" class="px-8 py-3 bg-white border-2 border-[#8b6f47] text-[#8b6f47] rounded-xl font-semibold hover:bg-[#f5f1eb] transition flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Kembali ke Koleksi
        </a>
      </div>
    </main>
  </div>
</body>
</html>
