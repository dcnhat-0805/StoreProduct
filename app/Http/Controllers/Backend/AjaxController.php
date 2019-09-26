<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function getProductCategory()
    {
        if (request()->ajax()) {
            $categoryId = request()->get('category_id');
            $productCategory = ProductCategory::loadProductCategory($categoryId);

            return response()->json($productCategory);
        }
    }

    public function getProductType()
    {
        if (request()->ajax()) {
            $productCategoryId = request()->get('product_category_id');
            $productType = ProductType::loadProductType($productCategoryId);

            return response()->json($productType);
        }
    }
}
