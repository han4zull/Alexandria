<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;
use App\Models\ProsesKembali;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

// Splash
Route::get('/', function () {
    return view('user.ss_user');
});

// Landing
Route::get('/landing_page', [UserController::class, 'landing'])
    ->name('user.lp_user');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::prefix('akun')->group(function () {
    Route::get('/daftar', [AuthController::class, 'showDaftar'])
        ->name('akun.daftar');

    Route::post('/daftar', [AuthController::class, 'register'])
        ->name('akun.register');

    Route::get('/masuk', [AuthController::class, 'showMasuk'])
        ->name('akun.masuk');

    Route::post('/masuk', [AuthController::class, 'login'])
        ->name('akun.login');
});

// Backwards-compatible login routes used by auth middleware
Route::get('/login', [AuthController::class, 'showMasuk'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('akun.masuk');
})->name('logout');

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

// Lightweight AJAX auth check (used by client to validate session before showing modal)
Route::get('/ajax/auth/check', function () {
    \Illuminate\Support\Facades\Log::info('ajax.auth.check', [
        'authenticated' => auth()->check(),
        'user_id' => auth()->id(),
        'accept' => request()->header('Accept'),
        'xhr' => request()->header('X-Requested-With'),
        'session_cookie' => request()->cookie(config('session.cookie')) ? 'present' : 'missing',
    ]);

    return response()->json([
        'authenticated' => auth()->check(),
        'user_id' => auth()->id(),
    ]);
})->name('ajax.auth.check');

// Debug endpoint (local only) to inspect what the server receives when the form is submitted
Route::post('/debug/pinjam-echo', function (\Illuminate\Http\Request $request) {
    if (!app()->environment('local')) {
        abort(404);
    }

    \Illuminate\Support\Facades\Log::info('debug.pinjam-echo', [
        'authenticated' => auth()->check(),
        'user_id' => auth('web')->id(),
        'headers' => $request->headers->all(),
        'cookies' => $request->cookie(),
        'input' => $request->all(),
        'session_cookie' => $request->cookie(config('session.cookie')) ? 'present' : 'missing',
    ]);

    return response()->json([
        'authenticated' => auth()->check(),
        'user_id' => auth('web')->id(),
        'headers' => $request->headers->all(),
        'cookies' => array_keys($request->cookies->all()),
        'input' => $request->all(),
    ]);
})->name('debug.pinjam.echo');
Route::middleware(['auth:web', 'role:user'])->group(function () {
    Route::get('/beranda', [UserController::class, 'dashboard'])->name('br_user');
    Route::get('/buku', [UserController::class, 'buku'])->name('buku_user');
    Route::get('/buku/{id}', [UserController::class, 'detailBuku'])->name('buku.detailbuku');
    // Pinjam buku (form + submit)
    // Pinjam buku (form + submit)
    Route::get('/buku/{id}/pinjam', [UserController::class, 'showBorrowForm'])->name('buku.pinjam');
    Route::post('/buku/{id}/pinjam', [UserController::class, 'submitBorrow'])->name('buku.pinjam.submit');
    Route::get('/peminjaman/{id}/waiting', [UserController::class, 'waitingApproval'])->name('peminjaman.waiting');
    
    // Save/Unsave book
    Route::post('/buku/{id}/save', function ($id) {
        $user = auth('web')->user();
        $buku = \App\Models\Buku::findOrFail($id);
        
        if ($user->savedBooks()->where('buku_id', $id)->exists()) {
            $user->savedBooks()->detach($id);
            return back()->with('success', 'Buku dihapus dari simpanan.');
        } else {
            $user->savedBooks()->attach($id);
            return back()->with('success', 'Buku disimpan!');
        }
    })->name('buku.save');
    
    Route::get('/simpan', function () {
        $savedBooks = auth('web')->user()->savedBooks()->paginate(12);
        return view('user.simpan_user', compact('savedBooks'));
    })->name('simpan_user');
    
    Route::get('/riwayat', [UserController::class, 'riwayat'])->name('riwayat_user');
    
    // Kembalikan buku - Otomatis buat record di proses_kembali
    Route::post('/peminjaman/{id}/kembalikan', function ($id) {
        $peminjaman = \App\Models\Peminjaman::findOrFail($id);
        
        // Check if belongs to user
        if ($peminjaman->user_id !== auth('web')->id()) {
            abort(403);
        }
        
        // Update status menjadi proses pengembalian
        $peminjaman->update(['status' => 'proses pengembalian']);
        
        // Otomatis buat record di proses_kembali jika belum ada
        $prosesKembali = ProsesKembali::where('peminjaman_id', $peminjaman->id)->first();
        if (!$prosesKembali) {
            ProsesKembali::create([
                'peminjaman_id' => $peminjaman->id,
                'user_id' => $peminjaman->user_id,
                'buku_id' => $peminjaman->buku_id,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_kembali' => $peminjaman->tanggal_kembali,
                'tanggal_dikembalikan' => now()->toDateString(),
                'kondisi_buku' => 'baik', // default
                'denda' => 0, // default, akan dihitung petugas
            ]);
        }
        
        return back()->with('success', 'Buku dalam proses pengembalian. Silahkan bawa ke perpustakaan untuk konfirmasi.');
    })->name('buku.kembalikan');
    
    Route::get('/profil', [UserController::class, 'profil'])->name('profile_user');
    Route::get('/profil/edit', [UserController::class, 'editProfil'])->name('profile.edit');
    Route::post('/profil/update', [UserController::class, 'updateProfil'])->name('profile.update');

    // Confirmation page after submit (shows QR)
    Route::get('/peminjaman/{id}/confirm', [UserController::class, 'confirmBorrow'])->name('buku.pinjam.confirm');

    // ULASAN ROUTES - menggunakan UlasanController
    Route::prefix('ulasan')->group(function () {
        Route::get('/', [\App\Http\Controllers\UlasanController::class, 'getUserReviews'])->name('ulasan.index');
        Route::post('/buku/{id}', [\App\Http\Controllers\UlasanController::class, 'store'])->name('ulasan.store');
        Route::put('/buku/{id}', [\App\Http\Controllers\UlasanController::class, 'update'])->name('ulasan.update');
        Route::delete('/buku/{id}', [\App\Http\Controllers\UlasanController::class, 'destroy'])->name('ulasan.destroy');
    });

    // BACKWARD COMPATIBILITY - route lama untuk review
    Route::post('/buku/{id}/review/{peminjamanId?}', function (\Illuminate\Http\Request $request, $id, $peminjamanId = null) {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
        ]);

        $user = auth()->user();
        $buku = \App\Models\Buku::findOrFail($id);

        // Jika ada peminjamanId, gunakan untuk unique constraint
        $uniqueData = $peminjamanId 
            ? ['user_id' => $user->id, 'peminjaman_id' => $peminjamanId]
            : ['user_id' => $user->id, 'buku_id' => $id];

        // Untuk backward compatibility: jika ada ulasan lama (tanpa peminjaman_id), update dengan peminjaman_id
        if ($peminjamanId) {
            $existingOldReview = \App\Models\UlasanBuku::where('user_id', $user->id)
                ->where('buku_id', $id)
                ->whereNull('peminjaman_id')
                ->first();
            
            if ($existingOldReview) {
                $existingOldReview->update([
                    'peminjaman_id' => $peminjamanId,
                    'rating' => $request->rating,
                    'ulasan' => $request->review,
                ]);
                return redirect()->to(route('buku.detailbuku', $id) . '#ulasan')->with('success', 'Ulasan berhasil diperbarui!');
            }
        }

        // Update atau create review
        \App\Models\UlasanBuku::updateOrCreate(
            $uniqueData,
            [
                'user_id' => $user->id,
                'buku_id' => $id,
                'peminjaman_id' => $peminjamanId,
                'rating' => $request->rating,
                'ulasan' => $request->review,
            ]
        );

        return redirect()->to(route('buku.detailbuku', $id) . '#ulasan')->with('success', 'Ulasan berhasil disimpan!');
    })->name('buku.review');
});

// QR Code Generator route (public, no auth needed)
Route::get('/qr/generate', function (\Illuminate\Http\Request $request) {
    $data = $request->get('data');
    if (!$data) {
        return response('No data', 400);
    }

    $decoded = base64_decode($data);
    $qrPayload = json_decode($decoded, true);
    $qrText = json_encode($qrPayload);

    try {
        // Use Bacon QR Code with SVG renderer (doesn't require GD)
        $renderer = new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(400),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );
        $writer = new \BaconQrCode\Writer($renderer);
        $svgData = $writer->writeString($qrText);

        return response($svgData)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'public, max-age=31536000');
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('QR generation failed', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        // Fallback: return a simple SVG placeholder
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><rect width="100" height="100" fill="red"/><text x="50" y="50" text-anchor="middle" dy=".3em" fill="white">QR Error</text></svg>';
        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'public, max-age=31536000');
    }
})->name('qr.generate');

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:petugas', 'role:petugas'])->prefix('petugas')->group(function () {

    Route::get('/br_petugas', [PetugasController::class, 'dashboard'])
        ->name('br_petugas');

    Route::get('/buku_petugas', [PetugasController::class, 'buku'])
        ->name('buku_petugas');

    Route::post('/buku_petugas/store', [PetugasController::class, 'storeBuku'])->name('petugas.buku.store');

    Route::get('/buku/tambah', [PetugasController::class, 'createBuku'])
         ->name('petugas.buku.tambah');

    Route::post('/buku/tambah', [PetugasController::class, 'storeBuku'])
         ->name('petugas.buku.create_store');

    Route::get('/buku/edit/{id}', [PetugasController::class, 'editBuku'])
        ->name('petugas.buku.edit');

    Route::put('/buku/edit/{id}', [PetugasController::class, 'updateBuku'])
        ->name('petugas.buku.update');

    Route::delete('/buku/hapus/{id}', [PetugasController::class, 'destroyBuku'])
        ->name('petugas.buku.destroy');


    Route::get('laporan-buku', [PetugasController::class, 'index'])
        ->name('laporanbuku_petugas');

    Route::get('/manajemenbuku_petugas', [PetugasController::class, 'manajemenBuku'])
        ->name('petugas.manajemenbuku_petugas');

    Route::post('/peminjaman/{id}/setujui', [PetugasController::class, 'setujuiPeminjaman'])
        ->name('peminjaman.setujui');

    Route::post('/peminjaman/{id}/tolak', [PetugasController::class, 'tolakPeminjaman'])
        ->name('peminjaman.tolak');

    Route::get('/peminjaman_petugas', [PetugasController::class, 'peminjaman'])
        ->name('peminjaman_petugas');

    Route::get('/prosespengembalian_petugas', [PetugasController::class, 'prosesPengembalian'])
        ->name('prosespengembalian_petugas');

    Route::get('/pengembalian_petugas', [PetugasController::class, 'pengembalian'])
        ->name('pengembalian_petugas');

    Route::get('/user_petugas', [PetugasController::class, 'user'])
        ->name('user_petugas');

    Route::get('/profile_petugas', [PetugasController::class, 'profile'])
        ->name('profile_petugas');

    Route::get('/petugas/edit/{id}', [PetugasController::class, 'edit'])
        ->name('petugas_edit');

    Route::put('/petugas/update/{id}', [PetugasController::class, 'update'])
        ->name('petugas.update');

    // Proses pengembalian - Selesai (gunakan controller untuk mencatat proses)
    Route::post('/pengembalian/{id}/selesai', [PetugasController::class, 'selesaiPengembalian'])
        ->name('pengembalian.selesai');

    // Proses pengembalian - Tolak
    Route::post('/pengembalian/{id}/tolak', function ($id) {
        $peminjaman = \App\Models\Peminjaman::findOrFail($id);
        if ($peminjaman->status !== 'proses pengembalian') {
            return back()->with('error', 'Status tidak valid untuk ditolak');
        }
        $peminjaman->update(['status' => 'ditolak']);
        return back()->with('success', 'Pengembalian buku ditolak');
    })->name('pengembalian.tolak');

    // Endpoint untuk memproses kondisi pengembalian (hitung denda, simpan tanggal sebenarnya)
    Route::post('/peminjaman/{id}/proseskembali', [PetugasController::class, 'prosesKembali'])
        ->name('peminjaman.proseskembali');

    // Laporan per-tab (view + PDF download)
    Route::get('/laporan', [PetugasController::class, 'laporanUnified'])
        ->name('petugas.laporan.unified');

    Route::get('/laporan/peminjaman-aktif', [PetugasController::class, 'laporanPeminjamanAktif'])
        ->name('petugas.laporan.peminjaman_aktif');
    Route::get('/laporan/peminjaman-aktif/pdf', [PetugasController::class, 'laporanPeminjamanAktifPdf'])
        ->name('petugas.laporan.peminjaman_aktif_pdf');

    Route::get('/laporan/proses-pengembalian', [PetugasController::class, 'laporanProsesPengembalian'])
        ->name('petugas.laporan.proses_pengembalian');
    Route::get('/laporan/proses-pengembalian/pdf', [PetugasController::class, 'laporanProsesPengembalianPdf'])
        ->name('petugas.laporan.proses_pengembalian_pdf');

    Route::get('/laporan/selesai', [PetugasController::class, 'laporanSelesai'])
        ->name('petugas.laporan.selesai');
    Route::get('/laporan/selesai/pdf', [PetugasController::class, 'laporanSelesaiPdf'])
        ->name('petugas.laporan.selesai_pdf');

    Route::get('/laporan/user', [PetugasController::class, 'laporanUser'])
        ->name('petugas.laporan.user');
    Route::get('/laporan/user/pdf', [PetugasController::class, 'laporanUserPdf'])
        ->name('petugas.laporan.user_pdf');

    // Laporan Buku (PDF downloads)
    Route::get('/laporan/buku-proses', [PetugasController::class, 'laporanBukuProses'])
        ->name('petugas.laporan.buku_proses');
    Route::get('/laporan/buku-proses/pdf', [PetugasController::class, 'laporanBukuProsesPdf'])
        ->name('petugas.laporan.buku_proses_pdf');

    Route::get('/laporan/buku-disetujui', [PetugasController::class, 'laporanBukuDisetujui'])
        ->name('petugas.laporan.buku_disetujui');
    Route::get('/laporan/buku-disetujui/pdf', [PetugasController::class, 'laporanBukuDisetujuiPdf'])
        ->name('petugas.laporan.buku_disetujui_pdf');

    Route::get('/laporan/buku-ditolak', [PetugasController::class, 'laporanBukuDitolak'])
        ->name('petugas.laporan.buku_ditolak');
    Route::get('/laporan/buku-ditolak/pdf', [PetugasController::class, 'laporanBukuDitolakPdf'])
        ->name('petugas.laporan.buku_ditolak_pdf');

});
/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/br_admin', [AdminController::class, 'dashboard'])
        ->name('br_admin');

    Route::get('/buku_admin', [AdminController::class, 'buku'])
        ->name('buku_admin');

    // KATEGORI BUKU (Admin view)
    Route::get('/kategoribuku', function () {
        $kategori = \App\Models\KategoriBuku::withCount('buku')->orderBy('id','desc')->get();
        return view('admin.kategoribuku_admin', compact('kategori'));
    })->name('kategoribuku_admin');

    // Detail kategori: tampilkan buku-buku dalam kategori
    Route::get('/kategoribuku/{id}', function ($id) {
        $kategori = \App\Models\KategoriBuku::with('buku')->findOrFail($id);
        return view('admin.kategoribuku_show', compact('kategori'));
    })->name('kategoribuku.show');

    // Laporan kategori
    Route::get('/laporan/kategori', function () {
        $kategori = \App\Models\KategoriBuku::withCount('buku')->orderBy('id','desc')->get();
        return view('admin.laporankategori_admin', compact('kategori'));
    })->name('laporankategori_admin');

    Route::get('/laporan/kategori/pdf', function () {
        $kategori = \App\Models\KategoriBuku::withCount('buku')->orderBy('id','desc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporankategori_pdf_admin', compact('kategori'));
        return $pdf->download('laporan-kategori-' . date('Y-m-d') . '.pdf');
    })->name('laporankategori_pdf_admin');

    // Tambah kategori (form)
    Route::get('/kategoribuku/tambah', function () {
        return view('admin.kategoribuku_tambah');
    })->name('admin.kategori.tambah');

    // Simpan kategori
    Route::post('/kategoribuku/tambah', function (\Illuminate\Http\Request $request) {
        $request->validate([ 'nama_kategori' => 'required|string|max:255' ]);
        \App\Models\KategoriBuku::create([ 'nama_kategori' => $request->nama_kategori ]);
        return redirect()->route('kategoribuku_admin')->with('success', 'Kategori berhasil ditambahkan.');
    })->name('admin.kategori.store');

    // Hapus kategori
    Route::delete('/kategoribuku/hapus/{id}', function ($id) {
        $k = \App\Models\KategoriBuku::findOrFail($id);
        $k->delete();
        return redirect()->route('kategoribuku_admin')->with('success', 'Kategori dihapus.');
    })->name('admin.kategori.hapus');

    Route::post('/buku_admin/store', [AdminController::class, 'storeBuku'])->name('admin.buku.store');

    Route::get('/buku/tambah', [AdminController::class, 'createBuku'])
         ->name('admin.buku.tambah');

    Route::post('/buku/tambah', [AdminController::class, 'storeBuku'])
         ->name('admin.buku.create_store');

    Route::get('/buku/edit/{id}', [AdminController::class, 'editBuku'])
        ->name('admin.buku.edit');

    Route::put('/buku/edit/{id}', [AdminController::class, 'updateBuku'])
        ->name('admin.buku.update');

    Route::delete('/buku/hapus/{id}', [AdminController::class, 'destroyBuku'])
        ->name('admin.buku.destroy');

    Route::post('/buku/{id}/setujui', [AdminController::class, 'setujuiBuku'])
        ->name('admin.buku.setujui');

    Route::post('/buku/{id}/tolak', [AdminController::class, 'tolakBuku'])
        ->name('admin.buku.tolak');


    Route::get('/laporan-buku', [AdminController::class, 'laporanBuku'])
        ->name('laporanbuku_admin');

    Route::get('/manajemenbuku_admin', [AdminController::class, 'manajemenBuku'])
        ->name('admin.manajemenbuku');

    Route::get('/peminjaman', [AdminController::class, 'manajemenPeminjaman'])
        ->name('admin.peminjaman');

    Route::post('/peminjaman/proses/{id}', [AdminController::class, 'prosesPengembalian'])
        ->name('admin.peminjaman.proses');

    // Approve / reject peminjaman
    Route::post('/peminjaman/{id}/setujui', [AdminController::class, 'setujuiPeminjaman'])
        ->name('admin.peminjaman.setujui');

    Route::post('/peminjaman/{id}/tolak', [AdminController::class, 'tolakPeminjaman'])
        ->name('admin.peminjaman.tolak');

    Route::post('/peminjaman/{id}/proseskembali', [AdminController::class, 'prosesKembali'])
        ->name('admin.peminjaman.proseskembali');

    Route::post('/peminjaman/selesai/{id}', [AdminController::class, 'selesaiPengembalian'])
        ->name('admin.peminjaman.selesai');

    Route::post('/pengembalian/selesai/{id}', [AdminController::class, 'selesaiPengembalian'])
        ->name('admin.pengembalian.selesai');

    Route::get('/petugas_admin', [AdminController::class, 'petugas'])
        ->name('petugas_admin');

    Route::get('/petugas/create', [AdminController::class, 'createPetugas'])
        ->name('admin.petugastambah_admin');

    Route::post('/petugas/store', [AdminController::class, 'storePetugas'])
        ->name('admin.petugas.store');

    Route::get('/petugas/edit/{id}', [AdminController::class, 'editPetugas'])->name('admin.petugas.edit');
    Route::post('/petugas/update/{id}', [AdminController::class, 'updatePetugas'])->name('admin.petugas.update');


    Route::delete('/petugas/delete/{id}', [AdminController::class, 'deletePetugas'])->name('admin.petugas.delete');

    Route::get('/laporan/petugas', [AdminController::class, 'laporanPetugas'])->name('laporanpetugas_admin');

    Route::get('/user_admin', [AdminController::class, 'user'])
         ->name('user_admin');

    Route::get('/laporan/user', [AdminController::class, 'laporanUser'])
        ->name('admin.laporan.user');

    Route::get('/laporan/petugas/pdf', [AdminController::class, 'laporanPetugasPdf'])
        ->name('admin.laporan.petugas_pdf');

    Route::get('/laporan/user/pdf', [AdminController::class, 'laporanUserPdf'])
        ->name('admin.laporan.user_pdf');

    // Laporan routes untuk admin
    Route::get('/laporan/buku-proses', [AdminController::class, 'laporanBukuProses'])
        ->name('admin.laporan.buku_proses');
    Route::get('/laporan/buku-proses/pdf', [AdminController::class, 'laporanBukuProsesPdf'])
        ->name('admin.laporan.buku_proses_pdf');

    Route::get('/laporan/buku-disetujui', [AdminController::class, 'laporanBukuDisetujui'])
        ->name('admin.laporan.buku_disetujui');
    Route::get('/laporan/buku-disetujui/pdf', [AdminController::class, 'laporanBukuDisetujuiPdf'])
        ->name('admin.laporan.buku_disetujui_pdf');

    Route::get('/laporan/buku-ditolak', [AdminController::class, 'laporanBukuDitolak'])
        ->name('admin.laporan.buku_ditolak');
    Route::get('/laporan/buku-ditolak/pdf', [AdminController::class, 'laporanBukuDitolakPdf'])
        ->name('admin.laporan.buku_ditolak_pdf');

    Route::get('/laporan/peminjaman-aktif', [AdminController::class, 'laporanPeminjamanAktif'])
        ->name('admin.laporan.peminjaman_aktif');
    Route::get('/laporan/peminjaman-aktif/pdf', [AdminController::class, 'laporanPeminjamanAktifPdf'])
        ->name('admin.laporan.peminjaman_aktif_pdf');

    Route::get('/laporan/selesai', [AdminController::class, 'laporanSelesai'])
        ->name('admin.laporan.selesai');
    Route::get('/laporan/selesai/pdf', [AdminController::class, 'laporanSelesaiPdf'])
        ->name('admin.laporan.selesai_pdf');

    Route::get('/laporan/proses-pengembalian', [AdminController::class, 'laporanProsesPengembalian'])
        ->name('admin.laporan.proses_pengembalian');
    Route::get('/laporan/proses-pengembalian/pdf', [AdminController::class, 'laporanProsesPengembalianPdf'])
        ->name('admin.laporan.proses_pengembalian_pdf');

    // Laporan Petugas Detail
    Route::get('/laporan/petugas-aktif', [AdminController::class, 'laporanPetugasAktif'])
        ->name('admin.laporan.petugas_aktif');
    Route::get('/laporan/petugas-aktif/pdf', [AdminController::class, 'laporanPetugasAktifPdf'])
        ->name('admin.laporan.petugas_aktif_pdf');

    Route::get('/laporan/petugas-nonaktif', [AdminController::class, 'laporanPetugasNonaktif'])
        ->name('admin.laporan.petugas_nonaktif');
    Route::get('/laporan/petugas-nonaktif/pdf', [AdminController::class, 'laporanPetugasNonaktifPdf'])
        ->name('admin.laporan.petugas_nonaktif_pdf');

    Route::get('/laporan/petugas-semua', [AdminController::class, 'laporanPetugasSemua'])
        ->name('admin.laporan.petugas_semua');
    Route::get('/laporan/petugas-semua/pdf', [AdminController::class, 'laporanPetugasSemuaPdf'])
        ->name('admin.laporan.petugas_semua_pdf');

    // Laporan User Detail
    Route::get('/laporan/user-aktif', [AdminController::class, 'laporanUserAktif'])
        ->name('admin.laporan.user_aktif');
    Route::get('/laporan/user-aktif/pdf', [AdminController::class, 'laporanUserAktifPdf'])
        ->name('admin.laporan.user_aktif_pdf');

    Route::get('/laporan/user-nonaktif', [AdminController::class, 'laporanUserNonaktif'])
        ->name('admin.laporan.user_nonaktif');
    Route::get('/laporan/user-nonaktif/pdf', [AdminController::class, 'laporanUserNonaktifPdf'])
        ->name('admin.laporan.user_nonaktif_pdf');

    Route::get('/laporan/user-semua', [AdminController::class, 'laporanUserSemua'])
        ->name('admin.laporan.user_semua');
    Route::get('/laporan/user-semua/pdf', [AdminController::class, 'laporanUserSemuaPdf'])
        ->name('admin.laporan.user_semua_pdf');

    Route::patch('/user/{id}/blokir', [AdminController::class, 'blokir'])
         ->name('admin.user.blokir');

    Route::get('/akun_admin', [AdminController::class, 'akun'])
         ->name('akun_admin');

    Route::get('/profile_admin', [AdminController::class, 'profile'])
        ->name('profile_admin');

    Route::get('/profile_admin/edit', [AdminController::class, 'profileEdit'])
        ->name('profile_admin.edit');

    Route::put('/profile_admin/update', [AdminController::class, 'profileUpdate'])
        ->name('profile_admin.update');

    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])
        ->name('admin_edit');

    Route::put('/admin/update/{id}', [AdminController::class, 'update'])
        ->name('admin.update');
});

Route::post('/final-test', function () {
    return 'AMAN TOTAL';
});