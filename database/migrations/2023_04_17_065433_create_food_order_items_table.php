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
        Schema::create('food_order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("food_order_ids");
            $table->bigInteger("food_item_id");
            $table->integer("price");
            // $table->foreign('food_order_ids')->references('id')->on('food_orders')->onDelete('cascade');
            // $table->foreign('food_item_id')->references('id')->on('food')->onDelete('cascade');
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
        Schema::dropIfExists('food_order_items');
    }
};
