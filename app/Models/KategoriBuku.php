<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    protected $table = 'kategoribuku'; // tetap sesuai database
    protected $fillable = ['nama_kategori'];

    public function buku()
    {
        return $this->belongsToMany(
            Buku::class,
            'kategoribuku_relasi', // pivot table
            'kategoribuku_id',     // foreign key ke KategoriBuku
            'buku_id'              // foreign key ke Buku
        );
    }
}
