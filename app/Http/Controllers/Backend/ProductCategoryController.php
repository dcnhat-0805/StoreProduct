<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = request()->all();
        $category = Category::getOptionCategory();
        $productCategories = ProductCategory::getListAllProductCategory($params);

        return view('backend.pages.product_category.index', compact('productCategories', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $productCategory = ProductCategory::createProductCategory($input);

            if ($productCategory) {
                Session::flash("success", trans("messages.product_category.create_success"));
                return response()->json($productCategory, 200);
            } else {
                Session::flash("error", trans("messages.product_category.create_failed"));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, $id)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $productCategory = ProductCategory::updateProductCategory($input, $id);

            if ($productCategory) {
                Session::flash("success", trans("messages.product_category.update_success"));
                return response()->json($productCategory, 200);
            } else {
                Session::flash("error", trans("messages.product_category.update_failed"));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $productCategory = ProductCategory::deleteProductCategory($id);

        if (isset($productCategory)) {
            Session::flash("success", trans("messages.category.delete_success"));
            return response()->json();
        } else {
            Session::flash("error", trans("messages.category.delete_failed"));
            return response()->json();
        }
    }

    public function getListProductCategory()
    {
        $productCategory = ProductCategory::getListAllProductCategory();
        $data = [];

        if (count($productCategory)) {
            foreach ($productCategory as $proCategory) {
                $data[] = [
                    'id' => $proCategory->id
                ];
            }
        }

        return response()->json(array_flatten($data));
    }

    public function destroy(Request $request)
    {
        try {
            ProductCategory::destroy($request->input('ids'));
            if ($request->input('ids') != DELETE_ALL) {
                Session::flash("success", trans("messages.product_category.delete_success"));
            }
        } catch (\Exception $e) {
            Session::flash("error", trans("messages.product_category.delete_failed"));
        }
    }
}
