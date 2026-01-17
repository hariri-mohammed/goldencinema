<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screen_id')->constrained('screens')->onDelete('cascade');
            $table->string('row'); // e.g., A, B, C
            $table->integer('number'); // Seat number within the row
            $table->string('type')->default('Standard'); // e.g., Standard, VIP, Wheelchair, Aisle
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->timestamps();

            // Unique constraint for a seat in a screen
            $table->unique(['screen_id', 'row', 'number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seats');
    }
};
