<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('offline_courses', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::table('_history_offline_courses', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
    }

    private function scheme(Blueprint $table, $isHistory = false)
    {
        $table->text('content')->nullable()->default(null);
    }
};
