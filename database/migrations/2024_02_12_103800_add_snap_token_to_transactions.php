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
        Schema::table('transactions', function (Blueprint $table) {
            $table->text('snap_token')->nullable()->default(null);
        });
        Schema::table('_history_transactions', function (Blueprint $table) {
            $table->text('snap_token')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('snap_token');
        });
        Schema::table('_history_transactions', function (Blueprint $table) {
            $table->dropColumn('snap_token');
        });
    }
};
