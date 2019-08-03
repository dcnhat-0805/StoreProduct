<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;

    protected $table = 'product_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'product_type_name','product_type_slug', 'category_id', 'product_category_id', 'product_type_status'
    ];

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function productCategory() {
        return $this->belongsTo('App\Models\ProductCategory', 'product_category_id', 'id');
    }

    public function product()
    {
        return $this->hasMany('App\Models\Product', 'product_id', 'id');
    }

    public function getListAllProductType()
    {
        return $this->select('category_id', 'product_category_id', 'product_type_name', 'product_type_status')
            ->orderBy('id', 'DESC')->get();
    }

    public function getListProductType()
    {
        return $this->select('category_id', 'product_category_id', 'product_type_name', 'product_type_status')
            ->orderBy('id', 'DESC')->paginate(2);
    }

    public function createProductType($request)
    {
        if ($request['product_type_name'] != '') {
            $request['product_type_slug'] = utf8ToUrl($request['product_type_name']);
        }
        return $this->create($request);
    }

    public function showProductType($product_type_id)
    {
        return $this->find($product_type_id);
    }

    public function updateProductType($request, $product_type_id)
    {
        $productType = $this->showProductType($product_type_id);
        if ($request['product_type_name'] != '') {
            $request['product_type_slug'] = utf8ToUrl($request['product_type_name']);
        }
        return $productType->update($request);
    }

    public function deleteProductType($product_type_id)
    {
        $productType = $this->showProductType($product_type_id);
        return $productType->delete();
    }

    public function searchProductType($keyWord, $length)
    {
        if ($keyWord == '') {
            $productType = $this->orderBy('id', 'DESC')
                ->offset(0)->limit(2)
                ->get();
        } else {
            $productType = $this->where('product_type_name', 'like', '%' . $keyWord . '%')
                ->orWhere('product_type_slug', 'like', '%' . $keyWord . '%')
                ->orWhere('id', $keyWord)->get();
        }

        if ($length != '') {
            $productType = $this->orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $productType;
    }

    public function getEntriesProductType($entries)
    {
        $productType = $this->select('category_id', 'product_category_id', 'product_type_name', 'product_type_status')
            ->orderby('id', 'DESC')
            ->offset(0)->limit($entries)->get();
        return $productType;
    }

    public function getProductType($product_type_id)
    {
        $productType = $this->select('category_id', 'product_category_id', 'product_type_name', 'product_type_status')
            ->orderBy('id', 'DESC')->where('id_Product_Category', $product_type_id)
            ->offset(0)->limit(2)->get();
        return $productType;
    }

    public function loadProductType($product_type_id)
    {
        $productType = $this->select('category_id', 'product_category_id', 'product_type_name', 'product_type_status')
            ->where('id', $product_type_id)->get();
        return $productType;
    }
}
