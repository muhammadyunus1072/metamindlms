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
        Schema::create('transaction_details', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_transaction_details', function (Blueprint $table) {
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
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('_history_transaction_details');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('transaction_id', 'transaction_details_transaction_id_index');
            $table->index('product_id', 'transaction_details_product_id_index');
            $table->index('product_name', 'transaction_details_product_name_index');
            $table->index(['product_remarks_id', 'product_remarks_type'], 'transaction_details_product_remarks_index');    
        }

        $table->bigInteger("transaction_id")->unsigned()->comment('Id Transaksi');
        
        $table->bigInteger("product_id")->unsigned()->comment('Id Produk');
        $table->string("product_name")->comment('Nama Produk');
        $table->text("product_description")->nullable()->comment('Deskripsi Produk');
        $table->double('product_price', 20, 2)->comment('Harga Produk');
        $table->double('product_price_before_discount', 20, 2)->nullable()->comment('Harga Produk Sebelum Diskon');
        $table->bigInteger('product_remarks_id')->unsigned()->nullable();
        $table->string('product_remarks_type')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
