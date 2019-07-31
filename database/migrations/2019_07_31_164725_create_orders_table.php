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
            $table->string('order_code');
            $table->integer('transaction_id')->unsigned();
            $table->foreign('transaction_id')
                ->references('id')->on('transactions')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('order_name');
            $table->string('order_adress');
            $table->string('order_email');
            $table->string('order_phone');
            $table->decimal('order_monney');
            $table->text('order_message')->nullable();
            $table->integer('order_status')->default(0);//Don hang da dong goi hay duyet chua
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
        Schema::dropIfExists('orders');
    }
}
