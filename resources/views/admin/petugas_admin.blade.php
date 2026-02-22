<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Petugas (Admin)</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at top, #f6f1ea, #e2d3c1);
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
  @include('admin.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    <h2 class="judul text-3xl mb-2">Manajemen Petugas</h2>
    <p class="text-sm text-[#7a5c45] mb-8">
        Tambah, edit, dan hapus data petugas
    </p>

    <!-- SEARCH + UNDUH + TAMBAH -->
    <div class="flex justify-between items-center mb-5">
      <!-- SEARCH (paling kiri) -->
      <div class="flex items-center gap-3">
        <input type="text" id="searchInput" placeholder="Cari petugas..."
               class="w-96 px-4 py-3 text-sm bg-white shadow border border-[#e2d3c1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c9a44c]">
        <button id="searchBtn"
                class="px-5 py-3 bg-[#c9a44c] rounded-xl hover:bg-[#b28f45] transition shadow">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <circle cx="11" cy="11" r="7" stroke-width="1.6"/>
            <path stroke-width="1.6" d="M20 20l-3-3"/>
          </svg>
        </button>
      </div>

      <!-- BUTTON UNDUH + TAMBAH (paling kanan) -->
      <div class="flex items-center gap-3">
        <a href="{{ route('laporanpetugas_admin') }}"
           class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
            <path stroke-width="1.6" d="M4 21h16"/>
          </svg>
          Unduh Laporan
        </a>

        <a href="{{ route('admin.petugastambah_admin') }}"
           class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 4v16m8-8H4"/>
          </svg>
          Tambah Petugas
        </a>
      </div>
    </div>
    

    <!-- TABLE -->
    <div class="overflow-x-auto rounded-2xl shadow table-wrap">
      <table class="min-w-full bg-white">
        <thead class="bg-[#e7dcc8] text-sm font-semibold">
          <tr>
<th class="text-left align-middle">No</th>
<th class="text-left align-middle">Nama</th>
<th class ="text-left align-middle">Username</th>
<th class="text-left align-middle">Email</th>
<th class="text-left align-middle">Password</th>
<th class="text-left align-middle">Tanggal Dibuat</th>
<th class="text-center align-middle">Foto Profil</th>
<th class="text-center align-middle">Jenis Kelamin</th>
<th class="text-center align-middle">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($petugas as $p)
          <tr class="border-b hover:bg-[#faf6ee] transition">
<td class="align-middle">{{ $loop->iteration }}</td>
<td class="align-middle">{{ $p->nama }}</td>
<td class="align-middle">{{ $p->username }}</td>
<td class="align-middle">{{ $p->email }}</td>
<td class="align-middle">{{ $p->password_plain }}</td>
<td class="align-middle">
  {{ \Carbon\Carbon::parse($p->tanggal_dibuat)->format('d M Y') }}
</td>
<td class="align-middle text-center">
  @if($p->foto_profil)
    <img src="{{ asset('storage/' . $p->foto_profil) }}"
         class="w-10 h-10 mx-auto rounded-full object-cover">
  @else
    <span class="text-xs text-gray-500">–</span>
  @endif
</td>
<td class="align-middle text-center">{{ $p->jenis_kelamin }}</td>

             <td class="align-middle text-center">
  <div class="flex justify-center gap-2">

    <!-- EDIT -->
    <a href="{{ route('admin.petugas.edit', $p->id) }}"
       class="inline-flex items-center justify-center w-8 h-8
              bg-[#c9a44c] text-white rounded-lg
              hover:bg-[#b28f45] transition"
       title="Edit">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
           fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-width="1.8"
              d="M16.862 3.487a2.1 2.1 0 013.651 1.486
                 L9.1 16.386 4 18l1.614-5.1
                 L16.862 3.487z"/>
      </svg>
    </a>

    <!-- DELETE -->
    <form action="{{ route('admin.petugas.delete', $p->id) }}"
          method="POST">
      @csrf
      @method('DELETE')
      <button
        class="inline-flex items-center justify-center w-8 h-8
               bg-red-600 text-white rounded-lg
               hover:bg-red-700 transition"
        onclick="return confirm('Yakin ingin hapus petugas ini?')"
        title="Hapus">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="1.8"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                   a2 2 0 01-1.995-1.858L5 7
                   m5-3h4m-4 0a1 1 0 00-1 1v1
                   h6V5a1 1 0 00-1-1m-4 0h4"/>
        </svg>
      </button>
    </form>

  </div>
</td>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </main>
</div>

<script>
  // SEARCH
  const searchInput = document.getElementById('searchInput');
  const searchBtn = document.getElementById('searchBtn');

  function filterTable() {
    const query = searchInput.value.toLowerCase().trim();
    if(query === '') return alert('Masukkan kata kunci pencarian!');

    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(query) ? '' : 'none';
    });
  }

  searchBtn.addEventListener('click', filterTable);
  searchInput.addEventListener('keypress', e => {
    if(e.key === 'Enter') filterTable();
  });
</script>

</body>
</html>