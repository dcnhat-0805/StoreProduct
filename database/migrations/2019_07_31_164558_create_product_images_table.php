<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_image_name');
            $table->integer('product_id')->nullable();
//            $table->integer('product_id')->unsigned();
//            $table->foreign('product_id')
//                ->references('id')->on('products')
//                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('product_image_order')->nullable()->default(0);
            $table->integer('product_image_status')->nullable()->default(1);
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
        Schema::dropIfExists('product_images');
    }
}
