<?php

namespace App\Models;

use App\Helpers\Helper;
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

    private static function filter($params)
    {
        $productCategory = new ProductCategory();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            if ($keyword != 0 || $keyword != null) {
                $productCategory = $productCategory->where('product_category_name', 'like', "%$keyword%")
                    ->orWhere('product_category_slug', 'like', "%$keyword%");
            }
        }

        if (isset($params['created_at'])) {
            $publishDate = $params['created_at'];
            if ($publishDate != 0) {
                $publishDate = str_replace('+', ' ', $publishDate);
                $publishDate = explode(' - ', $publishDate);
                $productCategory = $productCategory->whereRaw("product_categories.created_at BETWEEN ? AND ?", [$publishDate[0], date('Y/m/d', strtotime("+1 day", strtotime($publishDate[1])))]);
            }
        }

        if (isset($params['category_id'])) {
            $category_id = $params['category_id'];
            if ($category_id != 0) {
                $productCategory = $productCategory->whereIn('categories.id', explode(',', $category_id));
            }
        }


        if (isset($params['status'])) {
            $status = $params['status'];

            $productCategory = $productCategory->where(function ($query) use ($status) {
                if (in_array(0, $status)) {
                    $query->orWhereRaw("(product_categories.product_category_status = 0)");
                }
                if (in_array(1, $status)) {
                    $query->orWhereRaw("(product_categories.product_category_status = 1)");
                }
            });
        }

        return $productCategory;
    }

    public static function getListAllProductCategory($params = null)
    {
        $productCategory = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "product_categories.id DESC ";
        }
        $now = date('Y-m-d');
        $productCategory = $productCategory->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
            ->join('categories', 'categories.id', '=', 'product_categories.category_id')
            ->selectRaw("product_categories.*, categories.category_name")
            ->with('category')
            ->groupBy('product_categories.id')
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $productCategory;
    }

    public static function createProductCategory($request)
    {
        $request['product_category_slug'] = utf8ToUrl($request['product_category_name']);

        return self::create($request);
    }

    public static function showProductCategory($product_category_id)
    {
        return self::find($product_category_id);
    }

    public static function updateProductCategory($request, $product_category_id)
    {
        $productCategory = self::showProductCategory($product_category_id);
        $request['product_category_slug'] = utf8ToUrl($request['product_category_name']);

        return $productCategory->update($request);
    }

    public static function deleteProductCategory($product_category_id)
    {
        $productCategory = self::showProductCategory($product_category_id);

        return $productCategory->delete();
    }

    public static function searchProductCategory($keyWord, $length)
    {
        if ($keyWord == '') {
            $productCategory = self::getListAllProductCategory();
        } else {
            $productCategory = self::select('category_id', 'product_category_name', 'product_category_status')
                ->where('product_category_name', 'like', '%' . $keyWord . '%')
                ->orWhere('product_category_slug', 'like', '%' . $keyWord . '%')
                ->orWhere('id', $keyWord)->get();
        }

        if ($length != '') {
            $productCategory = self::select('category_id', 'product_category_name', 'product_category_status')
                ->orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $productCategory;
    }

    public static function loadProductCategory($category_id)
    {
        $productCategory = self::select('category_id', 'product_category_name', 'product_category_status')
            ->orderby('id', 'DESC')
            ->where('id_Category', $category_id)->get();
        return $productCategory;
    }

    public static function getProductCategory($product_category_id)
    {
        $productCategory = self::select('category_id', 'product_category_name', 'product_category_status')
            ->where('id', $product_category_id)->get();
        return $productCategory;
    }
}
