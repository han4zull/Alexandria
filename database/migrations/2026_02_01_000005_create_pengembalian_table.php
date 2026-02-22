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
        Schema::create('pengembalianbuku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id')->nullable();
            $table->unsignedBigInteger('prosespengembalian_id')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->string('kondisi_buku')->nullable();
            $table->decimal('denda', 10, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->integer('rating')->nullable()->comment('1-5 stars');
            $table->text('review')->nullable();
            $table->timestamps();

            $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalianbuku');
    }
};
