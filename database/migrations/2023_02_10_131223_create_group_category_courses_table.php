<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('group_category_courses', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_group_category_courses', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_category_courses');
        Schema::dropIfExists('_history_group_category_courses');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
            $table->string('code')->comment('Kode');
        } else {
            $table->string('code')->unique()->comment('Kode');
        }
        
        $table->string('name')->comment('Nama');
        $table->string('icon')->nullable()->comment('Icon');
        $table->text('description')->nullable()->comment('Deskripsi');

        $table->boolean("is_actived")->default(1);
        $table->bigInteger("created_by")->unsigned();
        $table->bigInteger("updated_by")->unsigned();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
