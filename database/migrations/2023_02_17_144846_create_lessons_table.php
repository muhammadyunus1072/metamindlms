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
        Schema::create('lessons', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_lessons', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('_history_lessons');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        $table->bigInteger('course_section_id')->unsigned();
        $table->string('title')->comment('Judul');
        $table->text('description')->comment('Deskripsi');
        $table->integer("position")->unsigned()->comment('Urutan');
        $table->enum("type", ["video", "quiz"])->comment('Jenis Pelajaran');
        $table->text('url_video')->nullable()->comment('Url Video');
        $table->boolean("can_preview")->default(0)->comment('Bisa Preview');
        $table->boolean("is_actived")->default(1);

        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
