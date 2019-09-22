<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProductCategory;
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
}
