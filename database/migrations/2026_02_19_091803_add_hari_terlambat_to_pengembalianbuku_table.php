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
        Schema::table('pengembalianbuku', function (Blueprint $table) {
            $table->integer('hari_terlambat')->default(0)->after('denda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengembalianbuku', function (Blueprint $table) {
            $table->dropColumn('hari_terlambat');
        });
    }
};
