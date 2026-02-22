<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\UlasanBuku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    /* =======================
     | DASHBOARD USER
     ======================= */
    public function dashboard()
    {
        $buku = Buku::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'DESC')
            ->get()
            ->map(function ($b) {
                $b->is_populer = $b->peminjaman_count >= 3;
                return $b;
            });

        return view('user.br_user', compact('buku'));
    }

    /* =======================
     | LIST BUKU
     ======================= */
    public function buku(Request $request)
    {
        $kategori = KategoriBuku::all();

        $buku = Buku::with('kategori')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($s) use ($request) {
                    $s->where('judul', 'like', "%{$request->search}%")
                      ->orWhere('pengarang', 'like', "%{$request->search}%");
                });
            })
            ->get();

        return view('user.buku_user', compact('kategori', 'buku'));
    }

    /* =======================
     | DETAIL BUKU
     ======================= */
    public function detailBuku($id)
    {
        $buku = Buku::findOrFail($id);
        
        // Check if user has returned this book
        $hasReturnedBook = false;
        if (auth()->check()) {
            // Check 1: Look for any pengembalian record for this book
            $hasPengembalianRecord = Pengembalian::whereHas('peminjaman', function($q) use ($id) {
                $q->where('buku_id', $id)->where('user_id', auth()->id());
            })->exists();
            
            // Check 2: Look for peminjaman status that indicates book is returned
            // (Any status other than dipinjam, menunggu konfirmasi, proses pengembalian, ditolak)
            $hasCompletedPeminjaman = Peminjaman::where('buku_id', $id)
                ->where('user_id', auth()->id())
                ->whereNotIn('status', ['dipinjam', 'menunggu konfirmasi', 'proses pengembalian', 'ditolak'])
                ->orderBy('created_at', 'desc')
                ->exists();
            
            $hasReturnedBook = $hasPengembalianRecord || $hasCompletedPeminjaman;
        }
        
        return view('user.detailbuku_user', compact('buku', 'hasReturnedBook'));
    }

    /* =======================
     | STATIC PAGES
     ======================= */
    public function landing()
    {
        // Ambil 5 buku terpopuler berdasarkan jumlah peminjaman
        $bukuPopuler = Buku::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->limit(5)
            ->get();

        // Ambil 4 ulasan terbaru dengan rating tertinggi
        $ulasanTerbaru = UlasanBuku::with(['user', 'buku'])
            ->whereNotNull('rating')
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('user.lp_user', compact('bukuPopuler', 'ulasanTerbaru'));
    }
    public function simpan()  { return view('user.simpan_user'); }
    public function riwayat() { return view('user.riwayat_user'); }

    /* =======================
     | PROFIL
     ======================= */
    public function profil()
    {
        return view('user.profil_user', ['user' => auth('web')->user()]);
    }

    public function editProfil()
    {
        return view('user.profileedit_user', ['user' => auth('web')->user()]);
    }

    public function updateProfil(Request $request)
    {
        $user = auth('web')->user();

        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat'       => 'required|string|max:1000',
            'nomer_hp'     => 'required|string|max:50',
            'foto_profil'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()
            ->route('profile_user')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /* =======================
     | FORM PINJAM
     ======================= */
    public function showBorrowForm($id)
    {
        $buku = Buku::findOrFail($id);
        return view('user.pinjam_form', compact('buku'));
    }

    /* =======================
     | SUBMIT PINJAM (FORM POST - NO AJAX)
     ======================= */
    public function submitBorrow(Request $request, $id)
    {
        // Validasi input
        $data = $request->validate([
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'durasi'          => 'nullable|integer|min:1|max:365',
            'foto_ktp'        => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil user yang login
        $user = auth('web')->user();
        
        // Jika tidak ada user, redirect ke login
        if (!$user) {
            return redirect()->route('akun.masuk')
                ->with('error', 'Sesi anda tidak valid. Silakan login ulang.');
        }

        // Validasi profil lengkap
        if (!$user->nama_lengkap || !$user->alamat || !$user->nomer_hp) {
            return redirect()->route('profile.edit')
                ->with('error', 'Profil belum lengkap. Silakan lengkapi terlebih dahulu.');
        }

        // Cek buku ada
        $buku = Buku::findOrFail($id);

        // Validasi stok
        if ($buku->stok < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Parse tanggal
        $tanggal_pinjam  = Carbon::parse($data['tanggal_pinjam']);
        $durasi          = $data['durasi'] ?? 7;
        $tanggal_kembali = isset($data['tanggal_kembali'])
            ? Carbon::parse($data['tanggal_kembali'])
            : (clone $tanggal_pinjam)->addDays($durasi);

        // Generate QR payload
        $qrPayload = json_encode([
            'buku_id' => $buku->id,
            'judul'   => $buku->judul,
            'user_id' => $user->id,
            'nama'    => $user->nama_lengkap,
            'alamat'  => $user->alamat,
            'hp'      => $user->nomer_hp,
            'pinjam'  => $tanggal_pinjam->toDateString(),
            'kembali' => $tanggal_kembali->toDateString(),
        ]);

        // Upload foto KTP
        $fotoKtpPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoKtpPath = $request->file('foto_ktp')->store('ktp', 'public');
        }

        // Simpan peminjaman
        try {
            $peminjaman = Peminjaman::create([
                'user_id'         => $user->id,
                'buku_id'         => $buku->id,
                'tanggal_pinjam'  => $tanggal_pinjam,
                'tanggal_kembali' => $tanggal_kembali,
                'durasi'          => $durasi,
                'status'          => 'menunggu konfirmasi',
                'nama_lengkap'    => $user->nama_lengkap,
                'alamat'          => $user->alamat,
                'nomer_hp'        => $user->nomer_hp,
                'foto_ktp'        => $fotoKtpPath,
                'kode_pinjam'     => Str::upper(Str::random(8)),
                'qr_payload'      => $qrPayload,
            ]);

            // Redirect ke halaman konfirmasi
            return redirect()->route('buku.pinjam.confirm', $peminjaman->id)
                ->with('success', 'Peminjaman Anda telah dikirim! Tunggu konfirmasi dari petugas/admin.');
        } catch (\Exception $e) {
            Log::error('submitBorrow exception', [
                'message' => $e->getMessage(),
                'user_id' => $user->id,
                'buku_id' => $buku->id,
            ]);

            $msg = app()->environment('local') 
                ? $e->getMessage() 
                : 'Terjadi kesalahan saat memproses peminjaman. Silakan coba lagi.';
            
            return back()->with('error', $msg)->withInput();
        }
    }

    /* =======================
     | KONFIRMASI PINJAM
     ======================= */
    public function confirmBorrow($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        abort_if($peminjaman->user_id !== auth('web')->id(), 403);

        // Ensure QR payload includes the booking code so scanning reveals the code
        $payload = [];
        if ($peminjaman->qr_payload) {
            $decoded = json_decode($peminjaman->qr_payload, true);
            if (is_array($decoded)) {
                $payload = $decoded;
            }
        }

        // Always include kode_pinjam and peminjaman_id
        $payload['kode_pinjam'] = $peminjaman->kode_pinjam;
        $payload['peminjaman_id'] = $peminjaman->id;

        $data = base64_encode(json_encode($payload));
        $qrImageUrl = route('qr.generate', ['data' => $data]);

        return view('user.pinjam_confirm', [
            'peminjaman'      => $peminjaman,
            'buku'            => $peminjaman->buku,
            'user'            => auth('web')->user(),
            'tanggal_pinjam'  => Carbon::parse($peminjaman->tanggal_pinjam),
            'tanggal_kembali' => Carbon::parse($peminjaman->tanggal_kembali),
            'qrImageUrl'      => $qrImageUrl,
            'fees' => [
                'telat_per_hari' => 5000,
                'rusak' => 50000,
                'hilang' => 100000,
            ],
        ]);
    }
}
