<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add 'menunggu konfirmasi' to the enum values
        DB::statement("ALTER TABLE `peminjaman` MODIFY `status` ENUM('dipinjam','menunggu konfirmasi','terlambat','selesai') NOT NULL DEFAULT 'dipinjam';");
    }

    public function down()
    {
        // Revert to previous enum without 'menunggu konfirmasi'
        DB::statement("ALTER TABLE `peminjaman` MODIFY `status` ENUM('dipinjam','terlambat','selesai') NOT NULL DEFAULT 'dipinjam';");
    }
};
