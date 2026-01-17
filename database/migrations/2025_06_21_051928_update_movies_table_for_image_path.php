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
        Schema::table('movies', function (Blueprint $table) {
            $table->renameColumn('img', 'image');
        });

        Schema::table('movies', function (Blueprint $table) {
            $table->string('image')->change();
            $table->string('rating')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->decimal('rating', 3, 1)->change();
            $table->binary('image')->change();
        });

        Schema::table('movies', function (Blueprint $table) {
            $table->renameColumn('image', 'img');
        });
    }
};
