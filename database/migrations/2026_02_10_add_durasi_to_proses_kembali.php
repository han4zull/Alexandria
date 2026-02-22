<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proses_kembali', function (Blueprint $table) {
            if (!Schema::hasColumn('proses_kembali', 'durasi')) {
                $table->integer('durasi')->nullable()->default(0)->after('tanggal_kembali_sebenarnya');
            }
        });
    }

    public function down()
    {
        Schema::table('proses_kembali', function (Blueprint $table) {
            if (Schema::hasColumn('proses_kembali', 'durasi')) {
                $table->dropColumn('durasi');
            }
        });
    }
};

