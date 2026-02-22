<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Buku - Kategori {{ $kategori->nama_kategori }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <style>
    body { font-family: 'Inter', sans-serif; background: #f7f7f8; }
    .page-header { display:flex;align-items:center;justify-content:space-between;gap:16px }
    .page-title { font-family: 'Poppins', sans-serif; font-size:1.5rem; color:#1f1f1f }
    .page-sub { color:#6b6b6b; font-size:.9rem }
    :root { --accent: #c9a44c; --accent-dark:#b08a3f; }
    .card { background:#fff;border-radius:12px;padding:18px;border:1px solid rgba(20,20,20,0.04);box-shadow:0 6px 18px rgba(16,24,40,0.04) }
    .btn-ghost { display:inline-flex;align-items:center;gap:.5rem;background:transparent;border:1px solid rgba(201,164,76,0.3);padding:.5rem .9rem;border-radius:10px;color:#8a6a3f;font-weight:600;transition:all .14s ease;text-decoration:none }
    .btn-ghost svg { opacity:.9 }
    .btn-ghost:hover { background: rgba(201,164,76,0.06); border-color: rgba(34,34,34,0.08); transform:translateY(-1px) }
    .btn-primary { display:inline-flex;align-items:center;gap:.6rem;padding:.55rem .9rem;border-radius:10px;color:#fff;font-weight:600;background:linear-gradient(90deg,var(--accent),var(--accent-dark));box-shadow:0 8px 22px rgba(201,164,76,0.12);border:none;transition:transform .12s ease;text-decoration:none;cursor:pointer }
    .btn-primary svg { opacity:.98 }
    .btn-primary:hover { transform: translateY(-2px); box-shadow:0 12px 34px rgba(176,138,63,0.16) }
    table thead th { text-align:left; font-size:.85rem; color:#6b6b6b; padding:.75rem 1rem }
    table tbody td { padding:.85rem 1rem; vertical-align:middle }
    table tbody tr { border-bottom:1px solid rgba(20,20,20,0.03) }
    table tbody tr:hover { background:#fbfbfb }
    .small-muted { color:#8b8b8b; font-size:.85rem }
  </style>
</head>
<body class="text-[#3e2a1f]">
  <div class="min-h-screen flex gap-6 p-6">
    @include('admin.layout.sidebar')

    <main class="flex-1 bg-[#faf6ee]/80 rounded-3xl p-8 shadow-xl max-w-[1400px] mx-auto">
      

      <div class="page-header mb-4">
          <div>
            <div class="page-title">{{ $kategori->nama_kategori }}</div>
            <div class="page-sub">{{ $kategori->buku->count() }} buku dalam kategori ini</div>
          </div>
          <div class="flex items-center gap-3">
            <a href="{{ route('kategoribuku_admin') }}" class="btn-ghost">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
              </svg>
              Kembali
            </a>
            <a href="{{ route('laporankategori_admin') }}" class="btn-primary">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 11l4 4 4-4" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 21h14" />
              </svg>
              Unduh
            </a>
          </div>
      </div>

      <div class="card">
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr>
                <th style="width:56px">No</th>
                <th>Judul</th>
                <th style="width:140px">ISBN</th>
                <th style="width:160px">Penulis</th>
                <th style="width:140px">Penerbit</th>
                <th style="width:90px">Tahun</th>
                <th style="width:80px">Stok</th>
              </tr>
            </thead>
            <tbody>
              @forelse($kategori->buku as $b)
                <tr>
                  <td class="small-muted">{{ $loop->iteration }}</td>
                  <td class="text-gray-800">{{ $b->judul }}</td>
                  <td class="small-muted">{{ $b->isbn ?? '-' }}</td>
                  <td class="small-muted">{{ $b->penulis ?? '-' }}</td>
                  <td class="small-muted">{{ $b->penerbit ?? '-' }}</td>
                  <td class="small-muted">{{ $b->tahun_terbit ?? '-' }}</td>
                  <td class="small-muted">{{ $b->stok ?? '-' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada buku pada kategori ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>
</body>
</html>
