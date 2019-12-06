<?php

namespace App\Http\Controllers\FrontEnd;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends FrontEndController
{

    public function index(Request $request)
    {
        $params = Product::getSearchParams();
        $products = [];
        $products['best'] = Product::getProductByOption(BEST);
        $products['news'] = Product::getProductByOption(NEWS);
        $products['hot'] = Product::getProductByOption(HOT);

        return view('frontend.pages.index', compact('products'));
    }

    public function getDataSearch(Request $request)
    {
        $params = Product::getSearchParams();
        $products = Product::getProductBySearch($params);
        $arrayProductId = Helper::getArrayProductId($products);
        $is_page_search = true;

        return view('frontend.pages.search.index', compact('products', 'params', 'is_page_search', 'arrayProductId'));
    }

    public function searchByWord(Request $request)
    {
        $searchParams = request()->all();
        unset($searchParams['keyword']);
        if (isset($searchParams['sort']) && $searchParams['sort'] == 'location') {
            unset($searchParams['sort']);
        }
        unset($searchParams['_token']);

        $searchParams = array_merge($searchParams, [KEYWORD => $request->keyword]);

        return redirect(route(FRONT_LOAD_DATA_SEARCH, $searchParams));
    }
}
