@extends('admin.layout.app')

@section('title', 'Laporan Petugas Aktif - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#f5f1e8] to-[#e8dcc0] p-6">
  <!-- HEADER -->
  <div class="max-w-7xl mx-auto mb-8">
    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-[#e2d3c1]">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-[#3e2a1f] mb-2">Laporan Petugas Aktif</h1>
          <p class="text-[#6b5a4a]">Daftar petugas dengan status aktif</p>
        </div>

        <!-- PROFILE DI KANAN ATAS -->
        <div class="flex items-center gap-3">
          <div class="text-right">
            <div class="text-xs text-[#6b5a4a]">Hai,</div>
            <div class="text-sm font-semibold">{{ auth('admin')->user()->nama ?? 'Admin' }}</div>
          </div>

          @if(auth('admin')->user()->foto_profil)
            <img src="{{ asset('storage/admin/'.auth('admin')->user()->foto_profil) }}"
                 class="w-12 h-12 rounded-full object-cover shadow-lg border-2 border-[#c9a44c]">
          @else
            <div class="w-12 h-12 rounded-full bg-[#b08b33] text-white
                        flex items-center justify-center font-semibold shadow-lg border-2 border-[#c9a44c]">
              {{ strtoupper(substr(auth('admin')->user()->nama ?? 'A', 0, 1)) }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- SEARCH BAR -->
  <div class="max-w-7xl mx-auto mb-6">
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-[#e2d3c1]">
      <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="flex-1 w-full md:w-auto">
          <div class="relative">
            <input type="text" id="searchInput" placeholder="Cari petugas..."
                   class="w-full pl-12 pr-4 py-3 border border-[#d4c4b5] rounded-xl focus:ring-2 focus:ring-[#c9a44c] focus:border-transparent transition">
            <svg class="absolute left-4 top-3.5 h-5 w-5 text-[#6b5a4a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </div>
        </div>

        <div class="flex gap-3">
          <a href="{{ route('admin.laporan.petugas_aktif_pdf') }}"
             class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:scale-[1.02] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Unduh PDF
          </a>

          <a href="{{ route('laporanpetugas_admin') }}"
             class="inline-flex items-center gap-2 bg-[#c9a44c] hover:bg-[#b28f45] text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:scale-[1.02] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- TABLE -->
  <div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-[#e2d3c1]">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-[#f5f1e8] border-b border-[#e2d3c1]">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold text-[#3e2a1f] uppercase tracking-wider">No</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-[#3e2a1f] uppercase tracking-wider">NIP</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-[#3e2a1f] uppercase tracking-wider">Nama Petugas</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-[#3e2a1f] uppercase tracking-wider">Email</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-[#3e2a1f] uppercase tracking-wider">Telepon</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-[#3e2a1f] uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#e2d3c1]">
            @php $no = 1; @endphp
            @forelse($petugas as $p)
            <tr class="hover:bg-[#f9f6f0] transition-colors">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-[#3e2a1f]">{{ $no++ }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-[#3e2a1f]">{{ $p->nip ?? '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  @if($p->foto_profil)
                    <img src="{{ asset('storage/petugas/'.$p->foto_profil) }}"
                         class="w-8 h-8 rounded-full object-cover mr-3 border border-[#c9a44c]">
                  @else
                    <div class="w-8 h-8 rounded-full bg-[#b08b33] text-white flex items-center justify-center text-xs font-semibold mr-3">
                      {{ strtoupper(substr($p->nama ?? 'P', 0, 1)) }}
                    </div>
                  @endif
                  <span class="text-sm font-medium text-[#3e2a1f]">{{ $p->nama ?? '-' }}</span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-[#6b5a4a]">{{ $p->email ?? '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-[#6b5a4a]">{{ $p->telepon ?? '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  Aktif
                </span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-6 py-12 text-center">
                <div class="flex flex-col items-center">
                  <svg class="w-12 h-12 text-[#6b5a4a] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>
                  <p class="text-[#6b5a4a] font-medium">Tidak ada data petugas aktif</p>
                  <p class="text-[#9c8b7a] text-sm mt-1">Belum ada petugas yang terdaftar dengan status aktif</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
  const searchTerm = this.value.toLowerCase();
  const rows = document.querySelectorAll('tbody tr');

  rows.forEach(row => {
    if (row.cells.length > 1) { // Skip empty state row
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(searchTerm) ? '' : 'none';
    }
  });
});
</script>
@endsection