@extends('admin.layout.app')

@section('title', 'Laporan Buku - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#f5f1e8] to-[#e8dcc0] p-6">
  <!-- HEADER -->
  <div class="max-w-7xl mx-auto mb-8">
    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-[#e2d3c1]">

      @section('page-icon')
      <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
      </svg>
      @endsection

      @section('page-title')
      Laporan Buku
      @endsection

      @include('admin.layout.header')

  <!-- REPORT CARDS -->
  <div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <!-- PEMINJAMAN AKTIF -->
      <div class="bg-white rounded-2xl shadow-lg p-6 border border-[#e2d3c1] hover:shadow-xl transition-shadow">
        <div class="flex items-center mb-4">
          <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-[#3e2a1f]">Peminjaman Aktif</h3>
            <p class="text-sm text-[#6b5a4a]">Laporan buku yang sedang dipinjam</p>
            <div class="mt-2 text-xs text-blue-600 font-medium">{{ $aktifCount }} data tersedia</div>
          </div>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('admin.laporan.peminjaman_aktif') }}"
             class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-xl font-medium transition">
            Lihat Laporan
          </a>
          <a href="{{ route('admin.laporan.peminjaman_aktif_pdf') }}"
             class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-xl font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- PROSES PENGEMBALIAN -->
      <div class="bg-white rounded-2xl shadow-lg p-6 border border-[#e2d3c1] hover:shadow-xl transition-shadow">
        <div class="flex items-center mb-4">
          <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-[#3e2a1f]">Proses Pengembalian</h3>
            <p class="text-sm text-[#6b5a4a]">Laporan buku dalam proses kembali</p>
            <div class="mt-2 text-xs text-yellow-600 font-medium">{{ $prosesCount }} data tersedia</div>
          </div>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('admin.laporan.buku_proses') }}"
             class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white text-center py-2 px-4 rounded-xl font-medium transition">
            Lihat Laporan
          </a>
          <a href="{{ route('admin.laporan.buku_proses_pdf') }}"
             class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-xl font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- SELESAI -->
      <div class="bg-white rounded-2xl shadow-lg p-6 border border-[#e2d3c1] hover:shadow-xl transition-shadow">
        <div class="flex items-center mb-4">
          <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-[#3e2a1f]">Selesai</h3>
            <p class="text-sm text-[#6b5a4a]">Laporan buku yang sudah dikembalikan</p>
            <div class="mt-2 text-xs text-green-600 font-medium">{{ $selesaiCount }} data tersedia</div>
          </div>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('admin.laporan.selesai') }}"
             class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-xl font-medium transition">
            Lihat Laporan
          </a>
          <a href="{{ route('admin.laporan.selesai_pdf') }}"
             class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-xl font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </a>
        </div>
      </div>

    </div>

    <!-- BACK BUTTON -->
    <div class="mt-8 text-center">
      <a href="{{ route('admin.manajemenbuku') }}"
         class="inline-flex items-center gap-2 bg-[#c9a44c] hover:bg-[#b28f45] text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:scale-[1.02] transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Manajemen Buku
      </a>
    </div>
  </div>
</div>
@endsection