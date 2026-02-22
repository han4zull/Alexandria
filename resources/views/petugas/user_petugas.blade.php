<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data User - Petugas</title>

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

    table th, table td {
      padding: 0.75rem;
      font-size: 0.85rem;
      vertical-align: top;
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
  @include('petugas.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    @section('page-icon')
    <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
    </svg>
    @endsection

    @section('page-title')
    Data User
    @endsection

    @include('petugas.layout.header')

    <!-- SEARCH + UNDUH LAPORAN -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-5 gap-4">

      <!-- INPUT SEARCH -->
      <div class="flex items-center gap-3 w-full md:w-1/2">
        <input type="text" id="searchInput" placeholder="Cari username, email, no anggota, poin, atau status..."
               class="w-full px-4 py-3 text-sm bg-white shadow border border-[#e2d3c1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c9a44c]">
        <button id="searchBtn"
                class="px-5 py-3 bg-[#c9a44c] rounded-xl hover:bg-[#b28f45] transition shadow flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <circle cx="11" cy="11" r="7" stroke-width="1.6"/>
            <path stroke-width="1.6" d="M20 20l-3-3"/>
          </svg>
        </button>
      </div>

      <!-- BUTTONS -->
      <div class="flex gap-3">
        <button onclick="unduhLaporanUser()"
           class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
            <path stroke-width="1.6" d="M4 21h16"/>
          </svg>
          Unduh Laporan
        </button>
      </div>

    </div>

    <!-- TABEL USER -->
    <div class="overflow-x-auto rounded-2xl shadow table-wrap">
      <table class="min-w-full bg-white">
        <thead class="bg-[#e7dcc8]">
          <tr>
            <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
            <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Username</th>
            <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Email</th>
            <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No Anggota</th>
            <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Tanggal Bergabung</th>
            <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Poin</th>
            <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">status</th>
            <th class="px-4 py-3 text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Foto Profil</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
          @foreach($user as $index => $u)
          <tr class="border-b hover:bg-[#faf6ee]/60 transition-colors duration-200">
            <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] whitespace-nowrap">{{ $index + 1 }}</td>
            <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $u->username }}</td>
            <td class="px-4 py-3 text-sm text-[#555]">{{ $u->email }}</td>
            <td class="px-4 py-3 text-sm text-[#555]">{{ $u->no_anggota }}</td>
            <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f] whitespace-nowrap">{{ $u->tanggal_bergabung ? \Carbon\Carbon::parse($u->tanggal_bergabung)->format('d/m/Y') : '-' }}</td>
            <td class="px-4 py-3 text-sm font-medium text-[#3e2a1f]">{{ $u->poin ?? 0 }}</td>
            <td class="px-4 py-3 text-sm">
              @php
                $status = ($u->poin > 100) ? 'DIBLOKIR' : 'AKTIF';
              @endphp
              <span class="px-2 py-1 text-xs font-medium rounded-full 
                @if($status == 'DIBLOKIR') bg-red-100 text-red-800
                @else bg-green-100 text-green-800 @endif">
                {{ $status }}
              </span>
            </td>

            <td class="px-4 py-3 text-sm">
              @if($u->foto_profil)
                <img src="{{ asset('storage/' . $u->foto_profil) }}"
                     alt="Foto Profil"
                     class="w-10 h-10 rounded-full object-cover border">
              @else
                <span class="text-gray-400 italic">Tidak ada foto</span>
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
// SEARCH FUNCTIONALITY
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const username = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        const noAnggota = row.cells[3].textContent.toLowerCase();
        const poin = row.cells[5].textContent.toLowerCase();
        const status = row.cells[6].textContent.toLowerCase();

        if (username.includes(searchTerm) || email.includes(searchTerm) || 
            noAnggota.includes(searchTerm) || poin.includes(searchTerm) || 
            status.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

document.getElementById('searchBtn').addEventListener('click', function() {
    const searchInput = document.getElementById('searchInput');
    searchInput.focus();
});

// UNDUH LAPORAN FUNCTION
function unduhLaporanUser() {
    // Redirect to user report page
    window.location.href = '/petugas/laporan/user';
}
</script>

</body>
</html>