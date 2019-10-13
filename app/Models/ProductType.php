<?php

namespace App\Models;

use App\Helpers\Helper;
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

    private static function filter($params)
    {
        $productType = new ProductType();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            if ($keyword != 0 || $keyword != null) {
                $productType = $productType->where('product_type_name', 'like', "%$keyword%")
                    ->orWhere('product_type_slug', 'like', "%$keyword%");
            }
        }

        if (isset($params['created_at'])) {
            $publishDate = $params['created_at'];
            if ($publishDate != 0) {
                $publishDate = str_replace('+', ' ', $publishDate);
                $publishDate = explode(' - ', $publishDate);
                $productType = $productType->whereRaw("product_types.created_at BETWEEN ? AND ?", [$publishDate[0], date('Y/m/d', strtotime("+1 day", strtotime($publishDate[1])))]);
            }
        }

        if (isset($params['category_id'])) {
            $category_id = $params['category_id'];
            if ($category_id != 0) {
                $productType = $productType->whereIn('categories.id', explode(',', $category_id));
            }
        }

        if (isset($params['product_category_id'])) {
            $product_category_id = $params['product_category_id'];
            if ($product_category_id != 0) {
                $productType = $productType->whereIn('product_categories.id', explode(',', $product_category_id));
            }
        }


        if (isset($params['status'])) {
            $status = $params['status'];

            $productType = $productType->where(function ($query) use ($status) {
                if (in_array(0, $status)) {
                    $query->orWhereRaw("(product_types.product_type_status = 0)");
                }
                if (in_array(1, $status)) {
                    $query->orWhereRaw("(product_types.product_type_status = 1)");
                }
            });
        }

        return $productType;
    }

    public static function getListAllProductType($params = null)
    {
        $productType = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "product_types.id DESC ";
        }

        $productType = $productType->whereNull('product_types.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
            ->join('categories', 'categories.id', '=', 'product_types.category_id')
            ->join('product_categories', 'product_categories.id', '=', 'product_types.product_category_id')
            ->selectRaw("product_types.*")
            ->with('category', 'productCategory')
            ->groupBy('product_types.id')
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $productType;
    }

    public static function createProductType($request)
    {
        $request['product_type_slug'] = utf8ToUrl($request['product_type_name']);

        if ($request['submit']) {
            return self::create($request);
        }
    }

    public static function showProductType($product_type_id)
    {
        return self::find($product_type_id);
    }

    public static function updateProductType($request, $product_type_id)
    {
        $productType = self::showProductType($product_type_id);
        $request['product_type_slug'] = utf8ToUrl($request['product_type_name']);

        if ($request['submit']) {
            return $productType->update($request);
        }
    }

    public static function deleteProductType($product_type_id)
    {
        $productType = self::showProductType($product_type_id);

        return $productType->delete();
    }

    public static function searchProductType($keyWord, $length)
    {
        if ($keyWord == '') {
            $productType = self::orderBy('id', 'DESC')
                ->offset(0)->limit(2)
                ->get();
        } else {
            $productType = self::where('product_type_name', 'like', '%' . $keyWord . '%')
                ->orWhere('product_type_slug', 'like', '%' . $keyWord . '%')
                ->orWhere('id', $keyWord)->get();
        }

        if ($length != '') {
            $productType = self::orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $productType;
    }

    public static function getEntriesProductType($entries)
    {
        $productType = self::select('category_id', 'product_category_id', 'product_type_name', 'product_type_status')
            ->orderby('id', 'DESC')
            ->offset(0)->limit($entries)->get();
        return $productType;
    }

    public static function getProductType($product_type_id)
    {
        $productType = self::select('category_id', 'product_category_id', 'product_type_name', 'product_type_status')
            ->orderBy('id', 'DESC')->where('id_Product_Category', $product_type_id)
            ->offset(0)->limit(2)->get();
        return $productType;
    }

    public static function loadProductType($product_type_id)
    {
        $productType = self::select('id', 'product_type_name')
            ->orderby('id')
            ->whereNull('deleted_at')
            ->where('product_category_id', $product_type_id)
            ->get();

        return $productType;
    }

    public static function getOptionProductType()
    {
        $productTypes = self::select('id', 'product_type_name')
            ->whereNull('deleted_at')
            ->get();

        $productTypeOption = [];

        $productTypeOption[''] = 'Please select a product type';
        foreach ($productTypes as $productType) {
            $productTypeOption[$productType['id']] = $productType['product_type_name'];
        }

        return $productTypeOption;
    }
}
