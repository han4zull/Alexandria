<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen User (Admin)</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at top, #f6f1ea, #e2d3c1);
    }
    .judul { font-family: 'Poppins', sans-serif }
    table th, table td {
      padding: .75rem;
      font-size: .85rem;
      vertical-align: middle;
    }
    .table-wrap {
      max-width: 1200px;
      margin: 0 auto;
    }
  </style>
</head>

<body class="text-[#3e2a1f]">

<div class="min-h-screen flex gap-6 p-6">

  {{-- SIDEBAR --}}
  @include('admin.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    <h2 class="judul text-3xl mb-2">Manajemen User</h2>
    <p class="text-sm text-[#7a5c45] mb-8">
      Kelola user, unduh laporan, dan blokir jika poin melebihi batas
    </p>

    <!-- SEARCH + UNDUH -->
    <div class="flex justify-between items-center mb-5">
      <!-- SEARCH -->
      <div class="flex items-center gap-3">
        <input type="text" id="searchInput" placeholder="Cari user..."
               class="w-96 px-4 py-3 text-sm bg-white shadow border border-[#e2d3c1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c9a44c]">
        <button id="searchBtn"
                class="px-5 py-3 bg-[#c9a44c] rounded-xl hover:bg-[#b28f45] transition shadow">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <circle cx="11" cy="11" r="7" stroke-width="1.6"/>
            <path stroke-width="1.6" d="M20 20l-3-3"/>
          </svg>
        </button>
      </div>

      <!-- UNDUH LAPORAN -->
      <a href="{{ route('admin.laporan.user') }}"
         class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
          <path stroke-width="1.6" d="M4 21h16"/>
        </svg>
        Unduh Laporan
      </a>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto rounded-2xl shadow table-wrap">
      <table class="min-w-full bg-white">
        <thead class="bg-[#e7dcc8] text-sm font-semibold">
          <tr>
            <th>No</th>
            <th>Foto Profil</th>
            <th>Username</th>
            <th>Email</th>
            <th>No Anggota</th>
            <th>Poin</th>
            <th>Status</th>
            <th>Tanggal Bergabung</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>

        <tbody>
          @foreach($users as $u)
          <tr class="border-b hover:bg-[#faf6ee] transition">
            <td>{{ $loop->iteration }}</td>
            <td class="text-center">
              @if($u->foto_profil)
                <img src="{{ asset('storage/' . $u->foto_profil) }}"
                     class="w-12 h-12 rounded-full object-cover mx-auto shadow-md border-2 border-[#c9a44c]">
              @else
                <div class="w-12 h-12 rounded-full bg-[#b08b33] text-white flex items-center justify-center font-semibold mx-auto shadow-md border-2 border-[#c9a44c]">
                  {{ strtoupper(substr($u->nama_lengkap ?? $u->username, 0, 1)) }}
                </div>
              @endif
            </td>
            <td>{{ $u->username }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->no_anggota }}</td>

            <!-- POIN -->
            <td class="font-semibold {{ $u->poin > 100 ? 'text-red-600' : '' }}">
              {{ $u->poin }}
            </td>

            <!-- STATUS -->
            <td>
              <span class="px-3 py-1 rounded-full text-xs font-medium
                {{ $u->status === 'diblokir' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                {{ ucfirst($u->status) }}
              </span>
            </td>

            <td>{{ \Carbon\Carbon::parse($u->tanggal_bergabung)->format('d M Y') }}</td>

            <!-- AKSI -->
            <td class="text-center">
              @if($u->poin > 100 && $u->status !== 'diblokir')
                <form action="{{ route('admin.user.blokir', $u->id) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <button
                    onclick="return confirm('Blokir user ini?')"
                    class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-xs">
                    Blokir
                  </button>
                </form>
              @else
                <span class="text-xs text-gray-400">–</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </main>
</div>

<script>
  const searchInput = document.getElementById('searchInput');
  const searchBtn = document.getElementById('searchBtn');

  function filterTable() {
    const query = searchInput.value.toLowerCase().trim();
    if (!query) return;

    document.querySelectorAll('tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
    });
  }

  searchBtn.onclick = filterTable;
  searchInput.addEventListener('keypress', e => {
    if (e.key === 'Enter') filterTable();
  });
</script>

</body>
</html>