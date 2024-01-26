<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Courses
        Schema::table('courses', function (Blueprint $table) {
            $table->double('price_before_discount', 20, 2)->nullable()->comment('Harga Sebelum Diskon');
        });
        Schema::table('_history_courses', function (Blueprint $table) {
            $table->double('price_before_discount', 20, 2)->nullable()->comment('Harga Sebelum Diskon');
        });

        // Offline Courses
        Schema::table('offline_courses', function (Blueprint $table) {
            $table->double('price', 20, 2)->default(0)->comment('Harga');
            $table->double('price_before_discount', 20, 2)->nullable()->comment('Harga Sebelum Diskon');
        });
        Schema::table('_history_offline_courses', function (Blueprint $table) {
            $table->double('price', 20, 2)->default(0)->comment('Harga');
            $table->double('price_before_discount', 20, 2)->nullable()->comment('Harga Sebelum Diskon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Courses
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('price_before_discount');
        });
        Schema::table('_history_courses', function (Blueprint $table) {
            $table->dropColumn('price_before_discount');
        });
        
        // Offline Courses
        Schema::table('offline_courses', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('price_before_discount');
        });
        Schema::table('_history_offline_courses', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('price_before_discount');
        });
    }
};
