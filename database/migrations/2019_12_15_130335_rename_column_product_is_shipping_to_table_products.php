<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnProductIsShippingToTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_is_shipping');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('product_is_exists')->after('product_view')->default(1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_is_exists');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('product_is_shipping')->after('product_quantity')->default(0)->nullable();
        });
    }
}
