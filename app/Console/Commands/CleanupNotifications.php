<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:prune {--days=30 : The number of days to retain read notifications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old notifications from the database to maintain performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        
        // Delete read notifications older than X days
        $readDeleted = \Illuminate\Support\Facades\DB::table('notifications')
            ->whereNotNull('read_at')
            ->where('created_at', '<', now()->subDays($days))
            ->delete();

        // Delete unread notifications older than 90 days (fallback for ignored ones)
        $unreadDeleted = \Illuminate\Support\Facades\DB::table('notifications')
            ->whereNull('read_at')
            ->where('created_at', '<', now()->subDays(90))
            ->delete();

        $this->info("Successfully pruned {$readDeleted} read and {$unreadDeleted} unread notifications.");
    }
}
