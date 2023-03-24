<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('offline_course_registrars', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_offline_course_registrars', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('offline_course_registrars');
        Schema::dropIfExists('_history_offline_course_registrars');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        $table->bigInteger('offline_course_id')->unsigned();
        $table->bigInteger('user_id')->unsigned();
        $table->string('user_name')->nullable()->default(null)->comment('Nama');
        $table->string('user_email')->nullable()->default(null)->comment('Email');
        $table->string('user_phone')->nullable()->default(null)->comment('Nomor Handphone');
        $table->string('user_birth_place')->nullable()->default(null)->comment('Tempat Lahir');
        $table->date('user_birth_date')->nullable()->default(null)->comment('Tanggal Lahir');
        $table->enum('user_gender', ['Pria', 'Wanita'])->nullable()->default(null)->comment('Jenis Kelamin');
        $table->string('user_religion')->nullable()->default(null)->comment('Agama');
        $table->string('user_company_name')->nullable()->default(null)->comment('Nama Perusahaan');

        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
