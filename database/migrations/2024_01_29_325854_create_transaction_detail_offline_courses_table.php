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
        Schema::create('transaction_detail_offline_courses', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_transaction_detail_offline_courses', function (Blueprint $table) {
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
        Schema::dropIfExists('transaction_detail_offline_courses');
        Schema::dropIfExists('_history_transaction_detail_offline_courses');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('transaction_detail_id', 'tdoc_transaction_detail_id_index');
            $table->index('offline_course_id', 'tdoc_offline_course_id_index');
            $table->index('offline_course_title', 'tdoc_offline_course_title_index');
        }

        $table->bigInteger("transaction_detail_id")->unsigned()->comment('Id Transaksi Detail');
        $table->bigInteger("offline_course_id")->unsigned()->comment('Id Offline Course');

        $table->string("offline_course_title")->nullable()->comment('Judul');
        $table->text("offline_course_description")->nullable()->comment('Deskripsi');
        $table->text("offline_course_content")->nullable()->comment('Konten');
        $table->integer("offline_course_quota")->nullable()->comment('Quota');
        $table->dateTime("offline_course_date_time_start")->nullable()->comment('Tanggal Mulai Kegiatan');
        $table->dateTime("offline_course_date_time_end")->nullable()->comment('Tanggal Akhir Kegiatan');
        $table->text("offline_url_online_meet")->nullable()->comment('URL Online Meet');

        $table->double("offline_course_price")->comment('Harga');
        $table->double("offline_course_price_before_discount")->comment('Harga Sebelum Diskon');

        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
