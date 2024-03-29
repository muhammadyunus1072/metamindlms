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
        Schema::create('course_members', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_course_members', function (Blueprint $table) {
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
        Schema::dropIfExists('course_members');
        Schema::dropIfExists('_history_course_members');
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

        $table->bigInteger('course_id')->unsigned();
        $table->bigInteger('member_id')->unsigned();

        $table->double('course_price', 20, 2)->default(0)->comment('Harga Kursus');

        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
