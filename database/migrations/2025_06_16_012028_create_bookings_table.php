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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_show_id')->constrained('movie_shows')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Assuming 'clients' table exists
            $table->unsignedInteger('number_of_tickets');
            $table->decimal('total_price', 8, 2);
            $table->timestamp('booking_date');
            $table->string('status')->default('confirmed'); // e.g., pending, confirmed, cancelled
            $table->string('payment_id')->nullable(); // For electronic payment transaction ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
