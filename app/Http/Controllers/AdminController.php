<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Petugas;
use App\Models\Admin;
use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\ProsesKembali;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // ==========================
    // BERANDA ADMIN
    // ==========================
   public function dashboard()
{
$admin = Auth::guard('admin')->user();


$stats = [
    'user'     => \App\Models\User::count(),
    'buku'     => \App\Models\Buku::count(),
    'dipinjam' => \App\Models\Peminjaman::count(),
    // use localized status values used elsewhere in views/controllers
    'pending'  => \App\Models\Buku::where('status', 'menunggu')->count(),
    'approved' => \App\Models\Buku::where('status', 'disetujui')->count(),
    'rejected' => \App\Models\Buku::where('status', 'ditolak')->count(),
    'petugas'  => \App\Models\Petugas::count(),
    'proses_kembali' => \App\Models\ProsesKembali::count(),
    'dikembalikan' => \App\Models\Peminjaman::where('status', 'dikembalikan')->count(),
];


return view('admin.br_admin', compact('admin', 'stats'));
}
    // ==========================
    // DATA BUKU
    // ==========================
    public function buku()
    {
        $admin = Auth::guard('admin')->user();
        $buku = Buku::all();
        $kategori = KategoriBuku::all(); // ambil semua kategori
        return view('admin.buku_admin', compact('admin', 'buku','kategori'));
    }

    public function createBuku()
    {
        $kategori = KategoriBuku::all();
        return view('admin.bukutambah_admin', compact('kategori'));
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
            // admin-created books are published immediately
            'status' => 'disetujui',
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

        return redirect()->route('buku_admin')->with('success', 'Buku berhasil disimpan');
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
        return view('admin.bukuedit_admin', compact('buku','kategori'));
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

    // Sync kategori
    $buku->kategori()->sync([$request->kategori_id]);

    return redirect()->route('buku_admin')->with('success', 'Buku berhasil diperbarui.');
}

    // Hapus buku
public function destroyBuku($id)
{
    $buku = Buku::findOrFail($id);

    // Hapus file cover jika ada
    if (!empty($buku->cover)) {
        Storage::disk('public')->delete($buku->cover);
    }

    // Lepas relasi kategori (many-to-many)
    $buku->kategori()->detach();

    // Hapus data buku
    $buku->delete();

    // Jika request AJAX
    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus',
        ]);
    }

    // Jika request biasa
    return redirect()
        ->route('buku_admin')
        ->with('success', 'Buku berhasil dihapus.');
}


    public function laporanBuku()
    {
        $buku = Buku::all();

        // Get counts for different report types
        $aktifCount = Peminjaman::whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])->count();
        $prosesCount = Peminjaman::where('status', 'proses pengembalian')->count();
        $selesaiCount = Pengembalian::count();

        return view('admin.laporan_buku', compact('buku', 'aktifCount', 'prosesCount', 'selesaiCount'));
    }

    public function setujuiBuku($id)
{
    $buku = Buku::findOrFail($id);
    $buku->status = 'disetujui';
    $buku->alasan_tolak = null; // reset alasan jika ada
    $buku->save();

    if (request()->ajax()) {
        return response()->json(['success' => true, 'message' => 'Buku berhasil disetujui']);
    }

    return redirect()->back()->with('success', 'Buku berhasil disetujui');
}

    public function tolakBuku(Request $request, $id)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|max:500'
        ]);

        $buku = Buku::findOrFail($id);
        $buku->status = 'ditolak';
        $buku->alasan_tolak = $request->alasan_tolak;
        $buku->save();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Buku berhasil ditolak']);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditolak');
    }


    // ==========================
    // DATA PETUGAS
    // ==========================
    public function petugas()
{
    $petugas = Petugas::all();
    return view('admin.petugas_admin', compact('petugas'));
}

public function indexPetugas()
{
    $petugas = Petugas::orderBy('created_at','desc')->get();
    return view('admin.petugas_admin', compact('petugas'));
}

public function createPetugas()
{
    return view('admin.petugastambah_admin');
}

public function storePetugas(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'username' => 'required|unique:petugas,username',
        'email' => 'required|email|unique:petugas,email',
        'password' => 'required|min:6',
        'jenis_kelamin' => 'required',
        'foto_profil' => 'nullable|image|max:2048'
    ]);

    // Upload foto profil jika ada
    $fotoPath = null;
    if($request->hasFile('foto_profil')){
        $fotoPath = $request->file('foto_profil')->store('petugas', 'public');
    }

   Petugas::create([
    'nama' => $request->nama,
    'username' => $request->username, // <- wajib ini
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'password_plain' => $request->password,
    'jenis_kelamin' => $request->jenis_kelamin,
    'role' => $request->role ?? 'petugas',
    'foto_profil' => $fotoPath ?? null,
    'tanggal_dibuat' => $request->tanggal_dibuat ?? now()->format('Y-m-d'),
    'created_at' => now(),
    'updated_at' => now(),
]);

    return redirect()->route('petugas_admin')
        ->with('success', 'Petugas berhasil ditambahkan!');
}

public function editPetugas($id)
{
    $petugas = Petugas::findOrFail($id);
    return view('admin.petugasedit_admin', compact('petugas'));
}

public function updatePetugas(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:petugas,email,' . $id,
        'username' => 'required|unique:petugas,username,' . $id,
        'foto_profil' => 'nullable|image|max:2048',
        'password' => 'nullable|min:6',
    ]);

    $petugas = Petugas::findOrFail($id);

    // Update nama, email & username
    $petugas->nama = $request->nama;
    $petugas->email = $request->email;
    $petugas->username = $request->username;

    // Update password jika ada
    if($request->password){
        $petugas->password = Hash::make($request->password);
        $petugas->password_plain = $request->password;
    }

    // Update foto jika ada
    if($request->hasFile('foto_profil')){
        $fotoPath = $request->file('foto_profil')->store('petugas', 'public');
        $petugas->foto_profil = $fotoPath;
    }

    $petugas->save();

    return redirect()->route('petugas_admin')
                     ->with('success', 'Petugas berhasil diupdate!');
}

public function deletePetugas($id)
{
    $petugas = Petugas::findOrFail($id);
    $petugas->delete();

    return redirect()->route('admin.petugas')->with('success', 'Petugas berhasil dihapus!');
}


    // ==========================
    // DATA USER
    // ==========================
    public function user()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.user_admin', compact('users'));
    }

    public function blokir($id)
{
    $user = User::findOrFail($id);

    if ($user->poin > 100) {
        $user->update(['status' => 'diblokir']);
    }

    return back()->with('success', 'User berhasil diblokir');
}

    // ==========================
    // PROFILE ADMIN (LOGIN)
    // ==========================
    public function profile()
    {
        $admin = auth()->user();
        return view('admin.profile_admin', compact('admin'));
    }

    public function profileEdit()
    {
        $admin = auth()->user();
        return view('admin.profileedit_admin', compact('admin'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:admin,email,' . auth()->id(),
            'jenis_kelamin' => 'nullable|in:L,P',
            'foto_profil' => 'nullable|image|max:2048',
            'password' => 'nullable|min:6',
        ]);

        $admin = auth()->user();

        // Update data admin
        $admin->nama = $request->nama;
        $admin->email = $request->email;
        $admin->jenis_kelamin = $request->jenis_kelamin;

        // Update password jika ada
        if($request->password){
            $admin->password = Hash::make($request->password);
        }

        // Update foto jika ada
        if($request->hasFile('foto_profil')){
            $fotoPath = $request->file('foto_profil')->store('admin', 'public');
            $admin->foto_profil = $fotoPath;
        }

        $admin->save();

        return redirect()->route('profile_admin')
                         ->with('success', 'Profile berhasil diupdate!');
    }


   // =========================
   // MANAJEMEN BUKU
   // =========================
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

$proses = Peminjaman::with(['user','buku'])
    ->where('status', 'proses pengembalian')
    ->orderBy('tanggal_pinjam','desc')
    ->get();

$selesai = Pengembalian::with(['peminjaman.user', 'peminjaman.buku', 'peminjaman.prosesKembali'])
    ->orderBy('tanggal_kembali','desc')
    ->get();

return view('admin.manajemenbuku_admin', compact('menungguKonfirmasi','dipinjam','proses','selesai'));
}

public function prosesPengembalian($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    // update status jadi proses
    $peminjaman->update(['status' => 'proses']);

    // buat record proses_pengembalian (contoh)
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

public function selesaiPengembalian($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    $proses = ProsesKembali::where('peminjaman_id', $peminjaman->id)->first();

    // update status jadi selesai
    $peminjaman->update(['status' => 'selesai']);

    // Kelola stok buku: tambah stok jika kondisi buku baik (tidak rusak/hilang)
    $buku = Buku::find($peminjaman->buku_id);
    if ($buku) {
        $kondisiArr = explode(',', $proses->kondisi_buku);
        $isBukuBaik = !in_array('rusak', $kondisiArr) && !in_array('hilang', $kondisiArr);

        if ($isBukuBaik) {
            $buku->stok += 1;
            $buku->save();
        }
        // Jika rusak atau hilang, stok tidak bertambah (buku dianggap tidak tersedia)
    }

    // buat record pengembalian final
    Pengembalian::create([
        'peminjaman_id' => $peminjaman->id,
        'prosespengembalian_id' => $proses->id,
        'tanggal_kembali' => now()->format('Y-m-d'),
        'kondisi_buku' => $proses->kondisi_buku,
        'denda' => $proses->denda,
        'catatan' => 'Pengembalian selesai',
    ]);

    return back()->with('success', 'Pengembalian selesai!');
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
                $hari_telat = \Carbon\Carbon::parse($tanggal_seharusnya)->diffInDays(\Carbon\Carbon::parse($tanggal_sebenarnya));
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
            } elseif ($k === 'rusak') {
                $denda += $hargaBuku * 0.3; // 30% harga buku
                $poinTambah += 20;
            } elseif ($k === 'hilang') {
                $denda += $hargaBuku * 1.0; // 100% harga buku
                $poinTambah += 30;
            } elseif ($k === 'telat') {
                if ($hari_telat > 0) {
                    $denda += $hari_telat * 5000;
                    $poinTambah += 10;
                }
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

// Setujui peminjaman (admin)
public function setujuiPeminjaman($id)
{
    $p = Peminjaman::findOrFail($id);

    if (strtolower(trim($p->status)) !== 'menunggu konfirmasi') {
        return back()->with('error', 'Status peminjaman bukan menunggu konfirmasi.');
    }

    $buku = Buku::find($p->buku_id);
    if ($buku && $buku->stok > 0) {
        $buku->stok = max(0, $buku->stok - 1);
        $buku->save();
    }

    if (!$p->tanggal_pinjam) {
        $p->tanggal_pinjam = now()->toDateString();
    }
    if (!$p->tanggal_kembali) {
        $p->tanggal_kembali = \Carbon\Carbon::parse($p->tanggal_pinjam)->addDays($p->durasi)->toDateString();
    }

    $p->status = 'dipinjam';
    $p->save();

    return back()->with('success', 'Peminjaman berhasil disetujui.');
}

// Tolak peminjaman (admin)
public function tolakPeminjaman($id)
{
    $p = Peminjaman::findOrFail($id);

    if (strtolower(trim($p->status)) !== 'menunggu konfirmasi') {
        return back()->with('error', 'Status peminjaman bukan menunggu konfirmasi.');
    }

    $p->status = 'ditolak';
    $p->save();

    return back()->with('success', 'Peminjaman berhasil ditolak.');
}

public function edit($id)
{
$admin = Admin::findOrFail($id);
return view('admin.adminedit_admin', compact('admin'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:admin,email,' . $id,
        'jenis_kelamin' => 'nullable|in:L,P',
        'foto_profil' => 'nullable|image|max:2048',
        'password' => 'nullable|min:6',
    ]);

    $admin = Admin::findOrFail($id);

    // Update data admin
    $admin->nama = $request->nama;
    $admin->email = $request->email;
    $admin->jenis_kelamin = $request->jenis_kelamin;

    // Update password jika ada
    if($request->password){
        $admin->password = Hash::make($request->password);
    }

    // Update foto jika ada
    if($request->hasFile('foto_profil')){
        $fotoPath = $request->file('foto_profil')->store('petugas', 'public');
        $admin->foto_profil = $fotoPath;
    }

    $admin->save();

    return redirect()->route('profile_admin')
                     ->with('success', 'Admin berhasil diupdate!');
}

    // ==========================
    // AKUN ADMIN (Petugas dan User)
    // ==========================
    public function akun()
    {
        $petugas = Petugas::all();
        $users = User::where('role', 'user')->get();
        return view('admin.akun_admin', compact('petugas', 'users'));
    }

    // ==========================
    // LAPORAN ADMIN
    // ==========================
    public function laporanBukuProses()
    {
        $buku = Buku::with('kategori')->where('status', 'menunggu')->get();
        $bukuMenunggu = Buku::where('status', 'menunggu')->get();
        $bukuDisetujui = Buku::where('status', 'disetujui')->get();
        $bukuDitolak = Buku::where('status', 'ditolak')->get();
        return view('admin.laporanbukuproses_admin', compact('buku', 'bukuMenunggu', 'bukuDisetujui', 'bukuDitolak'));
    }

    public function laporanBukuDisetujui()
    {
        $buku = Buku::with('kategori')->where('status', 'disetujui')->get();
        $bukuMenunggu = Buku::where('status', 'menunggu')->get();
        $bukuDisetujui = Buku::where('status', 'disetujui')->get();
        $bukuDitolak = Buku::where('status', 'ditolak')->get();
        return view('admin.laporanbukudisetujui_admin', compact('buku', 'bukuMenunggu', 'bukuDisetujui', 'bukuDitolak'));
    }

    public function laporanBukuDitolak()
    {
        $buku = Buku::with('kategori')->where('status', 'ditolak')->get();
        $bukuMenunggu = Buku::where('status', 'menunggu')->get();
        $bukuDisetujui = Buku::where('status', 'disetujui')->get();
        $bukuDitolak = Buku::where('status', 'ditolak')->get();
        return view('admin.laporanbukuditolak_admin', compact('buku', 'bukuMenunggu', 'bukuDisetujui', 'bukuDitolak'));
    }

    public function laporanPeminjamanAktif()
    {
        $items = Peminjaman::with(['user','buku'])
            ->whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])
            ->orderBy('tanggal_pinjam','desc')
            ->get();

        $aktifCount = Peminjaman::whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])->count();
        $prosesCount = Peminjaman::where('status', 'proses pengembalian')->count();
        $selesaiCount = Pengembalian::count();

        return view('admin.laporanpeminjamanaktif_admin', compact('items', 'aktifCount', 'prosesCount', 'selesaiCount'));
    }

    public function laporanSelesai()
    {
        $items = Pengembalian::with(['peminjaman.user','peminjaman.buku'])
            ->orderBy('tanggal_kembali','desc')
            ->get();

        $aktifCount = Peminjaman::whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])->count();
        $prosesCount = Peminjaman::where('status', 'proses pengembalian')->count();
        $selesaiCount = Pengembalian::count();

        return view('admin.laporanselesai_admin', compact('items', 'aktifCount', 'prosesCount', 'selesaiCount'));
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

        return view('admin.laporanprosespengembalian_admin', compact('items', 'aktifCount', 'prosesCount', 'selesaiCount'));
    }

    // PDF Methods
    public function laporanBukuProsesPdf()
    {
        $buku = Buku::with('kategori')->where('status', 'menunggu')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporanbukuproses_pdf_admin', compact('buku'));
        return $pdf->download('laporan_buku_proses_'.date('Ymd').'.pdf');
    }

    public function laporanBukuDisetujuiPdf()
    {
        $buku = Buku::with('kategori')->where('status', 'disetujui')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporanbukudisetujui_pdf_admin', compact('buku'));
        return $pdf->download('laporan_buku_disetujui_'.date('Ymd').'.pdf');
    }

    public function laporanBukuDitolakPdf()
    {
        $buku = Buku::with('kategori')->where('status', 'ditolak')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporanbukuditolak_pdf_admin', compact('buku'));
        return $pdf->download('laporan_buku_ditolak_'.date('Ymd').'.pdf');
    }

    public function laporanPeminjamanAktifPdf()
    {
        $items = Peminjaman::with(['user','buku'])
            ->whereIn('status', ['dipinjam','terlambat','menunggu konfirmasi'])
            ->orderBy('tanggal_pinjam','desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporanpeminjamanaktif_pdf_admin', compact('items'));
        return $pdf->download('laporan_peminjaman_aktif_'.date('Ymd').'.pdf');
    }

    public function laporanSelesaiPdf()
    {
        $items = Pengembalian::with(['peminjaman.user','peminjaman.buku'])
            ->orderBy('tanggal_kembali','desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporanselesai_pdf_admin', compact('items'));
        return $pdf->download('laporan_pengembalian_selesai_'.date('Ymd').'.pdf');
    }

    public function laporanProsesPengembalianPdf()
    {
        $items = Peminjaman::with(['user','buku','prosesKembali'])
            ->where('status', 'proses pengembalian')
            ->orderBy('tanggal_pinjam','desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporanprosespengembalian_pdf_admin', compact('items'));
        return $pdf->download('laporan_proses_pengembalian_'.date('Ymd').'.pdf');
    }

    public function laporanPetugas()
    {
        $items = Petugas::all();

        return view('admin.laporanpetugas_admin', compact('items'));
    }

    public function laporanUser()
    {
        $items = User::all();

        return view('admin.laporanuser_admin', compact('items'));
    }

    public function laporanPetugasPdf()
    {
        $petugas = Petugas::all();
        $pdf = Pdf::loadView('admin.laporanpetugas_pdf_admin', compact('petugas'));
        return $pdf->download('laporan-petugas-' . date('Y-m-d') . '.pdf');
    }

    public function laporanUserPdf()
    {
        $user = User::all();
        $pdf = Pdf::loadView('admin.laporanuser_pdf_admin', compact('user'));
        return $pdf->download('laporan-user-' . date('Y-m-d') . '.pdf');
    }

    // ==========================
    // LAPORAN PETUGAS DETAIL
    // ==========================
    public function laporanPetugasAktif()
    {
        $petugas = Petugas::where('status', 'aktif')->get();
        return view('admin.laporanpetugasaktif_admin', compact('petugas'));
    }

    public function laporanPetugasNonaktif()
    {
        $petugas = Petugas::where('status', 'nonaktif')->get();
        return view('admin.laporanpetugasnonaktif_admin', compact('petugas'));
    }

    public function laporanPetugasSemua()
    {
        $petugas = Petugas::all();
        return view('admin.laporanpetugassemua_admin', compact('petugas'));
    }

    // ==========================
    // LAPORAN USER DETAIL
    // ==========================
    public function laporanUserAktif()
    {
        $users = User::where('status', 'aktif')->get();
        return view('admin.laporanuseraktif_admin', compact('users'));
    }

    public function laporanUserNonaktif()
    {
        $users = User::where('status', 'nonaktif')->get();
        return view('admin.laporanusernonaktif_admin', compact('users'));
    }

    public function laporanUserSemua()
    {
        $users = User::all();
        return view('admin.laporanusersemua_admin', compact('users'));
    }

    // ==========================
    // LAPORAN PETUGAS PDF
    // ==========================
    public function laporanPetugasAktifPdf()
    {
        $petugas = Petugas::where('status', 'aktif')->get();
        $pdf = Pdf::loadView('admin.laporanpetugas_pdf_admin', compact('petugas'));
        return $pdf->download('laporan_petugas_aktif_' . date('Y-m-d') . '.pdf');
    }

    public function laporanPetugasNonaktifPdf()
    {
        $petugas = Petugas::where('status', 'nonaktif')->get();
        $pdf = Pdf::loadView('admin.laporanpetugas_pdf_admin', compact('petugas'));
        return $pdf->download('laporan_petugas_nonaktif_' . date('Y-m-d') . '.pdf');
    }

    public function laporanPetugasSemuaPdf()
    {
        $petugas = Petugas::all();
        $pdf = Pdf::loadView('admin.laporanpetugas_pdf_admin', compact('petugas'));
        return $pdf->download('laporan_petugas_semua_' . date('Y-m-d') . '.pdf');
    }

    // ==========================
    // LAPORAN USER PDF
    // ==========================
    public function laporanUserAktifPdf()
    {
        $users = User::where('status', 'aktif')->get();
        $pdf = Pdf::loadView('admin.laporanuser_pdf_admin', compact('users'));
        return $pdf->download('laporan_user_aktif_' . date('Y-m-d') . '.pdf');
    }

    public function laporanUserNonaktifPdf()
    {
        $users = User::where('status', 'nonaktif')->get();
        $pdf = Pdf::loadView('admin.laporanuser_pdf_admin', compact('users'));
        return $pdf->download('laporan_user_nonaktif_' . date('Y-m-d') . '.pdf');
    }

    public function laporanUserSemuaPdf()
    {
        $users = User::all();
        $pdf = Pdf::loadView('admin.laporanuser_pdf_admin', compact('users'));
        return $pdf->download('laporan_user_semua_' . date('Y-m-d') . '.pdf');
    }

}