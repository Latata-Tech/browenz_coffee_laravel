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
        Schema::table('ingredient_stock_histories', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->unsignedBigInteger('transaction_stock_ingredient_id')->nullable();
            $table->foreign('transaction_stock_ingredient_id')->references('id')->on('transaction_stock_ingredients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingredient_stock_histories', function (Blueprint $table) {
            $table->dropColumn(['description', 'transaction_stock_ingredient_id']);
        });
    }
};
