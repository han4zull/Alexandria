<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Konfirmasi Pinjam | Alexandria Library</title>
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
    @keyframes bounceIn {
      0% { opacity: 0; transform: scale(0.3); }
      50% { opacity: 1; }
      100% { transform: scale(1); }
    }
    @keyframes pulse-ring {
      0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
      70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
      100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    
    .animate-slide-in { animation: slideInDown 0.6s ease-out; }
    .animate-bounce-in { animation: bounceIn 0.6s ease-out; }
    .animate-pulse-ring { animation: pulse-ring 2s infinite; }
    
    .success-checkmark {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #22c55e, #16a34a);
      border-radius: 50%;
      color: white;
      font-size: 32px;
      animation: bounceIn 0.6s ease-out;
    }
    
    /* Receipt Styles */
    .receipt {
      width: 320px;
      margin: 0 auto;
      background: white;
      padding: 20px;
      font-family: 'Courier New', monospace;
      font-size: 12px;
      line-height: 1.6;
      color: #000;
    }
    
    .receipt-header {
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 2px dashed #000;
      padding-bottom: 10px;
    }
    
    .receipt-title {
      font-size: 16px;
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    .receipt-subtitle {
      font-size: 10px;
      color: #666;
    }
    
    .receipt-section {
      margin-bottom: 15px;
      border-bottom: 1px dashed #999;
      padding-bottom: 10px;
    }
    
    .receipt-section-title {
      font-weight: bold;
      text-align: center;
      margin-bottom: 8px;
      font-size: 11px;
    }
    
    .receipt-item {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      margin-bottom: 4px;
    }
    
    .receipt-item-label {
      font-weight: bold;
    }
    
    .receipt-code {
      text-align: center;
      font-weight: bold;
      font-size: 14px;
      margin: 10px 0;
      font-family: 'Courier New', monospace;
      letter-spacing: 2px;
    }
    
    .receipt-qr {
      text-align: center;
      margin: 10px 0;
    }
    
    .receipt-qr img {
      width: 150px;
      height: 150px;
    }
    
    .receipt-footer {
      text-align: center;
      font-size: 10px;
      color: #666;
      margin-top: 15px;
    }
    
    .receipt-dashed {
      text-align: center;
      margin: 10px 0;
      line-height: 1;
      font-size: 10px;
      letter-spacing: 1px;
    }
    
    /* Print Styles */
    @media print {
      * {
        margin: 0;
        padding: 0;
      }
      
      body {
        background: white;
        padding: 0;
      }
      
      .no-print {
        display: none !important;
      }
      
      .print-only {
        display: block !important;
      }
      
      main {
        padding: 0;
        width: 100%;
      }
      
      main > *:not(.receipt-container) {
        display: none !important;
      }
      
      .receipt-container {
        width: 100%;
        padding: 0;
        margin: 0;
      }
      
      .receipt {
        width: 100%;
        max-width: 320px;
        margin: 0 auto;
        padding: 0;
        box-shadow: none;
        page-break-after: always;
      }
      
      a {
        text-decoration: none;
      }
      
      .glass {
        background: white;
        border: none;
        box-shadow: none;
      }
    }
    
    .receipt-container {
      display: none;
    }
    
    .print-only {
      display: none;
    }
  </style>
</head>
<body class="text-[#3e2a1f]">
  <div class="min-h-screen flex gap-6 p-6">
    <div class="no-print">
      @include('user.layout.sidebar')
    </div>

    <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

      {{-- TOP BAR --}}
      <div class="flex items-center justify-between mb-8">
        <h1 class="judul text-3xl font-black text-[#8b6f47] flex items-center gap-2">
          <svg class="w-6 h-6 text-[#8b6f47]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Konfirmasi Peminjaman
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
      <!-- Celebratory Header -->
      <div class="mb-6 animate-slide-in">
        <div class="glass rounded-3xl p-8 shadow-xl text-center border-2 border-green-200 relative">
          <button onclick="window.print()" class="no-print absolute top-4 right-4 px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
            Cetak Bukti
          </button>
          <div class="flex justify-center mb-4">
            <div class="success-checkmark">
              <svg class="w-6 h-6" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 10l2 2 6-6" stroke="white" />
              </svg>
            </div>
          </div>
          <h1 class="judul text-3xl font-bold text-green-700 mb-2">Peminjaman Berhasil!</h1>
          <p class="text-[#6b5a4a]">Buku telah ditambahkan ke daftar peminjaman Anda</p>
        </div>
      </div>

      <!-- Main Content -->
      <div class="grid grid-cols-3 gap-6">
        <!-- Left: Book Details -->
        <div class="col-span-2">
          <div class="glass rounded-3xl p-8 shadow-xl">
            <h2 class="judul text-2xl font-bold mb-6 text-[#8b6f47]">Detail Peminjaman</h2>

            <div class="flex gap-6 mb-8">
              <!-- Book Cover -->
              <div class="w-48 flex-shrink-0">
                @if($buku->cover)
                  <img src="{{ asset('storage/'.$buku->cover) }}" alt="{{ $buku->judul }}" class="w-full aspect-[2/3] object-cover rounded-xl shadow-lg hover:shadow-2xl transition">
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
                <p class="text-[#6b5a4a] mb-4">{{ $buku->penulis ?? '-' }}</p>

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
                  <p class="text-xs text-blue-600 uppercase tracking-wider">Kode Peminjaman</p>
                  <p class="font-mono text-2xl font-bold text-blue-700 mt-1">{{ $peminjaman->kode_pinjam ?? 'N/A' }}</p>
                  <p class="text-xs text-blue-600 mt-2">Simpan atau screenshot untuk verifikasi di perpustakaan</p>
                </div>
              </div>
            </div>

            <!-- Instructions -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-lg">
              <h4 class="font-semibold text-amber-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                Langkah Selanjutnya:
              </h4>
              <ol class="space-y-2 text-sm text-amber-800">
                <li><strong>1.</strong> Kunjungi perpustakaan Alexandria</li>
                <li><strong>2.</strong> Tunjukkan kode peminjaman atau QR code kepada petugas</li>
                <li><strong>3.</strong> Petugas akan memproses peminjaman Anda</li>
                <li><strong>4.</strong> Ambil buku dan jangan lupa kembalikan tepat waktu!</li>
              </ol>
            </div>
          </div>
        </div>

        <!-- Right: QR Code & Penalties -->
        <div class="space-y-6">
          <!-- QR Code Box -->
          <div class="glass rounded-3xl p-6 shadow-xl text-center animate-bounce-in">
            <h3 class="judul font-bold text-[#8b6f47] mb-4">QR Code Verifikasi</h3>
            <div class="bg-white rounded-xl p-4 mb-4 animate-pulse-ring inline-block w-full">
              <img src="{{ $qrImageUrl }}" alt="QR Code" class="w-full h-auto">
            </div>
            <p class="text-xs text-[#6b5a4a]">Tunjukkan QR ini kepada petugas perpustakaan</p>
            <p class="text-xs text-gray-500 mt-2">atau gunakan kode: <span class="font-mono font-semibold">{{ $peminjaman->kode_pinjam }}</span></p>
          </div>

          <!-- Penalties Info -->
          <div class="glass rounded-3xl p-6 shadow-xl">
            <h3 class="judul font-bold text-[#8b6f47] mb-4 flex items-center gap-2">
              <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
              Daftar Denda
            </h3>
            <div class="space-y-3">
              <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                <span class="text-sm font-medium text-red-900">Terlambat (per hari)</span>
                <span class="font-bold text-red-700">Rp{{ number_format($fees['telat_per_hari'],0,',','.') }}</span>
              </div>
              <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg">
                <span class="text-sm font-medium text-orange-900">Rusak</span>
                <span class="font-bold text-orange-700">Rp{{ number_format($fees['rusak'],0,',','.') }}</span>
              </div>
              <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg">
                <span class="text-sm font-medium text-yellow-900">Hilang</span>
                <span class="font-bold text-yellow-700">Rp{{ number_format($fees['hilang'],0,',','.') }}</span>
              </div>
            </div>
            <p class="text-xs text-[#6b5a4a] mt-4 p-3 bg-white rounded border-l-2 border-amber-400">
              <svg class="inline w-4 h-4 mr-2 align-middle text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 3a9 9 0 11-9 9 9 9 0 019-9z"></path>
              </svg>
              Pastikan buku dalam kondisi baik dan kembalikan sebelum tanggal batas agar tidak ada denda tambahan.
            </p>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="mt-8 flex gap-3 justify-center no-print">
        <a href="{{ route('buku_user') }}" class="px-8 py-3 bg-[#c9a44c] text-white rounded-xl font-semibold hover:bg-[#b39340] transition shadow-lg flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Kembali ke Koleksi
        </a>
        <a href="{{ route('riwayat_user') }}" class="px-8 py-3 bg-white border-2 border-[#8b6f47] text-[#8b6f47] rounded-xl font-semibold hover:bg-[#f5f1eb] transition">Lihat Riwayat Peminjaman</a>
      </div>
      
      <!-- Receipt (Hidden until print) -->
      <div class="receipt-container print-only">
        <div class="receipt">
          <!-- Header -->
          <div class="receipt-header">
            <div class="receipt-title">ALEXANDRIA LIBRARY</div>
            <div class="receipt-subtitle">Perpustakaan Digital Terpercaya</div>
          </div>
          
          <!-- Booking Code -->
          <div class="receipt-code">
            {{ $peminjaman->kode_pinjam ?? 'N/A' }}
          </div>
          
          <div class="receipt-dashed">------- BUKTI PEMINJAMAN -------</div>
          
          <!-- Book Info -->
          <div class="receipt-section">
            <div class="receipt-item">
              <span class="receipt-item-label">Judul:</span>
              <span style="text-align: right; flex: 1;">{{ substr($buku->judul, 0, 20) }}</span>
            </div>
            <div class="receipt-item">
              <span class="receipt-item-label">Penulis:</span>
              <span style="text-align: right; flex: 1;">{{ substr($buku->penulis ?? '-', 0, 15) }}</span>
            </div>
            <div class="receipt-item">
              <span class="receipt-item-label">ID Buku:</span>
              <span style="text-align: right;">{{ $buku->id }}</span>
            </div>
          </div>
          
          <!-- Member Info -->
          <div class="receipt-section">
            <div class="receipt-section-title">DATA PEMINJAM</div>
            <div class="receipt-item">
              <span class="receipt-item-label">Nama:</span>
              <span style="text-align: right; flex: 1;">{{ substr($user->nama_lengkap ?? '-', 0, 18) }}</span>
            </div>
            <div class="receipt-item">
              <span class="receipt-item-label">No. Anggota:</span>
              <span style="text-align: right;">{{ $user->no_anggota ?? '-' }}</span>
            </div>
            <div class="receipt-item">
              <span class="receipt-item-label">No. HP:</span>
              <span style="text-align: right;">{{ substr($user->nomer_hp ?? '-', 0, 12) }}</span>
            </div>
          </div>
          
          <!-- Dates -->
          <div class="receipt-section">
            <div class="receipt-section-title">PERIODE PEMINJAMAN</div>
            <div class="receipt-item">
              <span class="receipt-item-label">Tgl. Pinjam:</span>
              <span style="text-align: right;">{{ $tanggal_pinjam->format('d/m/Y') }}</span>
            </div>
            <div class="receipt-item">
              <span class="receipt-item-label">Tgl. Kembali:</span>
              <span style="text-align: right;">{{ $tanggal_kembali->format('d/m/Y') }}</span>
            </div>
            <div class="receipt-item">
              <span class="receipt-item-label">Durasi:</span>
              <span style="text-align: right;">7 Hari</span>
            </div>
          </div>
          
          <!-- QR Code -->
          <div class="receipt-qr">
            <img src="{{ $qrImageUrl }}" alt="QR Code">
          </div>
          
          <!-- Penalties -->
          <div class="receipt-section">
            <div class="receipt-section-title">DENDA</div>
            <div class="receipt-item" style="font-size: 10px;">
              <span>Telat/hari:</span>
              <span>Rp{{ number_format($fees['telat_per_hari'],0,',','.') }}</span>
            </div>
            <div class="receipt-item" style="font-size: 10px;">
              <span>Rusak:</span>
              <span>Rp{{ number_format($fees['rusak'],0,',','.') }}</span>
            </div>
            <div class="receipt-item" style="font-size: 10px;">
              <span>Hilang:</span>
              <span>Rp{{ number_format($fees['hilang'],0,',','.') }}</span>
            </div>
          </div>
          
          <!-- Footer -->
          <div class="receipt-footer">
            <div style="margin-bottom: 8px;">Terima kasih telah meminjam!</div>
            <div style="font-size: 9px; letter-spacing: 1px;">~~~~~~~~~~~~~~~~</div>
            <div style="font-size: 9px;">Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>