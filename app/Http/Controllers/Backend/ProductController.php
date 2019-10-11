<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UploadService;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    protected $uploadImage;

    public function __construct(UploadService $uploadImage)
    {
        $this->uploadImage = $uploadImage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::getOptionCategory();
        $productCategories = ProductCategory::getOptionProductCategory();
        $productTypes = ProductType::getOptionProductType();

        return view('backend.pages.product.index', compact('category', 'productCategories', 'productTypes'));
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

        return view('backend.pages.product.add', compact('category', 'productCategories', 'productTypes'));
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

        return response()->json($input);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
