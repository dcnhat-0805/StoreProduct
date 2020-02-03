<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->nullable();
//            $table->integer('order_id')->nullable()->unsigned();
//            $table->foreign('order_id')
//                ->references('id')->on('orders')
//                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('product_id')->nullable();
//            $table->integer('product_id')->nullable()->unsigned();
//            $table->foreign('product_id')
//                ->references('id')->on('products')
//                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantity')->nullable();
            $table->float('amount', 20, 0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
