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
        Schema::create('products', function (Blueprint $table) {
            $this->scheme($table);
        });

        Schema::create('_history_products', function (Blueprint $table) {
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('_history_products');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('name', 'products_name_index');
            $table->index(['remarks_id', 'remarks_type'], 'products_remarks_index');
        }
        
        $table->string('name')->comment('Nama Produk');
        $table->text('description')->nullable()->comment('Nama Produk');
        $table->double('price', 20, 2)->default(0)->comment('Harga Produk');
        $table->double('price_before_discount', 20, 2)->default(0)->comment('Harga Sebelum Diskon');

        $table->bigInteger("remarks_id")->unsigned()->nullable();
        $table->string("remarks_type");

        $table->bigInteger("created_by")->unsigned()->nullable()->comment('Id Admin Pembuat');
        $table->bigInteger("updated_by")->unsigned()->nullable()->comment('Id Admin pengubah');
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
