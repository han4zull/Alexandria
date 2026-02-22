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
        Schema::table('pengembalianbuku', function (Blueprint $table) {
            if (!Schema::hasColumn('pengembalianbuku', 'rating')) {
                $table->integer('rating')->nullable()->comment('1-5 stars');
            }
            if (!Schema::hasColumn('pengembalianbuku', 'review')) {
                $table->text('review')->nullable();
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
        Schema::table('pengembalianbuku', function (Blueprint $table) {
            if (Schema::hasColumn('pengembalianbuku', 'rating')) {
                $table->dropColumn('rating');
            }
            if (Schema::hasColumn('pengembalianbuku', 'review')) {
                $table->dropColumn('review');
            }
        });
    }
};
