<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;
use App\Models\MovieShow;
use App\Models\Seat;
use App\Models\Movie;
use App\Models\Theater;
use Carbon\Carbon;

class ScreenShowSeatSeeder extends Seeder
{
    public function run(): void
    {
        // Create a theater if not exists
        $theater = Theater::first() ?? Theater::factory()->create(['name' => 'Test Theater', 'location' => 'Test City', 'city' => 'Test City']);

        // Create movies if not exists
        $movies = Movie::take(3)->get();
        if ($movies->count() < 3) {
            for ($i = $movies->count(); $i < 3; $i++) {
                Movie::factory()->create();
            }
            $movies = Movie::take(3)->get();
        }

        // Create 3 screens
        for ($s = 1; $s <= 3; $s++) {
            $screen = Screen::create([
                'screen_name' => 'Screen ' . $s,
                'screen_number' => $s,
                'status' => 'active',
                'theater_id' => $theater->id,
            ]);

            // Create a movie show for each screen
            $movie = $movies[$s - 1];
            $show = MovieShow::create([
                'movie_id' => $movie->id,
                'theater_id' => $theater->id,
                'screen_id' => $screen->id,
                'show_time' => Carbon::now()->addDays($s)->setTime(18, 0),
                'price' => 50 + $s * 10,
                'status' => 'active',
            ]);

            // Create seats for each screen (8 rows x 10 seats)
            $rows = range('A', 'H');
            $seatsPerRow = 10;
            foreach ($rows as $row) {
                for ($num = 1; $num <= $seatsPerRow; $num++) {
                    $type = 'standard';
                    if ($num == 1) $type = 'aisle';
                    elseif ($num == 2 && $row == 'H') $type = 'wheelchair';
                    elseif ($num == 5) $type = 'vip';
                    $status = 'active';
                    if ($num == 3 && $row == 'B') $status = 'maintenance';
                    elseif ($num == 7 && $row == 'C') $status = 'inactive';
                    Seat::create([
                        'screen_id' => $screen->id,
                        'row' => $row,
                        'number' => $num,
                        'type' => $type,
                        'status' => $status,
                    ]);
                }
            }
        }
    }
} 