<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('order_product_id');
            $table->foreignId('product_id');
            $table->string('product_option');
            $table->string('product_option_value');
            $table->float('product_option_value_price', 15,2);
            $table->string('price_prefix');
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
        Schema::dropIfExists('order_product_attributes');
    }
}
