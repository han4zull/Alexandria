<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SyncUserPoints extends Command
{
    protected $signature = 'sync:user-points {--dry-run}';
    protected $description = 'Recalculate and persist user points from pengembalianbuku (fallback to proses_kembali)';

    public function handle()
    {
        $this->info('Starting sync of user points...');

        $users = User::select('user.id')->get();

        $updated = 0;

        foreach ($users as $u) {
            $userId = $u->id;

            // Calculate from pengembalianbuku via peminjaman
            $pointsPengembalian = DB::table('peminjaman')
                ->leftJoin('pengembalianbuku', 'peminjaman.id', '=', 'pengembalianbuku.peminjaman_id')
                ->where('peminjaman.user_id', $userId)
                ->whereNotNull('pengembalianbuku.kondisi_buku')
                ->selectRaw('COALESCE(SUM(
                    CASE
                        WHEN pengembalianbuku.kondisi_buku = "rusak_ringan" THEN 10
                        WHEN pengembalianbuku.kondisi_buku = "rusak_berat" THEN 20
                        WHEN pengembalianbuku.kondisi_buku = "hilang" THEN 50
                        ELSE 0
                    END
                ), 0) as total')
                ->value('total');

            // Fallback: calculate from proses_kembali if pengembalianbuku has no entries
            $pointsProses = DB::table('proses_kembali')
                ->where('user_id', $userId)
                ->whereNotNull('kondisi_buku')
                ->selectRaw('COALESCE(SUM(
                    CASE
                        WHEN kondisi_buku = "rusak_ringan" THEN 10
                        WHEN kondisi_buku = "rusak_berat" THEN 20
                        WHEN kondisi_buku = "hilang" THEN 50
                        ELSE 0
                    END
                ), 0) as total')
                ->value('total');

            $finalPoints = $pointsPengembalian > 0 ? (int)$pointsPengembalian : (int)$pointsProses;

            if ($this->option('dry-run')) {
                $this->line("user_id={$userId} => pengembalian={$pointsPengembalian}, proses_kembali={$pointsProses}, final={$finalPoints}");
                continue;
            }

            // Persist to user table
            DB::table('user')->where('id', $userId)->update(['poin' => $finalPoints]);
            $updated++;
        }

        $this->info("Sync complete. Users updated: {$updated}");
        return 0;
    }
}
