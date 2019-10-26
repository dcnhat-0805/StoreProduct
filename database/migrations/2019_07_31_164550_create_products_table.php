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
            $table->float('product_promotion', 20, 0)->nullable();
            $table->string('product_meta_title')->nullable();
            $table->string('product_meta_description')->nullable();
            $table->integer('product_weight')->nullable();
            $table->integer('product_is_shipping')->nullable()->default(0);
            $table->string('product_option')->nullable()->comment('0: best; 1: new; 2: hot; 1: promotion');
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
