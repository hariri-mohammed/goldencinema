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
        schema::create('movie_shows', function (Blueprint $table) {
            $table->id();
            $table->time('start');
            $table->time('end');
            $table->date('show_date');
            $table->string('location');
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_shows');
    }
};
