<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'category_name', 'category_slug', 'category_order', 'category_status',
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

    private static function filter($params)
    {
        $category = new Category();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            if ($keyword != 0 || $keyword != null) {
                $category = $category->where('category_name', 'like', "%$keyword%")
                    ->orWhere('category_slug', 'like', "%$keyword%")
                    ->orWhere('category_order', 'like', "%$keyword%");
            }
        }

        if (isset($params['created_at'])) {
            $publishDate = $params['created_at'];
            if ($publishDate != 0) {
                $publishDate = str_replace('+', ' ', $publishDate);
                $publishDate = explode(' - ', $publishDate);
                $category = $category->whereRaw("created_at BETWEEN ? AND ?", [$publishDate[0], date('Y/m/d', strtotime("+1 day", strtotime($publishDate[1])))]);
            }
        }


        if (isset($params['status'])) {
            $status = $params['status'];

            $category = $category->where(function ($query) use ($status) {
//                if (in_array(2, $status)) {
//                    $query->orWhereRaw("(status = 1 AND date_from > '" . date("Y-m-d") . "')");
//                }
//
//                if (in_array(1, $status)) {
//                    $query->orWhereRaw("(status = 1 AND date_from <= '" . date("Y-m-d")
//                        . "' AND (date_to is null OR date_to >= '" . date('Y-m-d') . "'))");
//                }
//
//                if (in_array(3, $status)) {
//                    $query->orWhereRaw("(status = 1 AND (date_to < '" . date('Y-m-d') . "'))");
//                }

                if (in_array(0, $status)) {
                    $query->orWhereRaw("(category_status = 0)");
                }
                if (in_array(1, $status)) {
                    $query->orWhereRaw("(category_status = 1)");
                }
            });
        }

        return $category;
    }

    public static function getListAllCategory($params = null)
    {
        $category = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "id DESC ";
        }
        $now = date('Y-m-d');
        $category = $category->whereNull('deleted_at')
            ->selectRaw("categories.*")
            ->groupBy('id')
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $category;
    }

    public static function getOptionCategory()
    {
        $categories = self::select('id', 'category_name')
            ->whereNull('deleted_at')
            ->get();

        $categoryOption = [];

        $categoryOption[''] = 'Please select a category';
        foreach ($categories as $category) {
            $categoryOption[$category['id']] = $category['category_name'];
        }

        return $categoryOption;
    }

    public static function getMenuCategory()
    {
        $categories = self::whereNull('categories.deleted_at')
            ->selectRaw("categories.id, categories.category_name, categories.category_slug")
            ->orderByRaw('categories.category_order', 'DESC')
            ->where('category_status', '=', '1')
            ->get();

        return $categories;
    }

    public static function createCategory($request)
    {
        $request['category_slug'] = utf8ToUrl($request['category_name']);

        if ($request['submit']) {
            return Category::create($request);
        }
    }

    public static function showCategoryById($category_id)
    {
        return Category::find($category_id);
    }

    public static function showCategoryByName($category_name)
    {
        $category = Category::select('id', 'category_name', 'category_order', 'category_status')
                        ->where('category_name', $category_name)->first();

        return $category;
    }

    public static function updateCategory($category_id, $request)
    {
        $category = Category::showCategoryById($category_id);
        $request['category_slug'] = utf8ToUrl($request['category_name']);

        if ($request['submit']) {
            return $category->update($request);
        }
    }

    public static function deleteCategory($category_id)
    {
        $category = Category::showCategoryById($category_id);
        return $category->delete();
    }

    public static function getCategoryNameBySlug($slug)
    {
        return self::select('category_name')
                ->whereNull('deleted_at')
                ->where('category_slug', $slug)
                ->pluck('category_name')
                ->first();
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
