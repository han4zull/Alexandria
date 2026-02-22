<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProsesKembaliTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('proses_kembali')) {
            Schema::create('proses_kembali', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('peminjaman_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('buku_id');

                $table->date('tanggal_kembali_seharusnya');
                $table->date('tanggal_kembali_sebenarnya');
                $table->enum('kondisi_buku', ['baik', 'telat', 'rusak', 'hilang']);

                $table->integer('denda')->default(0);

                $table->timestamps();

                // relasi (opsional tapi bagus)
                $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('buku_id')->references('id')->on('buku')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('proses_kembali');
    }
}