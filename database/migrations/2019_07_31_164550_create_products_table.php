<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('product_category_id')->unsigned();
            $table->foreign('product_category_id')
                ->references('id')->on('product_categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('product_type_id')->unsigned();
            $table->foreign('product_type_id')
                ->references('id')->on('product_types')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('product_name');
            $table->string('product_slug');
            $table->string('product_image');
            $table->text('product_description');
            $table->text('product_content');
            $table->float('product_price');
            $table->float('product_promotional');
            $table->integer('count_buy');
            $table->integer('product_view');
            $table->integer('product_status')->default(1);
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
        Schema::dropIfExists('products');
    }
}
