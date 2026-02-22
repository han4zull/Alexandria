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
        Schema::table('user', function (Blueprint $table) {
            if (!Schema::hasColumn('user', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('name');
            }
            if (!Schema::hasColumn('user', 'alamat')) {
                $table->text('alamat')->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('user', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('alamat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            if (Schema::hasColumn('user', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
            if (Schema::hasColumn('user', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('user', 'nama_lengkap')) {
                $table->dropColumn('nama_lengkap');
            }
        });
    }
};
