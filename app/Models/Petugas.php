<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Petugas extends Authenticatable
{
    use HasFactory;

    protected $table = 'petugas';
    protected $guard = 'petugas';

    protected $fillable = [
    'nama',
    'username',
    'email',
    'password',
    'password_plain', // <- tambahkan ini
    'role',
    'tanggal_dibuat',
    'foto_profil',
    'jenis_kelamin',
    'status',
];

    protected $hidden = ['password'];

}