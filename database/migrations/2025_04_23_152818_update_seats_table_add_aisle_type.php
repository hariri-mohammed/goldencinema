<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('seats', function (Blueprint $table) {
            // تعديل عمود type ليشمل نوع الممر
            ("ALTER TABLE seats MODIFY COLUMN type ENUM('standard', 'vip', 'wheelchair', 'aisle') DEFAULT 'standard'");
        });
    }

    public function down()
    {
        Schema::table('seats', function (Blueprint $table) {
            // إعادة عمود type إلى حالته السابقة
            ("ALTER TABLE seats MODIFY COLUMN type ENUM('standard', 'vip', 'wheelchair') DEFAULT 'standard'");
        });
    }
};
