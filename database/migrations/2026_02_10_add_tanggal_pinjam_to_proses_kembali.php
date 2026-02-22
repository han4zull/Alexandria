<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proses_kembali', function (Blueprint $table) {
            // Tambah kolom tanggal_pinjam sebelum tanggal_kembali_seharusnya
            $table->date('tanggal_pinjam')->nullable()->after('buku_id');
        });
    }

    public function down()
    {
        Schema::table('proses_kembali', function (Blueprint $table) {
            $table->dropColumn('tanggal_pinjam');
        });
    }
};
