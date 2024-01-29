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
        Schema::create('transaction_detail_courses', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_transaction_detail_courses', function (Blueprint $table) {
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
        Schema::dropIfExists('transaction_detail_courses');
        Schema::dropIfExists('_history_transaction_detail_courses');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('transaction_detail_id', 'tdc_transaction_detail_id_index');
            $table->index('course_id', 'tdc_course_id_index');
            $table->index('course_title', 'tdc_course_title_index');
        }

        $table->bigInteger("transaction_detail_id")->unsigned()->comment('Id Transaksi Detail');
        $table->bigInteger("course_id")->unsigned()->comment('Id Course');

        $table->string("course_title")->nullable()->comment('Judul');
        $table->text("course_description")->nullable()->comment('Deskripsi');
        $table->text("course_about")->nullable()->comment('About');
        $table->string("course_url_image")->nullable()->comment('URL Image');
        $table->string("course_url_icon")->nullable()->comment('URL Icon');
        $table->string("course_url_video")->nullable()->comment('URL Video');
        $table->double("course_price")->comment('Harga');
        $table->double("course_price_before_discount")->comment('Harga Sebelum Diskon');

        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
