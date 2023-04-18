<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lesson_answers', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_lesson_answers', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_answers');
        Schema::dropIfExists('_history_lesson_answers');
    }

    private function scheme(Blueprint $table, $isHistory = false)
    {
        $table->id();
        if ($isHistory) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        // Lesson Questions
        $table->bigInteger('lesson_question_id')->nullable()->unsigned();
        $table->bigInteger('lesson_question_lesson_id')->unsigned()->nullable();
        $table->integer('lesson_question_number')->unsigned()->nullable();
        $table->string('lesson_question_text')->nullable();
        $table->json('lesson_question_choices')->nullable()->default(null);

        $table->bigInteger('user_id')->unsigned()->nullable();
        $table->json('answers')->nullable();
        $table->integer('score')->nullable()->unsigned();

        $table->bigInteger("created_by")->unsigned();
        $table->bigInteger("updated_by")->unsigned();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
