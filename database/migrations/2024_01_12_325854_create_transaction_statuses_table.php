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
        Schema::create('transaction_statuses', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_transaction_statuses', function (Blueprint $table) {
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
        Schema::dropIfExists('transaction_statuses');
        Schema::dropIfExists('_history_transaction_statuses');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('transaction_id', 'transaction_statuses_transaction_id_index');
            $table->index('name', 'transaction_statuses_name_index');
        }

        $table->bigInteger("transaction_id")->unsigned()->comment('Id Transaksi');
        $table->string("name")->comment('Nama Status');
        $table->text("description")->nullable()->comment('Deskripsi Status');

        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
