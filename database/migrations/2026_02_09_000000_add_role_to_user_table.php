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
            if (!Schema::hasColumn('user', 'role')) {
                $table->string('role')->default('user')->after('password');
            }
        });

        // Set existing users to 'user' role if they don't have one
        \Illuminate\Support\Facades\DB::table('user')->whereNull('role')->update(['role' => 'user']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            if (Schema::hasColumn('user', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
