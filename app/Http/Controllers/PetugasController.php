<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\ProsesKembali;
use App\Models\KategoriBuku;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; 
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PetugasController extends Controller
{
    // ==========================
    // CRUD PETUGAS (Admin Only)
    // ==========================
    public function index()
    {
        $petugas = Petugas::all();
        return view('admin.petugas_admin', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugastambah_admin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:petugas,username',
            'email' => 'required|email|unique:petugas,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'tanggal_dibuat' => 'required|date',
            'jenis_kelamin' => 'required'
        ]);

        Petugas::create([
            'nama' => $request->nama,
            'username' => $request->username, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_plain' => $request->password,
            'role' => $request->role,
            'tanggal_dibuat' => $request->tanggal_dibuat,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('admin.petugas_admin')->with('success', 'Petugas berhasil ditambah');
    }

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);

        // Pastikan petugas hanya bisa edit profile sendiri
        if (auth('petugas')->id() != $id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit profile ini.');
        }

        return view('petugas.profileedit_petugas', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        // Pastikan petugas hanya bisa update profile sendiri
        if (auth('petugas')->id() != $id) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate profile ini.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas,email,'.$id,
            'jenis_kelamin' => 'required|in:L,P',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
        ];

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($petugas->foto && file_exists(storage_path('app/public/'.$petugas->foto))) {
                unlink(storage_path('app/public/'.$petugas->foto));
            }

            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public', $filename);
            $data['foto'] = $filename;
        }

        $petugas->update($data);

        return redirect()->route('profile_petugas')->with('success', 'Profile berhasil diupdate');
    }

    public function destroy($id)
    {
        Petugas::findOrFail($id)->delete();
        return redirect()->route('admin.petugas_admin')->with('success', 'Petugas berhasil dihapus');
    }

    // ==========================
    // Dashboard / Home
    // ==========================
    public function dashboard()
    {
        // Ambil statistik dashboard
        $stats = [
            'dipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'proses_kembali' => ProsesKembali::count(),
            'pending' => Peminjaman::where('status', 'menunggu konfirmasi')->count(),
            'approved' => Buku::where('status', 'approved')->count(),
            'rejected' => Buku::where('status', 'rejected')->count(),
            'dikembalikan' => Peminjaman::where('status', 'selesai')->count(),
            'user' => User::count(),
            'petugas' => Petugas::count(),
        ];

        return view('petugas.br_petugas', compact('stats'));
    }

    // Halaman Buku
    public function buku()
    {
        $buku = Buku::all();
        $kategori = KategoriBuku::all(); // ambil semua kategori
        return view('petugas.buku_petugas', compact('buku','kategori'));
    }

    public function createBuku()
    {
        $kategori = KategoriBuku::all();
        return view('petugas.bukutambah_petugas', compact('kategori'));
    }

    public function storeBuku(Request $request)
    {
        $request->validate([
            'isbn' => 'required|unique:buku',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoribuku,id',
            'deskripsi' => 'required',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $buku = Buku::create([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'status' => 'menunggu',
            'cover' => null,
        ]);

        // handle cover
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            try {
                $path = $request->file('cover')->store('buku', 'public');
                $buku->update(['cover' => $path]);
            } catch (\Exception $e) {
                \Log::error('Cover upload failed: ' . $e->getMessage());
            }
        }

        // attach kategori
        $buku->kategori()->attach([$request->kategori_id]);

        return redirect()->route('buku_petugas')->with('success', 'Buku berhasil disimpan');
    }

    // Relasi Buku ↔ Kategori
    public function kategori()
    {
        return $this->belongsToMany(KategoriBuku::class, 'buku_kategori', 'buku_id', 'kategori_buku_id');
    }

    // Form edit buku
    public function editBuku($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        $kategori = KategoriBuku::all();
        return view('petugas.bukuedit_petugas', compact('buku','kategori'));
    }

    // Update buku
    public function updateBuku(Request $request, $id)
{
    $buku = Buku::findOrFail($id);

    $request->validate([
        'isbn' => 'required|unique:buku,isbn,'.$id,
        'judul' => 'required',
        'penulis' => 'required',
        'penerbit' => 'required',
        'tahun_terbit' => 'required|numeric',
        'stok' => 'required|numeric',
        'kategori_id' => 'required|exists:kategoribuku,id',
        'cover' => 'nullable|image|max:2048',
        'deskripsi' => 'nullable|string'
    ]);

    // Handle cover upload
    if($request->hasFile('cover')) {
        $file = $request->file('cover');
        // Cek apakah file benar-benar ada dan valid
        if($file && $file->isValid() && $file->getSize() > 0) {
            try {
                // Hapus cover lama jika ada
                if($buku->cover) {
                    Storage::disk('public')->delete($buku->cover);
                }
                // Simpan cover baru
                $buku->cover = $file->store('buku', 'public');
                $buku->save();
            } catch (\Exception $e) {
                \Log::error('Cover upload failed: ' . $e->getMessage());
                return back()->with('error', 'Gagal upload cover: ' . $e->getMessage());
            }
        }
    }

    // Update data buku
    $buku->update([
        'isbn' => $request->isbn,
        'judul' => $request->judul,
        'penulis' => $request->penulis,
        'penerbit' => $request->penerbit,
        'tahun_terbit' => $request->tahun_terbit,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
    ]);

    // Sync kategori
    $buku->kategori()->sync([$request->kategori_id]);

    return redirect()->route('buku_petugas')->with('success', 'Buku berhasil diperbarui.');
}

    // Hapus buku
    public function destroyBuku($id)
{
    $buku = Buku::findOrFail($id);

    if ($buku->cover) {
        Storage::disk('public')->delete($buku->cover);
    }

    $buku->kategori()->detach();
    $buku->delete();

    // Cek jika request AJAX
    if(request()->ajax()) {
        return response()->json(['success' => true, 'message' => 'Buku berhasil dihapus']);
    }

    // Kalau bukan AJAX, redirect seperti biasa
    return redirect()->route('buku_petugas')->with('success', 'Buku berhasil dihapus.');
}



    public function laporanBuku()
    {
        $buku = Buku::all();
        return view('petugas.laporan_buku', compact('buku'));
    }

    public function manajemenBuku()
    {
        $menungguKonfirmasi = Peminjaman::with(['user','buku'])
            ->where('status', 'menunggu konfirmasi')
            ->orderBy('created_at','desc')
            ->get();

        $dipinjam = Peminjaman::with(['user','buku'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderBy('tanggal_pinjam','desc')
            ->get();

        // TAB PROSES: dari peminjaman status 'proses pengembalian' dengan relasi proses_kembali
        $proses = Peminjaman::with(['user', 'buku'])
            ->where('status', 'proses pengembalian')
            ->orderBy('tanggal_pinjam','desc')
            ->get()
            ->load('prosesKembali');

        $selesai = Pengembalian::with(['peminjaman.user', 'peminjaman.buku', 'peminjaman.prosesKembali'])
            ->orderBy('tanggal_kembali','desc')
            ->get();

        return view('petugas.manajemenbuku_petugas', compact('menungguKonfirmasi','dipinjam','proses','selesai'));
    }

    // -------------------------
    // Laporan: render views + PDF
    // -------------------------
    public function laporanPeminjamanAktif()
    {
        $items = Peminjaman::with(['user','buku'])
            ->whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])
            ->orderBy('tanggal_pinjam','desc')
            ->get();

        $aktifCount = Peminjaman::whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])->count();
        $prosesCount = Peminjaman::where('status', 'proses pengembalian')->count();
        $selesaiCount = Pengembalian::count();

        return view('petugas.laporanpeminjamanaktif_petugas', compact('items', 'aktifCount', 'prosesCount', 'selesaiCount'));
    }

    public function laporanPeminjamanAktifPdf()
    {
        $items = Peminjaman::with(['user','buku'])
            ->whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])
            ->orderBy('tanggal_pinjam','desc')
            ->get();

        $pdf = Pdf::loadView('petugas.laporanpeminjamanaktif_pdf_petugas', compact('items'));
        return $pdf->download('laporan_peminjaman_aktif_'.date('Ymd').'.pdf');
    }

    public function laporanProsesPengembalian()
    {
        $items = Peminjaman::with(['user','buku','prosesKembali'])
            ->where('status', 'proses pengembalian')
            ->orderBy('tanggal_pinjam','desc')
            ->get();

        $aktifCount = Peminjaman::whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])->count();
        $prosesCount = Peminjaman::where('status', 'proses pengembalian')->count();
        $selesaiCount = Pengembalian::count();

        return view('petugas.laporanprosespengembalin_petugas', compact('items', 'aktifCount', 'prosesCount', 'selesaiCount'));
    }

    public function laporanProsesPengembalianPdf()
    {
        $items = Peminjaman::with(['user','buku','prosesKembali'])
            ->where('status', 'proses pengembalian')
            ->orderBy('tanggal_pinjam','desc')
            ->get();

        $pdf = Pdf::loadView('petugas.laporanprosespengembalian_pdf_petugas', compact('items'));
        return $pdf->download('laporan_proses_pengembalian_'.date('Ymd').'.pdf');
    }

    public function laporanSelesai()
    {
        $items = Pengembalian::with(['peminjaman.user','peminjaman.buku'])
            ->orderBy('tanggal_kembali','desc')
            ->get();

        $aktifCount = Peminjaman::whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])->count();
        $prosesCount = Peminjaman::where('status', 'proses pengembalian')->count();
        $selesaiCount = Pengembalian::count();

        return view('petugas.laporanselesai_petugas', compact('items', 'aktifCount', 'prosesCount', 'selesaiCount'));
    }

    public function laporanSelesaiPdf()
    {
        $items = Pengembalian::with(['peminjaman.user','peminjaman.buku'])
            ->orderBy('tanggal_kembali','desc')
            ->get();

        $pdf = Pdf::loadView('petugas.laporanselesai_pdf_petugas', compact('items'));
        return $pdf->download('laporan_pengembalian_selesai_'.date('Ymd').'.pdf');
    }

    public function laporanUser()
    {
        $user = User::orderBy('tanggal_bergabung', 'asc')->get();
        return view('petugas.laporanuser_petugas', compact('user'));
    }

    public function laporanUserPdf()
    {
        $user = User::orderBy('tanggal_bergabung', 'asc')->get();
        $pdf = Pdf::loadView('petugas.laporanuser_pdf_petugas', compact('user'));
        return $pdf->download('laporan_data_user_'.date('Ymd').'.pdf');
    }

    // -------------------------
    // Laporan Buku (Views + PDF downloads)
    // -------------------------
    public function laporanBukuProses()
    {
        $buku = Buku::with('kategori')->where('status', 'menunggu')->get();
        $bukuMenunggu = Buku::where('status', 'menunggu')->get();
        $bukuDisetujui = Buku::where('status', 'disetujui')->get();
        $bukuDitolak = Buku::where('status', 'ditolak')->get();
        return view('petugas.laporanbukuproses_petugas', compact('buku', 'bukuMenunggu', 'bukuDisetujui', 'bukuDitolak'));
    }

    public function laporanBukuDisetujui()
    {
        $buku = Buku::with('kategori')->where('status', 'disetujui')->get();
        $bukuMenunggu = Buku::where('status', 'menunggu')->get();
        $bukuDisetujui = Buku::where('status', 'disetujui')->get();
        $bukuDitolak = Buku::where('status', 'ditolak')->get();
        return view('petugas.laporanbukudisetujui_petugas', compact('buku', 'bukuMenunggu', 'bukuDisetujui', 'bukuDitolak'));
    }

    public function laporanBukuDitolak()
    {
        $buku = Buku::with('kategori')->where('status', 'ditolak')->get();
        $bukuMenunggu = Buku::where('status', 'menunggu')->get();
        $bukuDisetujui = Buku::where('status', 'disetujui')->get();
        $bukuDitolak = Buku::where('status', 'ditolak')->get();
        return view('petugas.laporanbukuditolak_petugas', compact('buku', 'bukuMenunggu', 'bukuDisetujui', 'bukuDitolak'));
    }

    public function laporanBukuProsesPdf()
    {
        $buku = Buku::with('kategori')->where('status', 'menunggu')->get();

        $pdf = Pdf::loadView('petugas.laporanbukuproses_pdf_petugas', compact('buku'));
        return $pdf->download('laporan_buku_proses_'.date('Ymd').'.pdf');
    }

    public function laporanBukuDisetujuiPdf()
    {
        $buku = Buku::with('kategori')->where('status', 'disetujui')->get();

        $pdf = Pdf::loadView('petugas.laporanbukudisetujui_pdf_petugas', compact('buku'));
        return $pdf->download('laporan_buku_disetujui_'.date('Ymd').'.pdf');
    }

    public function laporanBukuDitolakPdf()
    {
        $buku = Buku::with('kategori')->where('status', 'ditolak')->get();

        $pdf = Pdf::loadView('petugas.laporanbukuditolak_pdf_petugas', compact('buku'));
        return $pdf->download('laporan_buku_ditolak_'.date('Ymd').'.pdf');
    }

    public function laporanUnified(Request $request)
    {
        $tab = $request->query('tab', 'aktif');
        
        if ($tab === 'proses') {
            $items = Peminjaman::with(['user','buku','prosesKembali'])
                ->where('status', 'proses pengembalian')
                ->orderBy('tanggal_pinjam','desc')
                ->get();
            $title = 'Laporan Proses Pengembalian';
            $pdfRoute = route('petugas.laporan.proses_pengembalian_pdf');
        } elseif ($tab === 'selesai') {
            $items = Pengembalian::with(['peminjaman.user','peminjaman.buku'])
                ->orderBy('tanggal_kembali','desc')
                ->get();
            $title = 'Laporan Pengembalian Selesai';
            $pdfRoute = route('petugas.laporan.selesai_pdf');
        } else {
            $items = Peminjaman::with(['user','buku'])
                ->whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])
                ->orderBy('tanggal_pinjam','desc')
                ->get();
            $title = 'Laporan Peminjaman Aktif';
            $pdfRoute = route('petugas.laporan.peminjaman_aktif_pdf');
        }

        return view('petugas.laporan_unified', compact('tab', 'items', 'title', 'pdfRoute'));
    }

    public function setujuiPeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu konfirmasi') {
            return back()->with('error', 'Peminjaman ini tidak dapat disetujui (status tidak menunggu konfirmasi)');
        }

        // Kurangi stok buku saat peminjaman disetujui
        $buku = Buku::find($peminjaman->buku_id);
        if ($buku && $buku->stok > 0) {
            $buku->stok = max(0, $buku->stok - 1);
            $buku->save();
        }

        $peminjaman->update(['status' => 'dipinjam']);

        return back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    public function tolakPeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->status !== 'menunggu konfirmasi') {
            return back()->with('error', 'Peminjaman ini tidak dapat ditolak (status tidak menunggu konfirmasi)');
        }

        $peminjaman->delete();

        return back()->with('success', 'Peminjaman berhasil ditolak!');
    }

    public function prosesPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update(['status' => 'proses']);

        ProsesKembali::create([
            'peminjaman_id' => $peminjaman->id,
            'user_id' => $peminjaman->user_id,
            'buku_id' => $peminjaman->buku_id,
            'tanggal_kembali' => $peminjaman->tanggal_kembali,
            'tanggal_dikembalikan' => now()->format('Y-m-d'),
            'kondisi_buku' => 'baik',
            'denda' => 0,
        ]);

        return back()->with('success', 'Berhasil diproses!');
    }

    public function selesaiPengembalian(Request $request, $id)
    {
        $request->validate([
            'kondisi_buku' => 'required|string',
            'denda' => 'required|numeric|min:0',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'proses pengembalian') {
            return back()->with('error', 'Status tidak valid untuk diselesaikan');
        }

        // Cari record proses_kembali
        $prosesRec = ProsesKembali::where('peminjaman_id', $peminjaman->id)->first();

        if (!$prosesRec) {
            return back()->with('error', 'Data proses pengembalian tidak ditemukan. Silakan proses terlebih dahulu.');
        }

        // Update peminjaman status ke selesai
        $peminjaman->update(['status' => 'selesai']);

        // Kelola stok buku: tambah stok jika kondisi buku baik (tidak rusak/hilang)
        $buku = Buku::find($peminjaman->buku_id);
        if ($buku) {
            $kondisiBuku = $request->input('kondisi_buku');
            $kondisiArr = explode(',', $kondisiBuku);
            $isBukuBaik = !in_array('rusak', $kondisiArr) && !in_array('hilang', $kondisiArr);

            if ($isBukuBaik) {
                $buku->stok += 1;
                $buku->save();
            }
            // Jika rusak atau hilang, stok tidak bertambah (buku dianggap tidak tersedia)
        }

        // Catat ke pengembalianbuku dengan data dari request
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'prosespengembalian_id' => $prosesRec->id,
            'tanggal_kembali' => $prosesRec->tanggal_dikembalikan,
            'kondisi_buku' => $request->input('kondisi_buku'),
            'denda' => $request->input('denda'),
            'catatan' => 'Pengembalian selesai oleh petugas',
        ]);

        return back()->with('success', 'Pengembalian buku diterima dan selesai');
    }

    public function user()
    {
        $user = User::all();
        return view('petugas.user_petugas', compact('user'));
    }

    public function profile()
    {
        $petugas = auth('petugas')->user();
        return view('petugas.profile_petugas', compact('petugas'));
    }

    public function prosesKembali(Request $request, $peminjaman_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman_id);
        $user = User::findOrFail($peminjaman->user_id);

        $tanggal_seharusnya = $peminjaman->tanggal_kembali;
        $tanggal_sebenarnya = now()->toDateString();

        $kondisiInput = $request->input('kondisi_buku');
        $denda = 0;
        $poinTambah = 0;
        $buku = Buku::findOrFail($peminjaman->buku_id);
        $hargaBuku = $buku->harga ?? 0;

        // Normalize kondisi: support both single string and array of conditions
        if (is_array($kondisiInput)) {
            $kondisiArr = $kondisiInput;
        } else {
            $kondisiArr = $kondisiInput ? [ $kondisiInput ] : ['baik'];
        }

        // compute days late
        $hari_telat = 0;
        if ($tanggal_seharusnya) {
            try {
                $hari_telat = Carbon::parse($tanggal_seharusnya)->diffInDays(Carbon::parse($tanggal_sebenarnya));
            } catch (\Exception $e) {
                $hari_telat = 0;
            }
        }

        // If 'baik' is present with others, ignore 'baik' (others take precedence)
        if (in_array('baik', $kondisiArr) && count($kondisiArr) > 1) {
            $effective = array_values(array_filter($kondisiArr, fn($k) => $k !== 'baik'));
        } else {
            $effective = $kondisiArr;
        }

        // Perhitungan denda berdasarkan kondisi buku dan harga buku
        foreach ($effective as $k) {
            if ($k === 'baik') {
                // Denda keterlambatan tetap ada untuk kondisi baik
                if ($hari_telat > 0) {
                    $denda += $hari_telat * 5000;
                }
                $poinTambah += 0;
            } elseif ($k === 'rusak_ringan') {
                $denda += $hargaBuku * 0.1; // 10% harga buku
                $poinTambah += 10;
            } elseif ($k === 'rusak_berat') {
                $denda += $hargaBuku * 0.3; // 30% harga buku
                $poinTambah += 20;
            } elseif ($k === 'hilang') {
                $denda += $hargaBuku * 1.0; // 100% harga buku
                $poinTambah += 30;
            }
        }

        // store kondisi as comma-separated string for backward compatibility
        $kondisi = implode(',', $effective);

        // Cek atau update proses_kembali record
        $prosesRec = ProsesKembali::where('peminjaman_id', $peminjaman->id)->first();
        
        // Proses denda: gunakan input manual jika ada, jika tidak gunakan perhitungan otomatis
        $dendaInput = $request->input('denda');
        $dendaFinal = $dendaInput !== null && $dendaInput !== '' ? (int)$dendaInput : $denda;
        
        if (!$prosesRec) {
            $prosesRec = ProsesKembali::create([
                'peminjaman_id' => $peminjaman->id,
                'user_id' => $user->id,
                'buku_id' => $peminjaman->buku_id,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_kembali' => $tanggal_seharusnya,
                'tanggal_dikembalikan' => $tanggal_sebenarnya,
                'kondisi_buku' => $kondisi,
                'denda' => $dendaFinal,
                'hari_keterlambatan' => $hari_telat,
            ]);
        } else {
            $prosesRec->update([
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_dikembalikan' => $tanggal_sebenarnya,
                'kondisi_buku' => $kondisi,
                'denda' => $dendaFinal,
                'hari_keterlambatan' => $hari_telat,
            ]);
        }

        if ($poinTambah > 0) {
            $user->increment('poin', $poinTambah);
        }

        return back()->with('success', 'Pengembalian berhasil diproses! Denda: Rp ' . number_format($dendaFinal, 0, ',', '.'));
    }
}