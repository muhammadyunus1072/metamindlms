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
        Schema::create('users', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_users', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('_history_users');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
            $table->string('email')->comment('Email');
        } else {
            $table->string('email')->unique()->comment('Email');
        }
        $table->string('password')->comment('Password');
        $table->string('name')->comment('Nama');
        $table->date('birth_date')->nullable()->comment('Tanggal Lahir');
        $table->enum('gender', ['Pria', 'Wanita'])->nullable()->comment('Jenis Kelamin');
        $table->enum('role', ['admin', 'member'])->nullable()->comment('Role');

        if ($is_history) {
            $table->string('phone')->nullable()->comment('Nomor Handphone');
        } else {
            $table->string('phone')->nullable()->unique()->comment('Nomor Handphone');
        }

        $table->boolean("is_actived")->default(1);
        $table->text("accessibility")->nullable()->comment('Hak Akses');
        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
