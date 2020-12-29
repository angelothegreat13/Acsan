<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id');
            $table->foreignId('customer_id');
            $table->foreignId('product_id');
            $table->foreignId('product_option_id');
            $table->foreignId('product_option_value_id');
            $table->text('session_id');
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
        Schema::dropIfExists('cart_attributes');
    }
}
