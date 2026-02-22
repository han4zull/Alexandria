
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Kategori Buku (Admin)</title>

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

    /* Category card styles */
    .kategori-card {
      border-radius: 16px;
      padding: 24px;
      background: #ffffff;
      border: 1px solid rgba(201,164,76,0.1);
      box-shadow: 0 4px 12px rgba(62,42,31,0.08);
      min-height: 140px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 8px;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      cursor: pointer;
    }

    .kategori-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(62,42,31,0.12);
      border-color: rgba(201,164,76,0.2);
    }

    /* accent stripe */
    .kategori-card::before {
      content: '';
      position: absolute;
      left: 0; top: 0; bottom: 0;
      width: 4px;
      background: linear-gradient(180deg, #c9a44c, #b08a3f);
      opacity: 1;
    }
    .kategori-icon { width:38px;height:38px;border-radius:8px;background:rgba(201,164,76,0.08);display:flex;align-items:center;justify-content:center;color:var(--accent) }
    .count-badge {
      background: rgba(201,164,76,0.1);
      color: #c9a44c;
      padding: 6px 12px;
      border-radius: 999px;
      font-weight: 600;
      font-size: 0.85rem;
      border: 1px solid rgba(201,164,76,0.2);
      transition: opacity .3s ease, visibility .3s ease;
    }
    .muted { color: #6b5a4a; }
    .search-input { box-shadow: none; border:1px solid rgba(34,34,34,0.06) }
    /* delete icon positioned to cover the count badge area */
    .card-delete {
      position: absolute;
      top: 16px;
      right: 16px;
      opacity: 0;
      visibility: hidden;
      transition: opacity .3s ease, visibility .3s ease;
      pointer-events: none;
      z-index: 10;
    }

    /* Show delete button on hover */
    .kategori-card:hover .card-delete {
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
    }

    /* Hide count badge when delete button is visible */
    .kategori-card:hover .count-badge {
      opacity: 0;
      visibility: hidden;
    }
    .modal-backdrop { background: rgba(0,0,0,0.12); backdrop-filter: blur(4px) }
    .modal-content { background: #fff; border-radius: 16px; box-shadow: 0 24px 56px rgba(16,24,40,0.12); border: 1px solid rgba(20,20,20,0.04) }
    .modal-header { font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: #1f1f1f; margin-bottom: 2px }
    .modal-label { display: block; font-size: 0.9rem; color: #4a4a4a; margin-bottom: 0.5rem; font-weight: 500 }
    .modal-input { width: 100%; padding: 0.65rem 0.9rem; border: 1px solid rgba(34,34,34,0.08); border-radius: 10px; font-size: 0.95rem; transition: all .12s ease; background: #fafafa }
    .modal-input:focus { outline: none; background: #fff; border-color: rgba(201,164,76,0.3); box-shadow: 0 0 0 3px rgba(201,164,76,0.06) }
    .modal-actions { display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 1.5rem }
    .modal-btn-cancel { padding: 0.65rem 1.2rem; border-radius: 10px; border: 1px solid rgba(34,34,34,0.08); background: transparent; color: #4a4a4a; font-weight: 600; cursor: pointer; transition: all .12s ease; font-size: 0.9rem }
    .modal-btn-cancel:hover { background: rgba(34,34,34,0.02); border-color: rgba(34,34,34,0.12) }
    .modal-btn-submit { padding: 0.65rem 1.2rem; border-radius: 10px; border: none; background: linear-gradient(90deg, #c9a44c, #b08a3f); color: #fff; font-weight: 600; cursor: pointer; transition: all .12s ease; font-size: 0.9rem; box-shadow: 0 8px 22px rgba(201,164,76,0.12) }
    .modal-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 34px rgba(176,138,63,0.16) }
  </style>
</head>

<body class="text-[#3e2a1f]">

  <div class="min-h-screen flex gap-6 p-6">
    @include('admin.layout.sidebar')

    <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">

    @section('page-icon')
    <svg class="w-6 h-6 text-[#8b6f47]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
    </svg>
    @endsection

    @section('page-title')
    Kategori Buku
    @endsection

    @include('admin.layout.header')

    <div class="text-sm text-[#6b5a4a] mb-6">Total kategori: <strong class="text-[#3e2a1f]">{{ $kategori->count() }}</strong></div>

      <!-- SEARCH + UNDUH + TAMBAH KATEGORI -->
      <div class="flex flex-col md:flex-row justify-between items-center mb-5 gap-4">

        <div class="flex items-center gap-3 w-full md:w-1/2">
          <input type="text" id="searchInput" placeholder="Cari kategori..."
                 class="w-full px-4 py-3 text-sm bg-white shadow border border-[#e2d3c1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c9a44c]">
          <button id="searchBtn"
                  class="px-5 py-3 bg-[#c9a44c] rounded-xl hover:bg-[#b28f45] transition shadow flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <circle cx="11" cy="11" r="7" stroke-width="1.6"/>
              <path stroke-width="1.6" d="M20 20l-3-3"/>
            </svg>
          </button>
        </div>

        <div class="flex gap-3">
          <a href="{{ route('laporankategori_admin') }}"
             class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-br from-[#c9a44c] to-[#8a6a3f] text-white rounded-xl font-medium shadow-lg hover:scale-[1.03] transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-width="1.6" d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
              <path stroke-width="1.6" d="M4 21h16"/>
            </svg>
            Unduh Laporan
          </a>

          <button id="open-tambah-kategori" type="button"
             class="inline-flex items-center gap-2 px-5 py-3 bg-[#c9a44c] text-white rounded-xl font-medium shadow-lg hover:bg-[#b28f45] transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kategori
          </button>
        </div>

      </div>

      <div class="bg-white rounded-xl p-6 shadow">
        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8">
          @forelse($kategori as $k)
            <div class="kategori-card group relative">
              <a href="{{ route('kategoribuku.show', $k->id) }}" class="no-underline text-current">
                <div class="flex items-center justify-between">
                  <div>
                    <div class="text-base kategori-title font-semibold">{{ $k->nama_kategori }}</div>
                    <div class="text-sm muted mt-1">{{ $k->buku_count ?? $k->buku()->count() }} buku</div>
                  </div>
                  <div class="count-badge" aria-hidden="true">{{ $k->buku_count ?? $k->buku()->count() }}</div>
                </div>
              </a>

                <button type="button"
                      data-delete-url="{{ route('admin.kategori.hapus', $k->id) }}"
                      data-name="{{ $k->nama_kategori }}"
                    class="card-delete delete-btn w-8 h-8 rounded flex items-center justify-center text-red-600 bg-white border border-transparent hover:bg-red-600 hover:text-white transition"
                      title="Hapus">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6a1 1 0 011 1v1H8V4a1 1 0 011-1z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12l-1 13a2 2 0 01-2 2H9a2 2 0 01-2-2L6 7z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14 11v6" />
                </svg>
              </button>
            </div>
          @empty
            <div class="col-span-4 text-center text-gray-500 py-6">Belum ada kategori.</div>
          @endforelse
        </div>
      </div>

    </main>
  </div>

  <!-- Modal: Tambah Kategori -->
  <div id="modal-tambah-kategori" class="fixed inset-0 hidden items-center justify-center z-50">
    <div class="modal-backdrop absolute inset-0"></div>
    <div class="modal-content z-10 w-full max-w-md p-7">
      <div>
        <div class="modal-header">Tambah Kategori</div>
        <p class="text-sm text-gray-600">Buat kategori buku baru</p>
      </div>
      <form action="{{ route('admin.kategori.store') }}" method="POST" class="mt-5">
        @csrf
        <div class="mb-4">
          <label class="modal-label">Nama Kategori</label>
          <input name="nama_kategori" type="text" required class="modal-input" placeholder="Masukkan nama kategori..." />
        </div>
        <div class="modal-actions">
          <button type="button" id="modal-cancel" class="modal-btn-cancel">Batal</button>
          <button type="submit" class="modal-btn-submit">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function(){
      const openBtn = document.getElementById('open-tambah-kategori');
      const modal = document.getElementById('modal-tambah-kategori');
      const cancel = document.getElementById('modal-cancel');

      function showModal(){ modal.classList.remove('hidden'); modal.classList.add('flex'); }
      function hideModal(){ modal.classList.remove('flex'); modal.classList.add('hidden'); }

      openBtn && openBtn.addEventListener('click', showModal);
      cancel && cancel.addEventListener('click', hideModal);
      modal && modal.addEventListener('click', function(e){ if(e.target === modal) hideModal(); });
    });
  </script>

  <!-- Confirm delete modal -->
  <div id="confirm-delete-modal" class="fixed inset-0 hidden items-center justify-center z-50">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="bg-white rounded-lg p-6 z-10 w-full max-w-sm shadow-sm">
      <h3 class="text-lg font-semibold mb-2">Konfirmasi Hapus</h3>
      <p id="confirm-delete-text" class="text-sm text-gray-700 mb-4">Apakah Anda yakin ingin menghapus kategori ini?</p>
      <form id="confirm-delete-form" method="POST" action="">
        @csrf
        @method('DELETE')
        <div class="flex justify-end gap-2">
          <button type="button" id="confirm-delete-cancel" class="px-3 py-2 rounded bg-gray-100 text-sm">Batal</button>
          <button type="submit" class="px-3 py-2 rounded bg-red-600 text-white text-sm">Hapus</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function(){
      const deleteButtons = document.querySelectorAll('.delete-btn');
      const confirmModal = document.getElementById('confirm-delete-modal');
      const confirmText = document.getElementById('confirm-delete-text');
      const confirmForm = document.getElementById('confirm-delete-form');
      const confirmCancel = document.getElementById('confirm-delete-cancel');

      function showConfirm(){ confirmModal.classList.remove('hidden'); confirmModal.classList.add('flex'); }
      function hideConfirm(){ confirmModal.classList.remove('flex'); confirmModal.classList.add('hidden'); }

      deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(){
          const url = this.getAttribute('data-delete-url');
          const name = this.getAttribute('data-name') || 'kategori ini';
          confirmForm.setAttribute('action', url);
          confirmText.textContent = `Hapus kategori "${name}"? Tindakan ini tidak dapat dibatalkan.`;
          showConfirm();
        });
      });

      confirmCancel && confirmCancel.addEventListener('click', hideConfirm);
      confirmModal && confirmModal.addEventListener('click', function(e){ if(e.target === confirmModal) hideConfirm(); });
    });
  </script>

</body>
</html>
