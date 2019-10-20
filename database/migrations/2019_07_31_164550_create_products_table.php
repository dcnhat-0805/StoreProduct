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
            $table->integer('category_id')->nullable()->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('product_category_id')->nullable()->unsigned();
            $table->foreign('product_category_id')
                ->references('id')->on('product_categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('product_type_id')->nullable()->unsigned();
            $table->foreign('product_type_id')
                ->references('id')->on('product_types')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('product_name')->nullable();
            $table->string('product_slug')->nullable();
            $table->string('product_image')->nullable();
            $table->text('product_description')->nullable();
            $table->text('product_content')->nullable();
            $table->float('product_price', 20, 0)->nullable();
            $table->float('product_promotional', 20, 0)->nullable();
            $table->integer('count_buy')->nullable();
            $table->integer('product_view')->nullable();
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
