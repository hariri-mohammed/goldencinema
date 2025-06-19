<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('reservation_expires_at')->nullable()->after('status');
        });

        // Update existing pending bookings to have an expiration time
        DB::table('bookings')
            ->where('status', 'pending')
            ->update(['reservation_expires_at' => now()->addMinutes(15)]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('reservation_expires_at');
        });
    }
}; 