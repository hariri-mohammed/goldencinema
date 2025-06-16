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
        // This migration has likely run partially or fully before, causing issues.
        // All columns it intends to add (show_time, price) are likely already present.
        // All columns it intends to drop (start_time, end_time, base_price, vip_price, total_seats, available_seats, show_date)
        // are likely already dropped.
        // Therefore, we will make this 'up' method do nothing to prevent further errors.
        // If you need to re-run this migration for any reason (e.g., fresh database), you might uncomment these lines
        // AFTER ensuring the columns it tries to drop/add are in the state it expects.

        // Schema::table('movie_shows', function (Blueprint $table) {
        //     $table->dateTime('show_time')->nullable();
        //     $table->decimal('price', 8, 2)->nullable();
        //     $table->dropColumn([
        //         'start_time',
        //         'end_time',
        //         'base_price',
        //         'vip_price',
        //         'total_seats',
        //         'available_seats',
        //         'show_date',
        //     ]);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_shows', function (Blueprint $table) {
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('base_price', 8, 2)->nullable();
            $table->decimal('vip_price', 8, 2)->nullable();
            $table->integer('total_seats')->nullable();
            $table->integer('available_seats')->nullable();
            $table->date('show_date')->nullable();
            // The following line is commented out because columns might have been dropped already
            // $table->dropColumn(['show_time', 'price']);
        });
    }
};
