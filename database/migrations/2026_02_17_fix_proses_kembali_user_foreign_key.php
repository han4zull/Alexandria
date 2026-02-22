<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the incorrect foreign key
        Schema::table('proses_kembali', function (Blueprint $table) {
            $table->dropForeign('proses_kembali_user_id_foreign');
        });

        // Add the correct foreign key referencing 'user' table
        Schema::table('proses_kembali', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proses_kembali', function (Blueprint $table) {
            $table->dropForeign('proses_kembali_user_id_foreign');
        });

        Schema::table('proses_kembali', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });
    }
};
