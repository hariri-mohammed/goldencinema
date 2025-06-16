<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. إضافة الأعمدة الجديدة
        Schema::table('movie_shows', function (Blueprint $table) {
            $table->unsignedBigInteger('screen_id')->nullable()->after('movie_id');
            $table->decimal('base_price', 8, 2)->default(0)->after('end');
            $table->decimal('vip_price', 8, 2)->default(0)->after('base_price');
            $table->integer('total_seats')->default(0)->after('vip_price');
            $table->integer('available_seats')->default(0)->after('total_seats');
            $table->enum('status', ['active', 'cancelled', 'completed'])->default('active')->after('available_seats');
        });

        // 2. إعادة تسمية الأعمدة
        Schema::table('movie_shows', function (Blueprint $table) {
            $table->renameColumn('start', 'start_time');
            $table->renameColumn('end', 'end_time');
        });

        // 3. إضافة قيم افتراضية للبيانات الموجودة
        $defaultScreen = DB::table('screens')->first();

        if ($defaultScreen) {
            DB::table('movie_shows')->update([
                'screen_id' => $defaultScreen->id,
                'base_price' => 50, // قيمة افتراضية
                'total_seats' => 100, // قيمة افتراضية
                'available_seats' => 100 // قيمة افتراضية
            ]);
        }

        // 4. إضافة قيود Foreign Key بعد تحديث البيانات
        Schema::table('movie_shows', function (Blueprint $table) {
            // إضافة Foreign Key للشاشة
            $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade');

            // إضافة Indexes
            $table->index(['show_date', 'start_time']);
            $table->index(['screen_id']);
        });

        // 5. حذف عمود location
        Schema::table('movie_shows', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }

    public function down()
    {
        Schema::table('movie_shows', function (Blueprint $table) {
            // إعادة عمود location
            $table->string('location')->after('show_date');

            // إعادة تسمية الأعمدة إلى الأسماء القديمة
            $table->renameColumn('start_time', 'start');
            $table->renameColumn('end_time', 'end');

            // حذف Foreign Key
            $table->dropForeign(['screen_id']);

            // حذف Indexes
            $table->dropIndex(['show_date', 'start_time']);
            $table->dropIndex(['screen_id']);

            // حذف الأعمدة الجديدة
            $table->dropColumn([
                'screen_id',
                'base_price',
                'vip_price',
                'total_seats',
                'available_seats',
                'status'
            ]);
        });
    }
};
