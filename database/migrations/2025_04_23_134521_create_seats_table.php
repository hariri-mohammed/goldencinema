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
            $table->foreignId('screen_id')->constrained()->onDelete('cascade');
            $table->string('row'); // مثل A, B, C
            $table->integer('number'); // رقم المقعد في الصف
            $table->enum('type', ['standard', 'vip', 'wheelchair', 'aisle'])->default('standard');
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->boolean('is_aisle_left')->default(false);  // هل يوجد ممر على اليسار
            $table->boolean('is_aisle_right')->default(false); // هل يوجد ممر على اليمين
            $table->timestamps();

            // لضمان عدم تكرار نفس المقعد في نفس الشاشة
            $table->unique(['screen_id', 'row', 'number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seats');
    }
};
