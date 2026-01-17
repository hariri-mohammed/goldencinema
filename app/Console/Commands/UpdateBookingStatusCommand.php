<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateBookingStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the status of bookings to "completed" after the show has finished.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update booking statuses...');
        Log::info('Scheduled Task: Running UpdateBookingStatusCommand.');

        // Find bookings that are confirmed and whose shows have ended.
        $bookingsToUpdate = Booking::where('status', 'confirmed')
            ->whereHas('movieShow.movie', function ($query) {
                // We need to use raw SQL to calculate the end time.
                // End Time = show_time + movie.runtime (in minutes)
                // We check if this End Time is in the past.
                $query->whereRaw('DATE_ADD(movie_shows.show_time, INTERVAL movies.runtime MINUTE) < ?', [Carbon::now()]);
            })
            ->get();
            
        if ($bookingsToUpdate->isEmpty()) {
            $this->info('No bookings to update.');
            Log::info('Scheduled Task: No bookings needed an update.');
            return 0;
        }

        $count = $bookingsToUpdate->count();
        $this->info("Found {$count} bookings to update.");

        foreach ($bookingsToUpdate as $booking) {
            $booking->status = 'completed';
            $booking->save();
        }

        $this->info("Successfully updated {$count} bookings to 'completed'.");
        Log::info("Scheduled Task: Successfully updated {$count} bookings.");

        return 0;
    }
} 