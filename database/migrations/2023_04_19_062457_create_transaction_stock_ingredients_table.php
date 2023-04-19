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
        Schema::create('transaction_stock_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_id');
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->unsignedInteger('qty');
            $table->unsignedBigInteger('stock_type_id');
            $table->foreign('stock_type_id')->references('id')->on('stock_types');
            $table->unsignedBigInteger('transaction_stock_id');
            $table->foreign('transaction_stock_id')->references('id')->on('transaction_stocks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_stock_ingredients');
    }
};
