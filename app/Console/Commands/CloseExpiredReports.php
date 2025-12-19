<?php

namespace App\Console\Commands;

use App\Models\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CloseExpiredReports extends Command
{
    protected $signature = 'reports:close-expired';
    protected $description = 'Close expired reports based on timeout and auto-close settings';

    public function handle()
    {
        $claimTimeout = Cache::get('back2me.claim_timeout_days', 30);
        $autoClose = Cache::get('back2me.auto_close_days', 90);

        // Auto-close laporan pending yang sudah lewat claim timeout
        $expiredByTimeout = Report::where('status', 'pending')
            ->whereNull('claimed_by')
            ->where('created_at', '<', now()->subDays($claimTimeout))
            ->update(['status' => 'expired']);

        // Auto-close laporan pending yang sudah lewat auto-close period
        $expiredByAutoClose = Report::where('status', 'pending')
            ->where('created_at', '<', now()->subDays($autoClose))
            ->update(['status' => 'expired']);

        $total = $expiredByTimeout + $expiredByAutoClose;

        $this->info("✅ Berhasil menutup {$total} laporan yang expired");
        $this->info("   - Timeout klaim ({$claimTimeout} hari): {$expiredByTimeout} laporan");
        $this->info("   - Auto close ({$autoClose} hari): {$expiredByAutoClose} laporan");

        return Command::SUCCESS;
    }
}
