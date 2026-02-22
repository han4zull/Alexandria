<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjaman', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable();
            }
            if (!Schema::hasColumn('peminjaman', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (!Schema::hasColumn('peminjaman', 'nomer_hp')) {
                $table->string('nomer_hp')->nullable();
            }
            if (!Schema::hasColumn('peminjaman', 'kode_pinjam')) {
                $table->string('kode_pinjam')->nullable()->unique();
            }
            if (!Schema::hasColumn('peminjaman', 'qr_payload')) {
                $table->text('qr_payload')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            if (Schema::hasColumn('peminjaman', 'nama_lengkap')) {
                $table->dropColumn('nama_lengkap');
            }
            if (Schema::hasColumn('peminjaman', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('peminjaman', 'nomer_hp')) {
                $table->dropColumn('nomer_hp');
            }
            if (Schema::hasColumn('peminjaman', 'kode_pinjam')) {
                $table->dropColumn('kode_pinjam');
            }
            if (Schema::hasColumn('peminjaman', 'qr_payload')) {
                $table->dropColumn('qr_payload');
            }
        });
    }
};
