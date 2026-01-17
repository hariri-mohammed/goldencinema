<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "===> DatabaseSeeder started\n";
        // Truncate related tables before seeding
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Seat::truncate();
        \App\Models\MovieShow::truncate();
        \App\Models\Screen::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "===> ScreenShowSeatSeeder started\n";
        $this->call(ScreenShowSeatSeeder::class);
        echo "===> ScreenShowSeatSeeder finished\n";
        echo "===> DatabaseSeeder finished\n";
    }
}
