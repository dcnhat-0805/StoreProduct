<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'category_name', 'category_slug', 'category_status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function productCategory()
    {
        return $this->hasMany('App\Models\ProductCategory', 'category_id', 'id');
    }

    public function productType()
    {
        return $this->hasMany('App\Models\ProductType', 'category_id', 'id');
    }

    public function product()
    {
        return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }

    public function getListAllCategory()
    {
        return $this->select('category_name', 'category_status')->orderBy('id', 'DESC')->get();
    }

    public function getListCategory()
    {
        return $this->select('category_name', 'category_status')->orderBy('id', 'DESC')->paginate(1);
    }

    public function createCategory($request)
    {
        if ($request['category_name'] != '') {
            $request['category_slug'] = utf8ToUrl($request['category_name']);
        }
        return $this->create($request);
    }

    public function showCategoryById($category_id)
    {
        return $this->find($category_id);
    }

    public function updateCategory($category_id, $request)
    {
        $category = $this->showCategory($category_id);
        if ($request['category_name'] != '') {
            $request['category_slug'] = utf8ToUrl($request['category_name']);
        }
        return $category->update($request);
    }

    public function deleteCategory($category_id)
    {
        $category = $this->showCategory($category_id);
        return $category->delete();
    }

    public function searchCategory($keyWord, $length)
    {
        if ($keyWord == '') {
            $category = Category::orderBy('id', 'DESC')
                ->offset(0)->limit(2)
                ->get();
        } else {
            $category = Category::where('category_name', 'like', '%' . $keyWord . '%')
                ->orWhere('name_Category', 'like', '%' . $keyWord . '%')
                ->orWhere('id', $keyWord)->get();
        }

        if ($length != '') {
            $category = Category::orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $category;
    }

}
