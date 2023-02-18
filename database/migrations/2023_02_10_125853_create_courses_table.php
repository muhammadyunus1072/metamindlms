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
        Schema::create('courses', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_courses', function (Blueprint $table) {
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
        Schema::dropIfExists('courses');
        Schema::dropIfExists('_history_courses');
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
        
        $table->bigInteger("level_id")->unsigned()->comment('Id Level');
        $table->bigInteger("category_id")->unsigned()->comment('Id Kategori');

        $table->string('title')->comment('Judul');
        $table->text('description')->nullable()->comment('Deskripsi');
        $table->text('about')->nullable()->comment('Tentang');

        $table->string('url_image')->nullable()->comment('Url Image');
        $table->string('url_icon')->nullable()->comment('Url Icon');
        $table->string('url_video')->nullable()->comment('Url Video');

        $table->double('price', 20, 2)->default(0)->comment('Password');

        $table->boolean("is_actived")->default(1);
        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
