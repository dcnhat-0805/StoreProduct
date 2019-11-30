<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends FrontEndController
{

    public function index(Request $request)
    {
        $params = $request->all();
        $products = [];
        $products['best'] = Product::getProductByOption(BEST);
        $products['news'] = Product::getProductByOption(NEWS);
        $products['hot'] = Product::getProductByOption(HOT);


        return view('frontend.pages.index', compact('products'));
    }
}
