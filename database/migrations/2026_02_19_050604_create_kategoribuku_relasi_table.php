<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategoribuku_relasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buku_id');
            $table->unsignedBigInteger('kategoribuku_id');
            $table->timestamps();

            $table->foreign('buku_id')->references('id')->on('buku')->onDelete('cascade');
            $table->foreign('kategoribuku_id')->references('id')->on('kategoribuku')->onDelete('cascade');
            $table->unique(['buku_id', 'kategoribuku_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoribuku_relasi');
    }
};
