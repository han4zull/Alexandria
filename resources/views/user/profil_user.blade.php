<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>

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
  @include('user.layout.sidebar')

  <!-- MAIN CONTENT -->
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    <div class="flex items-center justify-between mb-8">
      <h1 class="judul text-3xl font-black text-[#8b6f47] flex items-center gap-2">
        <svg class="w-6 h-6 text-[#8b6f47]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19a4 4 0 00-6 0M12 12a4 4 0 100-8 4 4 0 000 8z"/>
        </svg>
        Profil Pengguna
      </h1>

      <!-- PROFILE DI KANAN ATAS -->
      <div class="flex items-center gap-3">
        <div class="text-right">
          <div class="text-xs text-[#6b5a4a]">Hai,</div>
          <div class="text-sm font-semibold">{{ Auth::user()->username ?? Auth::user()->name ?? 'User' }}</div>
        </div>
        @if(Auth::user()->foto_profil)
          <img src="{{ asset('storage/'.Auth::user()->foto_profil) }}"
               class="w-12 h-12 rounded-full object-cover shadow-lg border-2 border-[#c9a44c]">
        @else
          <div class="w-12 h-12 rounded-full bg-[#b08b33] text-white
                      flex items-center justify-center font-semibold shadow-lg border-2 border-[#c9a44c]">
            {{ strtoupper(substr(Auth::user()->email ?? 'U', 0, 1)) }}
          </div>
        @endif
      </div>
    </div>

    @if(session('error'))
      <div class="mb-4 p-3 rounded bg-red-50 border-l-4 border-red-400 text-red-700">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-50 border-l-4 border-green-400 text-green-700">{{ session('success') }}</div>
    @endif

    <!-- PROFILE CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <!-- PHOTO CARD -->
      <div class="card">
        <div class="flex flex-col items-center relative">
          @if($user->foto_profil)
            <img src="{{ asset('storage/'.$user->foto_profil) }}" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-[#e7dcc8] shadow-lg">
          @else
            @php
              $name = $user->nama ?? $user->name ?? ($user->username ?? 'U');
              $words = explode(' ', trim($name));
              $initial = '';
              foreach ($words as $word) {
                if (strlen($initial) < 2) { $initial .= strtoupper(substr($word, 0, 1)); }
              }
            @endphp

            <div class="w-32 h-32 rounded-full border-4 border-[#e7dcc8] shadow-lg flex items-center justify-center text-4xl font-bold bg-[#c9a44c] text-white">{{ $initial }}</div>
          @endif

          <div class="mt-4 text-center">
            <div class="text-2xl font-bold">{{ $user->nama ?? $user->name ?? $user->username }}</div>
            <div class="text-sm text-[#7a5c45] mt-1">{{ $user->email }}</div>
          </div>

          <div class="mt-3 flex gap-2">
            <span class="badge">{{ ucfirst($user->role ?? 'user') }}</span>
            <span class="badge">Aktif</span>
          </div>

          <div class="line"></div>

          <div class="text-xs text-[#7a5c45] text-center">
            “Akun pengguna terdaftar — kelola data pribadimu dengan aman.”
          </div>
        </div>
      </div>

      <!-- INFO DETAIL -->
      <div class="card lg:col-span-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <div class="space-y-2">
            <div class="label">Username</div>
            <div class="value">{{ $user->username ?? '-' }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Email</div>
            <div class="value">{{ $user->email ?? '-' }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Role</div>
            <div class="value">{{ ucfirst($user->role ?? '-') }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Nomor Anggota</div>
            <div class="value">{{ $user->no_anggota ?? '-' }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Tanggal Bergabung</div>
            <div class="value">{{ isset($user->tanggal_bergabung) ? \Carbon\Carbon::parse($user->tanggal_bergabung)->format('d M Y') : (isset($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->format('d M Y') : '-') }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Nama Lengkap</div>
            <div class="value">{{ $user->nama_lengkap ?? '-' }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Alamat</div>
            <div class="value">{!! nl2br(e($user->alamat ?? '-')) !!}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Nomer HP</div>
            <div class="value">{{ $user->nomer_hp ?? '-' }}</div>
          </div>

          <div class="space-y-2">
            <div class="label">Poin</div>
            <div class="value">{{ $user->poin ?? 0 }}</div>
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
            <div class="value">{{ ucfirst($user->role ?? 'user') }}</div>
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
          <a href="{{ route('br_user') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-400 transition">← Kembali</a>

          <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
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
