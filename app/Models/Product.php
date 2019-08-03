<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id', 'product_category_id', 'product_type_id',
        'product_name', 'product_slug', 'product_image',
        'product_description', 'product_content', 'product_price',
        'product_promotional', 'count_buy',
        'product_view', 'product_status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function productImage() {
        return $this->hasMany('App\Models\ProductImage', 'product_id', 'id');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function productCategory() {
        return $this->belongsTo('App\Models\ProductCategory', 'product_category_id', 'id');
    }

    public function productType() {
        return $this->belongsTo('App\Models\ProductType', 'product_type_id', 'id');
    }

    public function getListAllProduct()
    {
        return $this->select(
            'category_id', 'product_category_id', 'product_type_id',
            'product_name', 'product_image',
            'product_description', 'product_content', 'product_price',
            'product_promotional', 'count_buy',
            'product_view', 'product_status')
            ->orderBy('id', 'DESC')->get();
    }

    public function getListProduct()
    {
        return $this->select(
            'category_id', 'product_category_id', 'product_type_id',
            'product_name', 'product_image',
            'product_description', 'product_content', 'product_price',
            'product_promotional', 'count_buy',
            'product_view', 'product_status')
            ->orderBy('id', 'DESC')->paginate(2);
    }

    public function createProduct($request)
    {
        if ($request['product_name'] != '') {
            $request['product_slug'] = utf8ToUrl($request['product_name']);
        }
        return $this->create($request);
    }

    public function showProduct($id_product)
    {
        return $this->find($id_product);
    }

    public function updateProduct($request, $product_id)
    {
        $product = $this->showProduct($product_id);
        if ($request['product_name'] != '') {
            $request['product_slug'] = utf8ToUrl($request['product_name']);
        }
        return $product->update($request);
    }

    public function deleteImageListProduct($product_id)
    {
        $file_path = 'assets/upload/image/product/detail/';
        $product = $this->showProduct($product_id);
        $product_image = $product->productImage->toArray();
        foreach ($product_image as $value) {
            File::delete($file_path.$value['product_image']);
        }
        return 1;
    }

    public function deleteProduct($product_id)
    {
        $file_path = 'assets/upload/image/product/';
        $product = $this->showProduct($product_id);
        if (File::exists($file_path.$product->product_image)) {
            unlink($file_path.$product->product_image);
        }
        return $product->delete();
    }

    public function searchProduct($keyWord, $length)
    {
        if ($keyWord == '') {
            $product = $this->orderBy('id', 'DESC')
                ->offset(0)->limit(2)
                ->get();
        } else {
            $product = $this->where('product_name', 'like', '%' . $keyWord . '%')
                ->orWhere('product_slug', 'like', '%' . $keyWord . '%')
                ->orWhere('id', $keyWord)->get();
        }

        if ($length != '') {
            $product = $this->orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $product;
    }

    public function loadProductOfIdProductType($product_type_id)
    {
        $product = $this->select(
            'category_id', 'product_category_id', 'product_type_id',
            'product_name', 'product_image',
            'product_description', 'product_content', 'product_price',
            'product_promotional', 'count_buy',
            'product_view', 'product_status')
            ->orderby('id', 'DESC')->where('product_type_id', $product_type_id)->get();
        return $product;
    }
}
