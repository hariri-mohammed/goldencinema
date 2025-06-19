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
        Schema::table('bookings', function (Blueprint $table) {
            // Remove reservation_expires_at column
            $table->dropColumn('reservation_expires_at');

            // Modify status column: ensure it's not nullable and set default to 'confirmed'
            // Note: This assumes you want to remove 'pending' and 'cancelled' as valid statuses
            // If you still need 'cancelled' for historical data, you might adjust this.
            $table->string('status')->default('confirmed')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Re-add reservation_expires_at column if rolling back
            $table->timestamp('reservation_expires_at')->nullable();

            // Revert status column if rolling back (e.g., to default 'pending')
            $table->string('status')->default('pending')->change();
        });
    }
};
