<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lesson_questions', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_lesson_questions', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_questions');
        Schema::dropIfExists('_history_lesson_questions');
    }

    private function scheme(Blueprint $table, $isHistory = false)
    {
        $table->id();
        if ($isHistory) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        $table->bigInteger('lesson_id')->unsigned();
        $table->integer('number');
        $table->text('text');
        $table->json('choices')->nullable()->default(null);

        $table->bigInteger("created_by")->unsigned();
        $table->bigInteger("updated_by")->unsigned();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
