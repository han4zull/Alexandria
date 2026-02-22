<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $guard = 'admin';
    protected $fillable = ['nama', 'email', 'password', 'role', 'tanggal_dibuat', 'foto_profil', 'jenis_kelamin'];
    public $timestamps = false;
}