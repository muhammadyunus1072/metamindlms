<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('offline_course_links', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_offline_course_links', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('offline_course_links');
        Schema::dropIfExists('_history_offline_course_links');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        $table->bigInteger('offline_course_id')->unsigned();
        $table->text('url')->nullable()->default(null);
        $table->text('title')->nullable()->default(null);
        
        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
