<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UploadService;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ProductController extends Controller
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
        $productTypes = ProductType::getOptionProductType();
        $products = Product::getListAllProduct($params);

        if (!count($products) && isset($params['page']) && $params['page']) {
            $route = Helper::isHasDataByPages($products);

            return redirect($route);
        }

        return view('backend.pages.product.index', compact('category', 'productCategories', 'productTypes', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::getOptionCategory();
        $productCategories = ProductCategory::getOptionProductCategory();
        $productTypes = ProductType::getOptionProductType();
        $product = new Product();

        return view('backend.pages.product.add', compact('category', 'productCategories', 'productTypes', 'product'));
    }

    public function uploadImages(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('file')) {
                $fileName = UploadService::moveImage(FILE_PATH_PRODUCT, $request->file('file'), PREFIX_PRODUCT);
                $type = $request->get('type');
                $size = UploadService::getFileSize($request->file('file'));
                $size = Helper::getRemoteFilesize($size);

                $data = [
                    'name' => $fileName,
                    'url' => asset(FILE_PATH_PRODUCT . $fileName),
                    'size' => $size
                ];

                Session::push(SESSION_PRODUCT_IMAGE, $data);

                return $data;
            }
        }
    }

    /**
     * Get images
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getImages(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $image = Session::get(SESSION_PRODUCT_IMAGE);
            $response = [];

            $response['images'] = [];
            if (isset($image)) {
                $response['images'] = $image;
            }

            return response()->json($response);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $input = $request->all();

        Product::beginTransaction();
        $product = Product::createProduct($input);
        if ($product) {
            if (isset($input['image_list']) && $input['image_list']) {
                ProductImage::createProductImage($input, $product->id);
            }

            if (isset($input['attributes']) && $input['attributes']) {
                ProductAttribute::createProductAttribute($input, $product->id);
            }
            Product::commit();
            Session::flash("success", trans("messages.product.create_success"));
        } else {
            Product::rollBack();
//                    Session::flash("error", trans("messages.product.create_failed"));
        }

        return redirect()->route(ADMIN_PRODUCT_INDEX);
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
        $category = Category::getOptionCategory();
        $productCategories = ProductCategory::getOptionProductCategory();
        $productTypes = ProductType::getOptionProductType();
        $product = Product::showProduct($id);
        $product->product_image = Helper::getDataImage(FILE_PATH_PRODUCT, $product->product_image);
        $product->product_image_list = Helper::getDataImageList(FILE_PATH_PRODUCT_IMAGE, ProductImage::getDataImageByProductId($id));
        $product->product_attribute = ProductAttribute::getProductAttributeByProductId($id);

        return view('backend.pages.product.edit', compact('category', 'productCategories', 'productTypes', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $input = $request->all();

        Product::beginTransaction();
        $product = Product::updateProduct($input, $id);
        if ($product) {
            if (isset($input['image_list']) && $input['image_list']) {
                ProductImage::createProductImage($input, $id);
            }

            if (isset($input['attributes']) && $input['attributes']) {
                ProductAttribute::createProductAttribute($input, $id);
            }
            Product::commit();
            Session::flash("success", trans("messages.product.create_success"));
        } else {
            Product::rollBack();
//                    Session::flash("error", trans("messages.product.create_failed"));
        }

        return redirect()->route(ADMIN_PRODUCT_INDEX);
    }

    public function getListProduct()
    {
        $products = Product::getListAllProduct();
        $data = [];

        if (count($products)) {
            foreach ($products as $product) {
                $data[] = [
                    'id' => $product->id
                ];
            }
        }

        return response()->json(array_flatten($data));
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
//        if ($user->can('deleteProductType', ProductType::class)) {

            $product = Product::showProduct($id);
            Product::beginTransaction();
            if ($product->delete()) {
                ProductImage::deleteProductImageByProductId($id);
                ProductAttribute::deleteProductAttributeByProductId($id);
                Product::commit();
                Session::flash("success", trans("messages.product.delete_success"));

                return response()->json();
            } else {
                Product::rollBack();
                Session::flash("error", trans("messages.product.delete_failed"));

                return response()->json();
            }
//        }
    }

    public function destroy(Request $request)
    {
        $user = Auth::guard('admins')->user();
//        if ($user->can('deleteProductType', ProductType::class)) {
            Product::beginTransaction();
            try {
                Product::destroy($request->get('ids'));
                ProductImage::deleteProductImageByArrayProductId($request->get('ids'));
                ProductAttribute::deleteProductAttributeByArrayProductId($request->get('ids'));
                Product::commit();
                Session::flash("success", trans("messages.product.delete_success"));
            } catch (\Exception $e) {
                Product::rollBack();
                Session::flash("error", trans("messages.product.delete_failed"));
            }
//        }
    }

    public function deleteImages()
    {
        if (request()->ajax()) {
            $fileName = request()->fileName;
            $type = request()->type;
//            $product_image = Session::get(SESSION_PRODUCT_IMAGE);
//            if ($fileName) {
//                UploadService::deleteFile(FILE_PATH_PRODUCT, $fileName);
//            }
            Session::forget(SESSION_PRODUCT_IMAGE);

            return response('success', 200);
        }
    }
}
