<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = [
        'category_id', 'product_category_name', 'product_category_slug', 'product_category_status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function productType(){
        return $this->hasMany('App\Models\ProductType','product_category_id','id');
    }

    public function product(){
        return $this->hasMany('App\Models\Product','product_category_id','id');
    }

    public function getListAllProductCategory()
    {
        return $this->select('category_id', 'product_category_name', 'product_category_status')
            ->orderBy('id', 'DESC')->get();
    }

    public function getListProductCategory()
    {
        return $this->select('category_id', 'product_category_name', 'product_category_status')
            ->orderBy('id', 'DESC')->paginate(2);
    }

    public function createProductCategory($request)
    {
        if ($request['product_category_name'] != '') {
            $request['product_category_slug'] = utf8ToUrl($request['product_category_name']);
        }
        return $this->create($request);
    }

    public function showProductCategory($product_category_id)
    {
        return $this->find($product_category_id);
    }

    public function updateProductCategory($request, $product_category_id)
    {
        $productCategory = $this->showProductCategory($product_category_id);
        if ($request['product_category_name'] != '') {
            $request['product_category_slug'] = utf8ToUrl($request['product_category_name']);
        }
        return $productCategory->update($request);
    }

    public function deleteProductCategory($product_category_id)
    {
        $productCategory = $this->showProductCategory($product_category_id);
        return $productCategory->delete();
    }

    public function searchProductCategory($keyWord, $length)
    {
        if ($keyWord == '') {
            $productCategory = $this->getListAllProductCategory();
        } else {
            $productCategory = $this->select('category_id', 'product_category_name', 'product_category_status')
                ->where('product_category_name', 'like', '%' . $keyWord . '%')
                ->orWhere('product_category_slug', 'like', '%' . $keyWord . '%')
                ->orWhere('id', $keyWord)->get();
        }

        if ($length != '') {
            $productCategory = $this->select('category_id', 'product_category_name', 'product_category_status')
                ->orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $productCategory;
    }

    public function loadProductCategory($category_id)
    {
        $productCategory = $this->select('category_id', 'product_category_name', 'product_category_status')
            ->orderby('id', 'DESC')
            ->where('id_Category', $category_id)->get();
        return $productCategory;
    }

    public function getProductCategory($product_category_id)
    {
        $productCategory = $this->select('category_id', 'product_category_name', 'product_category_status')
            ->where('id', $product_category_id)->get();
        return $productCategory;
    }
}
