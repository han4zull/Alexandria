<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UlasanBuku;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Store a new review for a book
     */
    public function store(Request $request, $bukuId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
        ]);

        $user = Auth::user();
        $buku = Buku::findOrFail($bukuId);

        // Check if user has borrowed this book before
        $hasBorrowed = $user->peminjaman()
            ->where('buku_id', $bukuId)
            ->whereIn('status', ['selesai', 'dipinjam', 'proses pengembalian'])
            ->exists();

        if (!$hasBorrowed) {
            return back()->with('error', 'Anda hanya bisa memberikan ulasan untuk buku yang pernah dipinjam.');
        }

        // Create or update review
        UlasanBuku::updateOrCreate(
            ['user_id' => $user->id, 'buku_id' => $bukuId],
            [
                'rating' => $request->rating,
                'ulasan' => $request->review,
            ]
        );

        return back()->with('success', 'Ulasan berhasil disimpan!');
    }

    /**
     * Update an existing review
     */
    public function update(Request $request, $bukuId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
        ]);

        $user = Auth::user();

        $ulasan = UlasanBuku::where('user_id', $user->id)
            ->where('buku_id', $bukuId)
            ->firstOrFail();

        $ulasan->update([
            'rating' => $request->rating,
            'ulasan' => $request->review,
        ]);

        return back()->with('success', 'Ulasan berhasil diperbarui!');
    }

    /**
     * Delete a review
     */
    public function destroy($bukuId)
    {
        $user = Auth::user();

        $ulasan = UlasanBuku::where('user_id', $user->id)
            ->where('buku_id', $bukuId)
            ->firstOrFail();

        $ulasan->delete();

        return back()->with('success', 'Ulasan berhasil dihapus!');
    }

    /**
     * Get reviews for a specific book (API endpoint)
     */
    public function getBookReviews($bukuId)
    {
        $reviews = UlasanBuku::where('buku_id', $bukuId)
            ->with('user:id,username,nama_lengkap')
            ->latest()
            ->get();

        return response()->json($reviews);
    }

    /**
     * Get user's reviews
     */
    public function getUserReviews()
    {
        $user = Auth::user();

        $reviews = UlasanBuku::where('user_id', $user->id)
            ->with('buku:id,judul,cover,penulis')
            ->latest()
            ->get();

        return view('user.ulasan_user', compact('reviews'));
    }
}