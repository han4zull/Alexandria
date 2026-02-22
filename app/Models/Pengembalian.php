<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalianbuku';

    protected $fillable = [
        'peminjaman_id',
        'prosespengembalian_id',
        'tanggal_kembali',
        'kondisi_buku',
        'denda',
        'hari_terlambat',
        'catatan',
        'rating',
        'review',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function prosesPengembalian()
    {
        return $this->belongsTo(ProsesPengembalian::class, 'prosespengembalian_id');
    }
}