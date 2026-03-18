<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckEmailQueue extends Command
{
    protected $signature = 'email:check';
    protected $description = 'Check email queue status';

    public function handle()
    {
        $failed = DB::table('failed_jobs')->count();
        $pending = DB::table('jobs')->count();

        $this->info("📧 Email Queue Status");
        $this->table(
            ['Type', 'Count'],
            [
                ['Pending', $pending],
                ['Failed', $failed],
            ]
        );

        if ($failed > 0) {
            $this->warn("⚠️  {$failed} emails failed!");
        }

        return 0;
    }
}