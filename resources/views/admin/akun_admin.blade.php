<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Akun (Admin)</title>

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

    .tab-card {
      position: relative;
      border-radius: 24px;
      padding: 28px 30px;
      cursor: pointer;
      transition: all .35s ease;
      opacity: .6;
      background:
        linear-gradient(160deg, rgba(255,255,255,.25), rgba(255,255,255,.08)),
        linear-gradient(160deg, #7a5c45, #5a3d2b);
      box-shadow: 0 8px 18px rgba(62,42,31,.18);
      color: #f4efe4;
      border: 1px solid rgba(255,255,255,.15);
    }

    .tab-card:hover {
      transform: translateY(-4px);
      opacity: .85;
    }

    .tab-card.active {
      opacity: 1;
      transform: translateY(-6px);
      background:
        linear-gradient(160deg, rgba(255,255,255,.18), rgba(255,255,255,.06)),
        linear-gradient(160deg, #c9a44c, #5a3d2b);
    }

    table th, table td {
      padding: 0.75rem;
      font-size: 0.85rem;
      vertical-align: top;
    }

    table th {
      letter-spacing: 0.5px;
    }

    .table-wrap {
      max-width: none;
    }

    .kategori-badge {
      border-radius: 8px;
    }

    .btn {
      padding: 8px 12px;
      border-radius: 10px;
      font-size: 0.8rem;
      font-weight: 600;
    }
  </style>

</head>

<body class="text-[#3e2a1f]">

<div class="min-h-screen flex gap-6 p-6">

  {{-- SIDEBAR --}}
  @include('admin.layout.sidebar')

  {{-- MAIN --}}
  <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    @section('page-icon')
    <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    @endsection

    @section('page-title')
    Manajemen Akun
    @endsection

    @include('admin.layout.header')

    <!-- SEARCH BAR (di bawah header, di atas tab cards) -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-5 gap-4">
      <!-- SEARCH (paling kiri) -->
      <div class="flex items-center gap-3 w-full md:w-1/2">
        <input type="text" id="searchInput" placeholder="Cari petugas..."
               class="w-full px-4 py-3 text-sm bg-white shadow border border-[#e2d3c1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c9a44c]">
        <button id="searchBtn"
                class="px-5 py-3 bg-[#c9a44c] rounded-xl hover:bg-[#b28f45] transition shadow flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <circle cx="11" cy="11" r="7" stroke-width="1.6"/>
            <path stroke-width="1.6" d="M20 20l-3-3"/>
          </svg>
        </button>
      </div>

      <!-- BUTTON UNDUH + TAMBAH (paling kanan) -->
      <div class="flex gap-3" id="actionButtons">
        <a href="{{ route('laporanpetugas_admin') }}"
           class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
            <path stroke-width="1.6" d="M4 21h16"/>
          </svg>
          Unduh Laporan
        </a>

        <a href="{{ route('admin.petugastambah_admin') }}"
           class="inline-flex items-center gap-2 px-5 py-3 bg-[#c9a44c] text-white rounded-xl font-medium shadow-lg hover:bg-[#b28f45] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 4v16m8-8H4"/>
          </svg>
          Tambah Petugas
        </a>
      </div>
    </div>

    <!-- TAB CARD -->
    <div class="grid grid-cols-2 gap-8 mb-8">
      <div onclick="showTab('petugas')" id="tab-petugas" class="tab-card active flex justify-between items-center">
        <div>
          <p class="text-sm opacity-80">Manajemen</p>
          <h3 class="text-xl font-bold">Petugas</h3>
          <p class="text-sm">({{ $petugas->count() }} data)</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"
                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
        </svg>
      </div>

      <div onclick="showTab('user')" id="tab-user" class="tab-card flex justify-between items-center">
        <div>
          <p class="text-sm opacity-80">Manajemen</p>
          <h3 class="text-xl font-bold">User</h3>
          <p class="text-sm">({{ $users->count() }} data)</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
      </div>
    </div>

    <!-- PETUGAS SECTION -->
    <div id="section-petugas" class="tab-content">

      <!-- TABLE PETUGAS -->
      <div class="table-wrapper bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg">
        <div style="overflow-x: auto;">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-[#e7dcc8] to-[#d9cbbe]">
              <tr>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Nama</th>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Username</th>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Email</th>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Password</th>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Tanggal Dibuat</th>
                <th class="text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Foto Profil</th>
                <th class="text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Jenis Kelamin</th>
                <th class="text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @php $no = 1; @endphp
              @foreach($petugas as $p)
              <tr class="hover:bg-[#faf6ee] transition-colors duration-200">
                <td class="text-sm font-medium text-[#3e2a1f]">{{ $no++ }}</td>
                <td class="text-sm font-medium text-[#3e2a1f]">{{ $p->nama }}</td>
                <td class="text-sm font-medium text-[#3e2a1f]">{{ $p->username }}</td>
                <td class="text-sm text-[#555]">{{ $p->email }}</td>
                <td class="text-sm text-[#555]">{{ $p->password_plain }}</td>
                <td class="text-sm font-medium text-[#3e2a1f]">{{ \Carbon\Carbon::parse($p->tanggal_dibuat)->format('d M Y') }}</td>
                <td class="text-center">
                  @if($p->foto_profil)
                    <img src="{{ asset('storage/' . $p->foto_profil) }}"
                         class="w-10 h-10 mx-auto rounded-full object-cover">
                  @else
                    <span class="text-gray-400 text-sm">-</span>
                  @endif
                </td>
                <td class="text-center">
                  <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                    {{ $p->jenis_kelamin }}
                  </span>
                </td>
                <td class="text-center space-x-2">
                  <a href="{{ route('admin.petugas.edit', $p->id) }}"
                     class="btn-edit inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 ease-in-out border-2 border-yellow-500 hover:border-yellow-600 cursor-pointer backface-visibility-hidden">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487a2.1 2.1 0 013.651 1.486L9.1 16.386 4 18l1.614-5.1L16.862 3.487z"/>
                    </svg>
                    Edit
                  </a>
                  <form action="{{ route('admin.petugas.delete', $p->id) }}"
                        method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                      class="btn-delete inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-red-600 hover:to-red-700 transition-all duration-300 ease-in-out border-2 border-red-500 hover:border-red-600 cursor-pointer backface-visibility-hidden"
                      onclick="return confirm('Yakin ingin hapus petugas ini?')">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-3h4m-4 0a1 1 0 00-1 1v1h6V5a1 1 0 00-1-1m-4 0h4"/>
                      </svg>
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- USER SECTION -->
    <div id="section-user" class="tab-content hidden">
      <!-- TABLE USER -->
      <div class="table-wrapper bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg">
        <div style="overflow-x: auto;">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-[#e7dcc8] to-[#d9cbbe]">
              <tr>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No</th>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Username</th>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Email</th>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">No Anggota</th>
                <th class="text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Poin</th>
                <th class="text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Status</th>
                <th class="text-left text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Tanggal Bergabung</th>
                <th class="text-center text-xs text-[#6b5a4a] font-semibold uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @php $no = 1; @endphp
              @foreach($users as $u)
              <tr class="hover:bg-[#faf6ee] transition-colors duration-200">
                <td class="text-sm font-medium text-[#3e2a1f]">{{ $no++ }}</td>
                <td class="text-sm font-medium text-[#3e2a1f]">{{ $u->username }}</td>
                <td class="text-sm text-[#555]">{{ $u->email }}</td>
                <td class="text-sm text-[#555]">{{ $u->no_anggota }}</td>
                <!-- POIN -->
                <td class="text-center">
                  <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                    {{ $u->poin }}
                  </span>
                </td>
                <!-- STATUS -->
                <td class="text-center">
                  <span class="px-3 py-1 rounded-full text-xs font-medium
                        {{ $u->status === 'diblokir' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                    {{ ucfirst($u->status) }}
                  </span>
                </td>
                <td class="text-sm font-medium text-[#3e2a1f]">{{ \Carbon\Carbon::parse($u->tanggal_bergabung)->format('d M Y') }}</td>
                <!-- AKSI -->
                <td class="text-center space-x-2">
                @if($u->poin > 100 && $u->status !== 'diblokir')
                  <form action="{{ route('admin.user.blokir', $u->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="button"
                      class="btn-blokir inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:from-red-600 hover:to-red-700 transition-all duration-300 ease-in-out border-2 border-red-500 hover:border-red-600 cursor-pointer backface-visibility-hidden"
                      onclick="return confirm('Blokir user ini?')">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                      </svg>
                      Blokir
                    </button>
                  </form>
                @else
                  <span class="text-gray-400 text-sm">-</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
          </table>
        </div>
      </div>
    </div>

  </main>
</div>

<script>
  // TAB SWITCHING
  function showTab(tab) {
    // Hide all sections
    document.querySelectorAll('.tab-content').forEach(section => {
      section.classList.add('hidden');
    });

    // Remove active class from all tabs
    document.querySelectorAll('.tab-card').forEach(card => {
      card.classList.remove('active');
    });

    // Show selected section and activate tab
    document.getElementById('section-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.add('active');

    // Update search bar and action buttons based on active tab
    const searchInput = document.getElementById('searchInput');
    const actionButtons = document.getElementById('actionButtons');

    if (tab === 'petugas') {
      searchInput.placeholder = 'Cari petugas...';
      actionButtons.innerHTML = `
        <a href="{{ route('laporanpetugas_admin') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
            <path stroke-width="1.6" d="M4 21h16"/>
          </svg>
          Unduh Laporan
        </a>
        <a href="{{ route('admin.petugastambah_admin') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 4v16m8-8H4"/>
          </svg>
          Tambah Petugas
        </a>
      `;
    } else if (tab === 'user') {
      searchInput.placeholder = 'Cari user...';
      actionButtons.innerHTML = `
        <a href="{{ route('admin.laporan.user') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
            <path stroke-width="1.6" d="M4 21h16"/>
          </svg>
          Unduh Laporan
        </a>
      `;
    }
  }

  // SEARCH FUNCTIONALITY
  const searchInput = document.getElementById('searchInput');
  const searchBtn = document.getElementById('searchBtn');

  function filterData() {
    const query = searchInput.value.toLowerCase().trim();
    if (query === '') return alert('Masukkan kata kunci pencarian!');

    // Get active tab
    const activeTab = document.querySelector('.tab-card.active');
    const tabType = activeTab ? activeTab.id.replace('tab-', '') : 'petugas';

    // Filter rows based on active tab
    const sectionId = 'section-' + tabType;
    const rows = document.querySelectorAll('#' + sectionId + ' tbody tr');
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(query) ? '' : 'none';
    });
  }

  searchBtn.addEventListener('click', filterData);
  searchInput.addEventListener('keypress', e => {
    if (e.key === 'Enter') filterData();
  });

  // Initialize default tab (petugas)
  showTab('petugas');
</script>

</body>
</html>
