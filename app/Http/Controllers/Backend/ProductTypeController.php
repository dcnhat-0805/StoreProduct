<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ProductTypeRequest;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductTypeController extends Controller
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
        $productCategories = ProductCategory::getOptionProductCategory();
        $productTypes = ProductType::getListAllProductType($params);

        return view('backend.pages.product_type.index', compact('category', 'productTypes', 'productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductTypeRequest $request)
    {
        $user = Auth::guard('admins')->user();
        if ($user->can('createProductType', ProductType::class)) {
            if ($request->ajax()) {
                $input = $request->all();
                $productType = ProductType::createProductType($input);

                if ($productType) {
                    Session::flash("success", trans("messages.product_type.create_success"));
                    return response()->json($productType, 200);
                } else {
                    Session::flash("error", trans("messages.product_type.create_failed"));
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductTypeRequest $request, $id)
    {
        $user = Auth::guard('admins')->user();
        if ($user->can('updateProductType', ProductType::class)) {
            if ($request->ajax()) {
                $input = $request->all();
                $productType = ProductType::updateProductType($input, $id);

                if ($productType) {
                    Session::flash("success", trans("messages.product_type.update_success"));
                    return response()->json($productType, 200);
                } else {
                    Session::flash("error", trans("messages.product_type.update_failed"));
                }
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
        $user = Auth::guard('admins')->user();
        if ($user->can('deleteProductType', ProductType::class)) {
            $productType = ProductType::deleteProductType($id);

            if (isset($productType)) {
                Session::flash("success", trans("messages.product_type.delete_success"));
                return response()->json();
            } else {
                Session::flash("error", trans("messages.product_type.delete_failed"));
                return response()->json();
            }
        }
    }

    public function getListProductCategory()
    {
        $productTypes = ProductCategory::getListAllProductCategory();
        $data = [];

        if (count($productTypes)) {
            foreach ($productTypes as $productType) {
                $data[] = [
                    'id' => $productType->id
                ];
            }
        }

        return response()->json(array_flatten($data));
    }

    public function destroy(Request $request)
    {
        $user = Auth::guard('admins')->user();
        if ($user->can('deleteProductType', ProductType::class)) {
            try {
                ProductType::destroy($request->input('ids'));
                if ($request->input('ids') != DELETE_ALL) {
                    Session::flash("success", trans("messages.product_category.delete_success"));
                }
            } catch (\Exception $e) {
                Session::flash("error", trans("messages.product_category.delete_failed"));
            }
        }
    }
}
