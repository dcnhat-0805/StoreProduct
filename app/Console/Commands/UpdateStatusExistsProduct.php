<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateStatusExistsProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:UpdateStatusExistsProduct';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status exists product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = Product::whereNull('products.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftjoin('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->leftjoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->selectRaw("products.id")
            ->whereRaw("(products.product_quantity - (SELECT SUM(quantity) FROM order_details WHERE order_details.product_id = products.id GROUP BY product_id)) = 0")
            ->groupBy('products.id')
            ->get();

        foreach ($products as $product) {
            Product::updateStatusNotExists($product->id);
        }
    }
}
