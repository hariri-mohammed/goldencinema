<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MovieShow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateShowStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shows:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the status of movie shows to "inactive" after their show time has passed.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update movie show statuses...');
        Log::info('Scheduled Task: Running UpdateShowStatusCommand.');

        // Find shows that are 'active' but their show_time is in the past.
        $showsToUpdate = MovieShow::where('status', 'active')
            ->where('show_time', '<', Carbon::now())
            ->get();
            
        if ($showsToUpdate->isEmpty()) {
            $this->info('No movie shows to update.');
            Log::info('Scheduled Task: No shows needed an update.');
            return 0;
        }

        $count = $showsToUpdate->count();
        $this->info("Found {$count} shows to update.");

        foreach ($showsToUpdate as $show) {
            $show->status = 'inactive';
            $show->save();
        }

        $this->info("Successfully updated {$count} shows to 'inactive'.");
        Log::info("Scheduled Task: Successfully updated {$count} shows.");

        return 0;
    }
}
