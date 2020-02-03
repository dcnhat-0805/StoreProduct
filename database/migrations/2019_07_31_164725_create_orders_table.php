<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code')->nullable();
            $table->string('cart_row_id')->nullable();
            $table->integer('transaction_id')->nullable();
//            $table->integer('transaction_id')->nullable()->unsigned();
//            $table->foreign('transaction_id')
//                ->references('id')->on('transactions')
//                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->nullable();
//            $table->integer('user_id')->nullable()->unsigned();
//            $table->foreign('user_id')
//                ->references('id')->on('users')
//                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('order_name')->nullable();
            $table->string('order_address')->nullable();
            $table->string('order_email')->nullable();
            $table->string('order_phone')->nullable();
            $table->float('order_monney', 20, 0)->nullable();
            $table->text('order_message')->nullable();
            $table->integer('order_status')->default(0);//Don hang da dong goi hay duyet chua
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
        Schema::dropIfExists('orders');
    }
}
