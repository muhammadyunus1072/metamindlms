<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('offline_courses', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_offline_courses', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('offline_courses');
        Schema::dropIfExists('_history_offline_courses');
    }

    private function scheme(Blueprint $table, $isHistory = false)
    {
        $table->id();
        if ($isHistory) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }
        $table->text('image')->nullable()->default(null);
        
        $table->text('title');
        $table->text('description');
        $table->integer('quota')->nullable()->default(null);
        $table->datetime('date_time_start');
        $table->datetime('date_time_end');

        $table->bigInteger("created_by")->unsigned();
        $table->bigInteger("updated_by")->unsigned();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
