
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Petugas</title>

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

    .judul {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      letter-spacing: 0.02em;
    }

    .card {
      border-radius: 24px;
      padding: 24px;
      background: #ffffff;
      box-shadow: 0 18px 40px rgba(0,0,0,0.12);
      overflow: hidden;
      position: relative;
    }

    .card::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(201,164,76,0.10), rgba(138,106,63,0.05));
      pointer-events: none;
    }

    .badge {
      font-size: 0.75rem;
      padding: 6px 10px;
      border-radius: 999px;
      background: #e7dcc8;
      color: #3e2a1f;
      font-weight: 600;
    }

    .label {
      font-size: 0.75rem;
      opacity: 0.75;
    }

    .value {
      font-weight: 700;
      font-size: 0.95rem;
      color: #3e2a1f;
    }

    .line {
      height: 1px;
      background: rgba(62,42,31,0.18);
      margin: 10px 0;
    }

    .icon {
      width: 26px;
      height: 26px;
    }
  </style>
</head>

<body class="text-[#3e2a1f]">

<div class="min-h-screen flex gap-6 p-6">

  <!-- SIDEBAR -->
  @include('petugas.layout.sidebar')

  <!-- MAIN CONTENT -->
  <main class="flex-1 bg-[#faf6ee] rounded-3xl p-8 shadow-md">

    @section('page-icon')
    <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    @endsection

    @section('page-title')
    Profile Petugas
    @endsection

    @include('petugas.layout.header')

    <!-- PROFILE CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <!-- PHOTO CARD -->
      <div class="card">
        <div class="flex flex-col items-center relative">
          @if($petugas->foto_profil)
            <img src="{{ asset('storage/'.$petugas->foto_profil) }}"
                 alt="Foto Profil"
                 class="w-32 h-32 rounded-full object-cover border-4 border-[#e7dcc8] shadow-lg">
          @else
            {{-- Inisial dari nama --}}
            @php
              $name = $petugas->nama;
              $words = explode(' ', trim($name));

              $initial = '';
              foreach ($words as $word) {
                if (strlen($initial) < 2) {
                  $initial .= strtoupper(substr($word, 0, 1));
                }
              }
            @endphp

            <div class="w-32 h-32 rounded-full border-4 border-[#e7dcc8] shadow-lg
                        flex items-center justify-center text-4xl font-bold bg-[#c9a44c] text-white">
              {{ $initial }}
            </div>
          @endif

          <div class="mt-4 text-center">
            <div class="text-2xl font-bold">{{ $petugas->nama }}</div>
            <div class="text-sm text-[#7a5c45] mt-1">{{ $petugas->email }}</div>
          </div>

          <div class="mt-3 flex gap-2">
            <span class="badge">{{ ucfirst($petugas->role) }}</span>
            <span class="badge">Aktif</span>
          </div>

          <div class="line"></div>

          <div class="text-xs text-[#7a5c45]">
            “Petugas yang menjaga semua sistem tetap rapi.”
          </div>
        </div>
      </div>

      <!-- INFO DETAIL -->
      <div class="card lg:col-span-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <div class="space-y-2">
            <div class="label">ID Petugas</div>
            <div class="value">{{ $petugas->id }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Tanggal Dibuat</div>
            <div class="value">{{ \Carbon\Carbon::parse($petugas->tanggal_dibuat)->format('d M Y') }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Jenis Kelamin</div>
            <div class="value">{{ $petugas->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Email</div>
            <div class="value">{{ $petugas->email }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Password (Plain)</div>
            <div class="value font-mono">{{ $petugas->password_plain }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Status Akun</div>
            <div class="value">
              <span class="badge bg-[#b08b33] text-white">
                Aktif
              </span>
            </div>
          </div>

        </div>

        <div class="line"></div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="p-4 bg-[#faf6ee] rounded-xl">
            <div class="label">Role</div>
            <div class="value">{{ ucfirst($petugas->role) }}</div>
          </div>
          <div class="p-4 bg-[#faf6ee] rounded-xl">
            <div class="label">Akses</div>
            <div class="value">Full</div>
          </div>
          <div class="p-4 bg-[#faf6ee] rounded-xl">
            <div class="label">Keamanan</div>
            <div class="value">Terkunci</div>
          </div>
        </div>

        <div class="mt-6 flex gap-3">
          <a href="{{ route('br_petugas') }}"
             class="inline-flex items-center gap-2 px-5 py-3 bg-gray-300 text-gray-700
                    rounded-xl font-medium hover:bg-gray-400 transition">
            ← Kembali
          </a>

          <a href="{{ route('petugas_edit', $petugas->id) }}"
             class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f]
                    text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-width="1.6" d="M12 20h9" />
              <path stroke-width="1.6" d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
            </svg>
            Edit Profil
          </a>
        </div>

      </div>

    </div>

  </main>
</div>

</body>
</html>