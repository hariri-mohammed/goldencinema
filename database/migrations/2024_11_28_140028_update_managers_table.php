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
        Schema::table('managers', function (Blueprint $table) {
            if (!Schema::hasColumn('managers', 'first_name')) {
                $table->string('first_name')->after('id');
            }
            if (!Schema::hasColumn('managers', 'last_name')) {
                $table->string('last_name')->after('first_name');
            }
            if (!Schema::hasColumn('managers', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('password');
            }
            if (!Schema::hasColumn('managers', 'gender')) {
                $table->enum('gender', ['male', 'female'])->default('male')->after('date_of_birth');
            }
            if (!Schema::hasColumn('managers', 'phone_number')) {
                $table->string('phone_number')->after('gender');
            }
            if (Schema::hasColumn('managers', 'name')) {
                $table->dropColumn('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('managers', function (Blueprint $table) {
            if (Schema::hasColumn('managers', 'first_name')) {
                $table->dropColumn('first_name');
            }
            if (Schema::hasColumn('managers', 'last_name')) {
                $table->dropColumn('last_name');
            }
            if (Schema::hasColumn('managers', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }
            if (Schema::hasColumn('managers', 'gender')) {
                $table->dropColumn('gender');
            }
            if (Schema::hasColumn('managers', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
            $table->string('name')->after('id');
        });
    }
};
