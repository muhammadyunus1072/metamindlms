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
        // Payment Method
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->text('instruction')->nullable()->comment('Instruksi');
        });
        Schema::table('_history_payment_methods', function (Blueprint $table) {
            $table->text('instruction')->nullable()->comment('Instruksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Payment Method
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('instruction');
        });
        Schema::table('_history_payment_methods', function (Blueprint $table) {
            $table->dropColumn('instruction');
        });
    }
};
