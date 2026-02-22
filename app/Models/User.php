<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // **ini yang bikin Laravel pakai tabel "user"**
    protected $table = 'user';
    public $timestamps = false;

    // Set guard untuk guard 'web'
    protected $guard = 'web';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'no_anggota',
        'tanggal_bergabung',
        'poin',
        'nama_lengkap',
        'alamat',
        'nomer_hp',
        'foto_profil',
        'jenis_kelamin',
        'status',
    ];
    


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke saved books
    public function savedBooks()
    {
        return $this->belongsToMany(Buku::class, 'saved_books', 'user_id', 'buku_id')->withTimestamps();
    }

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }
}