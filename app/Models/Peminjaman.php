<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'buku_id',
        'nama_lengkap',
        'alamat',
        'nomer_hp',
        'foto_ktp',
        'tanggal_pinjam',
        'tanggal_kembali',
        'durasi',
        'status',
        'kode_pinjam',
        'qr_payload',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to Buku
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Relationship to ProsesKembali
     */
    public function prosesKembali()
    {
        return $this->hasOne(ProsesKembali::class);
    }
}
