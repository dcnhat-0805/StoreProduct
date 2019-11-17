<?php

namespace App\Http\Controllers\FrontEnd;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index($slug)
    {
        $params = request()->all();
        $category_slug = request()->get('parent');
        $category_name = Category::getCategoryNameBySlug($category_slug);
        $product_category_name = ProductCategory::getProductCategoryNameBySlug($slug);
        $titleName = ProductCategory::getNameAndSlugBySlug($slug);
        $products = Product::getListProductBySlugProductCategory($slug);

        if (!count($products) && isset($params['page']) && $params['page']) {
            $route = Helper::isHasDataByPages($products);

            return redirect($route);
        }

        return view('frontend.pages.product.index', compact('titleName', 'products', 'slug'));
    }

    public function detail($description)
    {
        $titleName = Product::getNameAndSlugBySlug($description);
        $product = Product::getProductBySlugAndId($description);
//        $product->attribute = ProductAttribute::getProductAttributeByProductId($id);
        $titleName['product_name'] = $product->product_description;

        return view('frontend.pages.product.detail', compact('titleName', 'product'));
    }
}
