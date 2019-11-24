<?php

namespace App\Http\Controllers\FrontEnd;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\Rating;
use Cart;
use Auth;
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
        $products = Product::getListProductOnFrontEnd($slug);

        if (!count($products) && isset($params['page']) && $params['page']) {
            $route = Helper::isHasDataByPages($products);

            return redirect($route);
        }

        return view('frontend.pages.product.index', compact('titleName', 'products', 'slug'));
    }

    public function detail($description)
    {
        $user = Auth::user();
        $titleName = Product::getNameAndSlugBySlug($description);
        $product = Product::getProductBySlugAndId($description);
        $products = Product::getListProductOnFrontEndByCategoryId($product->category_id);
//        $product->attribute = ProductAttribute::getProductAttributeByProductId($id);
        $titleName['product_name'] = $product->product_description;

        $ratePoint = 3;
        if ($user) {
            $ratePoint = Rating::getRatingByUserId($user->id, $product->id);
        }

        $avgRating = number_format(Rating::getAvgRatingByProductId($product->id), 0);
        $countRating = Rating::getCountRating($product->id);

        Product::updateProductView($product->id);

        return view('frontend.pages.product.detail', compact(
            'titleName', 'product', 'products', 'ratePoint', 'avgRating', 'countRating'
        ));
    }

    public function updateRating(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $productId = $request->get('productId');

            $productId = !$productId ? 0 : $productId;
            $product = Product::showProduct($productId);

            if (!$product) {
                return response()->json(0);
            } else {
                $point = $request->get('point');

                $rating = Rating::firstorNew([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ]);
                $rating->point = $point;

                if ($rating->save()) {
                    $ratePoint = Rating::getRatingByUserId($user->id, $product->id);

                    return response()->json($ratePoint);
                } else {
                    return response()->json(0);
                }
            }
        }
    }
}
