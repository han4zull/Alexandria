<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'isbn',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'deskripsi',
        'cover',
        'status',
        'alasan_tolak',
    ];

    // Relasi ke kategori (pivot)
    public function kategori()
    {
        return $this->belongsToMany(
            KategoriBuku::class,      
            'kategoribuku_relasi',     
            'buku_id',                 
            'kategoribuku_id'         
        );
    }

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Relasi ke ulasan
    public function ulasanBuku()
    {
        return $this->hasMany(UlasanBuku::class);
    }
}