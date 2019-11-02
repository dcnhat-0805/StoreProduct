<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->nullable();
            $table->string('attribute_code')->nullable();
//            $table->integer('product_id')->unsigned();
//            $table->foreign('product_id')
//                ->references('id')->on('products')
//                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('attribute_name')->nullable();
            $table->string('attribute_item_name')->nullable();
            $table->string('attribute_price')->nullable();
            $table->integer('is_filterable')->nullable();
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
        Schema::dropIfExists('product_attributes');
    }
}
