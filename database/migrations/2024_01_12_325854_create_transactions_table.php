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
        Schema::create('transactions', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_transactions', function (Blueprint $table) {
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
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('_history_transactions');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('user_id', 'transactions_user_id_index');
            $table->index('payment_method_id', 'transactions_payment_method_id_index');
            $table->index('last_status_id', 'transactions_last_status_id_index');
            $table->index('number', 'transactions_number_index');
        }

        $table->bigInteger("user_id")->unsigned()->comment('Id User');
        $table->bigInteger("payment_method_id")->unsigned()->comment('Id Payment Method');
        $table->string("payment_method_name")->comment('Nama Payment Method');
        $table->text("payment_method_description")->nullable()->comment('Deskripsi Payment Method');
        $table->bigInteger("last_status_id")->unsigned()->comment('Id Transaksi Status');
        $table->string("proof_of_payment")->nullable()->comment('Nama File Gambar');
        $table->string("number")->comment('Nomor Auto Generate');

        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
