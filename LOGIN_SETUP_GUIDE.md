# PANDUAN LOGIN SISTEM ALEXANDRIA - MULTI ROLE

## 🎯 Cara Kerja Sistem Login

Login system ini menggunakan **multiple guards** untuk memisahkan user, admin, dan petugas:
- **User**: Guard `web` + table `user` + role check
- **Admin**: Guard `admin` + table `admin`
- **Petugas**: Guard `petugas` + table `petugas`

---

## 📋 LANGKAH SETUP

### 1️⃣ JALANKAN MIGRATIONS

```bash
php artisan migrate
```

Migrations akan membuat table:
- `admin` (id, email, password, timestamps)
- `petugas` (id, email, password, timestamps)
- `user` (sudah ada, diperbaiki dengan field role)

---

### 2️⃣ BUAT DATA ADMIN & PETUGAS (SEEDER)

Buat file `AdminSeeder.php`:

```bash
php artisan make:seeder AdminSeeder
```

Edit `database/seeders/AdminSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'email' => 'admin@alexandria.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
```

Buat file `PetugasSeeder.php`:

```bash
php artisan make:seeder PetugasSeeder
```

Edit `database/seeders/PetugasSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\Petugas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        Petugas::create([
            'email' => 'petugas@alexandria.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
```

Edit `database/seeders/DatabaseSeeder.php`:

```php
public function run(): void
{
    $this->call([
        AdminSeeder::class,
        PetugasSeeder::class,
    ]);
}
```

Jalankan seeder:

```bash
php artisan db:seed
```

---

### 3️⃣ VERIFIKASI KONFIGURASI

✅ **config/auth.php** - Sudah dikonfigurasi dengan 3 guards:
```php
'guards' => [
    'web' => ['driver' => 'session', 'provider' => 'user'],
    'admin' => ['driver' => 'session', 'provider' => 'admins'],
    'petugas' => ['driver' => 'session', 'provider' => 'petugass'],
],
```

✅ **bootstrap/app.php** - Middleware sudah registered:
```php
$middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

✅ **app/Models** - Semua model sudah updated dengan guard

---

## 🔐 CARA KERJA LOGIN

### Flow Login:

1. User mengisi email & password di form login
2. AuthController::login() dicek dalam urutan:
   - **Admin** (`auth()->guard('admin')->attempt()`)
   - **Petugas** (`auth()->guard('petugas')->attempt()`)
   - **User** (`auth()->guard('web')->attempt()`)
3. Jika cocok → session regenerate → redirect ke halaman sesuai role:
   - Admin → `/admin/br_admin` (route: `br_admin`)
   - Petugas → `/petugas/br_petugas` (route: `br_petugas`)
   - User → `/beranda` (route: `br_user`)

### Middleware Protection:

Setiap route dilindungi dengan:
```php
Route::middleware(['auth:GUARD', 'role:ROLE'])->group(function () {
    // routes
});
```

Contoh User:
```php
Route::middleware(['auth:web', 'role:user'])->group(function () {
    Route::get('/beranda', ...)->name('br_user');
});
```

---

## 🧪 TESTING LOGIN

### Test Admin:
```
Email: admin@alexandria.com
Password: password123
Expected Redirect: /admin/br_admin
```

### Test Petugas:
```
Email: petugas@alexandria.com
Password: password123
Expected Redirect: /petugas/br_petugas
```

### Test User:
```
Email: user@alexandria.com
Password: password123
Expected Redirect: /beranda
```

---

## 🚀 LOGOUT

Logout route sudah tersedia:
```php
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('akun.masuk');
})->name('logout');
```

---

## 📝 FORM LOGIN (YANG PERLU DIBUAT)

View login di `resources/views/akun/masuk.blade.php` harus include:

```blade
<form action="{{ route('akun.login') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
        @error('email') <span>{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
        @error('password') <span>{{ $message }}</span> @enderror
    </div>
    
    <button type="submit">Login</button>
</form>
```

---

## 🔍 DEBUG TIPS

Jika ada masalah:

1. **Cek session:**
```php
// Di controller
dd(auth()->guard('web')->check()); // untuk user
dd(auth()->guard('admin')->check()); // untuk admin
dd(auth()->guard('petugas')->check()); // untuk petugas
```

2. **Cek user terauth:**
```php
dd(auth()->guard('web')->user()); // lihat data user
```

3. **Cek route:**
```bash
php artisan route:list | grep br_
```

4. **Cek logs:**
```
storage/logs/laravel.log
```

---

## ✨ RINGKASAN PERUBAHAN

| File | Perubahan |
|------|-----------|
| `AuthController.php` | Login dengan multiple guard attempt |
| `RoleMiddleware.php` | Cek guard sesuai role |
| `routes/web.php` | Tambah `auth:GUARD` ke middleware |
| `bootstrap/app.php` | Register RoleMiddleware alias |
| `Models/User.php` | Tambah `protected $guard = 'web'` |
| `Models/Admin.php` | Tambah `protected $guard = 'admin'` |
| `Models/Petugas.php` | Tambah `protected $guard = 'petugas'` |
| Migrations | Buat table admin & petugas |

---

## 🎓 NEXT STEPS

1. ✅ Jalankan migration
2. ✅ Jalankan seeder untuk admin & petugas
3. ✅ Test login dengan 3 role
4. ✅ Buat view untuk error messages
5. ✅ Tambah remember me functionality (optional)
6. ✅ Implementasi password reset (optional)
