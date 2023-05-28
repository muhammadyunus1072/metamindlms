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
        Schema::table('offline_course_attachments', function (Blueprint $table) {
            $table->text('title')->nullable()->default(null);
        });
        Schema::table('_history_offline_course_attachments', function (Blueprint $table) {
            $table->text('title')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offline_course_attachments', function (Blueprint $table) {
            $table->dropColumn('title');
        });
        Schema::table('_history_offline_course_attachments', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};
