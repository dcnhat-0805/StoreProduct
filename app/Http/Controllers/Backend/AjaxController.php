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
            $productCategories = ProductCategory::loadProductCategory($categoryId);
            $productCategoryOption = [];

            $productCategoryOption[''] = 'Please select a product category';
            foreach ($productCategories as $productCategory) {
                $productCategoryOption[$productCategory['id']] = $productCategory['product_category_name'];
            }

            $html = view('backend.pages.ajax._select_product_category', ['productCategory' => $productCategoryOption])->render();

            return response()->json($html);
        }
    }

    public function getProductType()
    {
        if (request()->ajax()) {
            $productCategoryId = request()->get('product_category_id');
            $productTypes = ProductType::loadProductType($productCategoryId);
            $productTypeOption = [];

            $productTypeOption[''] = 'Please select a product type';
            foreach ($productTypes as $productType) {
                $productTypeOption[$productType['id']] = $productType['product_type_name'];
            }

            $html = view('backend.pages.ajax._select_product_type', ['productTypes' => $productTypeOption])->render();

            return response()->json($html);
        }
    }
}
