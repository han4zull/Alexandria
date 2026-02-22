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
        Schema::table('ulasanbuku', function (Blueprint $table) {
            // Check if unique constraint exists before dropping
            $indexes = \DB::select("SHOW INDEX FROM ulasanbuku WHERE Key_name = 'ulasanbuku_user_id_buku_id_unique'");
            if (count($indexes) > 0) {
                $table->dropUnique(['user_id', 'buku_id']);
            }
            
            // Add peminjaman_id column if it doesn't exist
            if (!Schema::hasColumn('ulasanbuku', 'peminjaman_id')) {
                $table->unsignedBigInteger('peminjaman_id')->nullable()->after('buku_id');
                $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->onDelete('cascade');
            }
            
            // Add new unique constraint per peminjaman (allow null for backward compatibility)
            $table->unique(['user_id', 'peminjaman_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ulasanbuku', function (Blueprint $table) {
            // Drop new unique constraint
            $table->dropUnique(['user_id', 'peminjaman_id']);
            
            // Drop foreign key and column
            $table->dropForeign(['peminjaman_id']);
            $table->dropColumn('peminjaman_id');
            
            // Restore old unique constraint
            $table->unique(['user_id', 'buku_id']);
        });
    }
};
