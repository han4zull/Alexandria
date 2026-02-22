<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesKembali extends Model
{
    use HasFactory;

    protected $table = 'proses_kembali';

    protected $fillable = [
        'peminjaman_id',
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'kondisi_buku',
        'denda',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'proseskembali_id');
    }
}