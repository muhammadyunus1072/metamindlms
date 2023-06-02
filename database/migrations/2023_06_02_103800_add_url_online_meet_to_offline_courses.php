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
        Schema::table('offline_courses', function (Blueprint $table) {
            $table->text('url_online_meet')->nullable()->default(null);
        });
        Schema::table('_history_offline_courses', function (Blueprint $table) {
            $table->text('url_online_meet')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offline_courses', function (Blueprint $table) {
            $table->dropColumn('url_online_meet');
        });
        Schema::table('_history_offline_courses', function (Blueprint $table) {
            $table->dropColumn('url_online_meet');
        });
    }
};
