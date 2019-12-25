<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id', 'product_category_id', 'product_type_id',
        'product_name', 'product_slug', 'product_image',
        'product_description','product_description_slug', 'product_content', 'product_price',
        'product_meta_title', 'product_meta_description', 'product_quantity',
        'product_is_free_ship', 'product_option',
        'product_promotion', 'product_status',
    ];

    public $guarded = [
        'count_buy',
        'product_view',
        'count_view',
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

    public function productAttribute() {
        return $this->hasMany('App\Models\ProductAttribute', 'product_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'product_id', 'id');
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }

    /**
     * Begin transaction
     *
     * @return void
     */
    public static function beginTransaction()
    {
        self::getConnectionResolver()->connection()->beginTransaction();
    }

    /**
     * Commit transaction
     *
     * @return void
     */
    public static function commit()
    {
        self::getConnectionResolver()->connection()->commit();
    }

    /**
     * RollBack transaction
     *
     * @return void
     */
    public static function rollBack()
    {
        self::getConnectionResolver()->connection()->rollBack();
    }

    public static function getSearchParams()
    {
        $params = [];

        if (\request()->has(KEYWORD)) {
            $params[KEYWORD] = request()->get(KEYWORD);
//            $params[KEYWORD] = self::removeUnsafeString($params[KEYWORD]);
        }

        if (\request()->has(COLORS)) {
            $params[COLORS] = request()->get(COLORS);
            $params[COLORS] = self::removeUnsafeString($params[COLORS]);
        }

        if (\request()->has(SIZES)) {
            $params[SIZES] = request()->get(SIZES);
            $params[SIZES] = self::removeUnsafeString($params[SIZES]);
        }

        if (\request()->has(MATERIAL)) {
            $params[MATERIAL] = request()->get(MATERIAL);
            $params[MATERIAL] = self::removeUnsafeString($params[MATERIAL]);
        }

        if (\request()->has(DISCOUNT)) {
            $params[DISCOUNT] = request()->get(DISCOUNT);
            $params[DISCOUNT] = self::removeUnsafeString($params[DISCOUNT]);
        }

        if (\request()->has(RATING)) {
            $params[RATING] = request()->get(RATING);
            $params[RATING] = self::removeUnsafeString($params[RATING]);
        }

        if (\request()->has(PRICE)) {
            $params[PRICE] = request()->get(PRICE);
            $params[PRICE] = self::removeUnsafeString($params[PRICE]);
        }

        if (\request()->has(SORT)) {
            $params[SORT] = request()->get(SORT);
//            $params[PRICE] = self::removeUnsafeString($params[PRICE]);
        }

        return $params;
    }

    public static function removeUnsafeString($string)
    {
        $string = rtrim($string, '/');
        $string = rtrim($string, '%');
        $string = trim(preg_replace('/\s+/', ' ', $string));

        return $string;
    }


    public static function getQueryBySearchParams($model, $params, $page = null)
    {
        if (isset($params[KEYWORD])) {
            $keyword = preg_replace('!\s+!', ' ', $params[KEYWORD]);

            if ($keyword != '') {
                $wordArray = preg_split("/\s|・|　/", $keyword);
                $keyword = explode(" ", $keyword);
                $model = $model->where(function ($subQuery) use ($wordArray, $keyword) {
                    foreach ($keyword as $key => $value) {
                        $subQuery->orWhere(function ($query) use ($wordArray, $value) {
                            if (count($wordArray) > 1) {
                                $query->orWhere('categories.category_name', 'like', "%$value%")
                                    ->orWhere('product_categories.product_category_name', 'like', "%$value%")
                                    ->orWhere('product_types.product_type_name', 'like', "%$value%")
                                    ->orWhere('products.product_name', 'like', "%$value%");
                            } else {
                                $query->orWhereRaw("REPLACE (REPLACE (REPLACE (categories.category_name,'・',''),' ',''),'　','') LIKE ?", "%$value%")
                                    ->orWhereRaw("REPLACE (REPLACE (REPLACE (product_categories.product_category_name,'・',''),' ',''),'　','') LIKE ?", "%$value%")
                                    ->orWhereRaw("REPLACE (REPLACE (REPLACE (product_types.product_type_name,'・',''),' ',''),'　','') LIKE ?", "%$value%")
                                    ->orWhereRaw("REPLACE (REPLACE (REPLACE (products.product_name,'・',''),' ',''),'　','') LIKE ?", "%$value%");
                            }

                            $query->orWhere('products.id', 'like', "%$value%")
                                ->orWhere('products.product_name', 'like', "%$value%")
                                ->orWhere('products.product_slug', 'like', "%$value%")
                                ->orWhere('products.product_price', 'like', "%$value%")
                                ->orWhere('products.product_promotion', 'like', "%$value%")
                                ->orWhere('products.product_description', 'like', "%$value%")
                                ->orWhere('products.product_description_slug', 'like', "%$value%")
                                ->orWhere('products.product_meta_title', 'like', "%$value%")
                                ->orWhere('products.product_meta_description', 'like', "%$value%");
                        });
                    }
                });
            }
        }

        if (isset($params[COLORS])) {
            $color = $params[COLORS];
            if ($color) {
                $model = $model->where('product_attributes.attribute_item_name', 'like', '%' . $color .'%');
            }
        }

        if (isset($params[SIZES])) {
            $size = $params[SIZES];
            if ($size) {
                $model = $model->where('product_attributes.attribute_item_name', 'like', '%' . $size .'%');
            }
        }

        if (isset($params[MATERIAL])) {
            $materials = $params[MATERIAL];
            if ($materials) {
                $model = $model->where('product_attributes.attribute_item_name', 'like', '%' . $materials .'%');
            }
        }

        if (isset($params[DISCOUNT])) {
            $discount = $params[DISCOUNT];
            if ($discount) {
                $model = $model->whereNotNull('products.product_promotion')
                    ->whereRaw('(((products.product_price - products.product_promotion) / products.product_price) * 100) >= ' . $discount);
            }
        }

        if (isset($params[RATING])) {
            $rating = (float) $params[RATING];
            $rating = number_format($rating, 4, '.', ',');
            if ($rating >= 2.5) {
                $model = $model->selectRaw('AVG(ratings.point) AS average_rating')
                    ->havingRaw('AVG(ratings.point) >= ?', [$rating])
//                    ->havingRaw('AVG(ratings.point) <= ?', [6.0000])
                    ->join('ratings', 'ratings.product_id', 'products.id');
            }
        }

        if (isset($params[PRICE])) {
            $price = $params[PRICE];
            $price = explode(',', $price);
            if (count($price)) {
                $model = $model->where(function ($query) use ($price) {
//                    if (!$price[0] && $price[1]) {
//                        $model = $model->whereRaw("(CASE WHEN products.product_promotion IS NOT NULL AND products.product_promotion > 0 THEN products.product_promotion ELSE products.product_price END) <= ? ", [(int)$price[1]]);
//                    }
//                    if ($price[0] && !$price[1]) {
//                        $model = $model->whereRaw("(CASE WHEN products.product_promotion IS NOT NULL AND products.product_promotion > 0 THEN products.product_promotion ELSE products.product_price END) >= ? ", [(int)$price[0]]);
//                    }
//                    if ($price[0] && $price[1]) {
//                        $model = $model->whereRaw("(CASE WHEN products.product_promotion IS NOT NULL AND products.product_promotion > 0 THEN products.product_promotion ELSE products.product_price END) BETWEEN ? AND ? ", [(int)$price[0], (int)$price[1]]);
//                    }
                    if (!$price[0] && $price[1]) {
                        $query->orWhereRaw("products.product_promotion <= ? ", [(int)$price[1]])
                            ->orWhereRaw("products.product_price <= ? ", [(int)$price[1]]);
                    }
                    if ($price[0] && !$price[1]) {
                        $query->orWhereRaw("products.product_promotion >= ? ", [(int)$price[0]])
                            ->orWhereRaw("products.product_price >= ? ", [(int)$price[0]]);
                    }
                    if ($price[0] && $price[1]) {
                        $query->orWhereRaw("products.product_promotion BETWEEN ? AND ? ", [(int)$price[0], (int)$price[1]])
                            ->orWhereRaw("products.product_price BETWEEN ? AND ? ", [(int)$price[0], (int)$price[1]]);
                    }
                });
            }
        }

        return $model;
    }

    private static function filter($params)
    {
        $products = new Product();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            $keyword = preg_replace("([+])", " ", $keyword);
            if ($keyword != 0 || $keyword != null) {
                $products = $products->where(function ($query) use ($keyword) {
                    $keyword_slug = convertStringToUrl($keyword);
                    $query->where('products.product_name', 'like', "%$keyword%")
                        ->orWhere('products.product_slug', 'like', "%$keyword_slug%")
                        ->orWhere('products.id', (int) $keyword);
                });
            }
        }

        if (isset($params['created_at'])) {
            $publishDate = $params['created_at'];
            if ($publishDate != 0) {
                $publishDate = str_replace('+', ' ', $publishDate);
                $publishDate = explode(' - ', $publishDate);
                $products = $products->whereRaw("products.created_at BETWEEN ? AND ?", [$publishDate[0], date('Y/m/d', strtotime("+1 day", strtotime($publishDate[1])))]);
            }
        }

        if (isset($params['category_id'])) {
            $category_id = $params['category_id'];
            if ($category_id != 0) {
                $products = $products->whereIn('categories.id', explode(',', $category_id));
            }
        }

        if (isset($params['product_category_id'])) {
            $product_category_id = $params['product_category_id'];
            if ($product_category_id != 0) {
                $products = $products->whereIn('product_categories.id', explode(',', $product_category_id));
            }
        }

        if (isset($params['product_type_id'])) {
            $product_type_id = $params['product_type_id'];
            if ($product_type_id != 0) {
                $products = $products->whereIn('product_types.id', explode(',', $product_type_id));
            }
        }


        if (isset($params['status'])) {
            $status = $params['status'];

            $products = $products->where(function ($query) use ($status) {
                if (in_array(0, $status)) {
                    $query->orWhereRaw("(products.product_status = 0)");
                }
                if (in_array(1, $status)) {
                    $query->orWhereRaw("(products.product_status = 1)");
                }
            });
        }

        if (isset($params['exist'])) {
            $exist = $params['exist'];

            $products = $products->where(function ($query) use ($exist) {
                if (in_array(0, $exist)) {
                    $query->orWhereRaw(
                        DB::raw("((CASE WHEN (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) IS NOT NULL THEN
                            (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) ELSE products.product_quantity END)) = 0")
                    );
                }
                if (in_array(1, $exist)) {
                    $query->orWhereRaw(
                        DB::raw("((CASE WHEN (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) IS NOT NULL THEN
                            (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) ELSE products.product_quantity END)) > 0")
                    );
                }
            });
        }

        if (isset($params['option'])) {
            $option = $params['option'];

            $products = $products->where(function ($query) use ($option) {
                if (in_array(BEST, $option)) {
                    $query->orWhereRaw("(products.product_option = 1)");
                }
                if (in_array(NEWS, $option)) {
                    $query->orWhereRaw("(products.product_option = 2)");
                }
                if (in_array(HOT, $option)) {
                    $query->orWhereRaw("(products.product_option = 3)");
                }
                if (in_array(PROMOTION, $option)) {
                    $query->orWhereRaw("(products.product_option = 4)");
                }
            });
        }

        return $products;
    }

    public static function isProductSlug($slug)
    {
        return self::whereNull('deleted_at')
            ->where('product_slug', $slug)
            ->exists();
    }

    public static function getListAllProduct($params = null)
    {
        $products = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "products.id DESC ";
        }

        $products = $products->whereNull('products.deleted_at')
//            ->whereNull('product_types.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftjoin('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->leftjoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->selectRaw("products.*")
            ->selectRaw(
                DB::raw("(CASE WHEN (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) IS NOT NULL THEN
                (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) ELSE products.product_quantity END) as exist")
            )
            ->with([
                'category' => function ($category) {
                    $category->whereNull('categories.deleted_at');
                },
                'productCategory' => function ($productCategory) {
                    $productCategory->whereNull('product_categories.deleted_at');
                },
                'productType' => function ($productType) {
                    $productType->whereNull('product_types.deleted_at');
                },
                'productImage' => function ($productImage) {
                    $productImage->whereNull('product_images.deleted_at')
                                ->where('product_images.product_image_name', '<>', '0');
                },
            ])
            ->groupBy('products.id')
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $products;
    }

    public static function getListProductOnFrontEnd($slug, $params = null, $order = 'products.id desc')
    {
        $isCategorySlug = Category::isCategorySlug($slug);
        $isProductCategorySlug = ProductCategory::isProductCategorySlug($slug);
        $isProductTypeSlug = ProductType::isProductTypeSlug($slug);
        $isProductSlug = self::isProductSlug($slug);

        $products = self::whereNull('products.deleted_at')
            ->whereNull('product_types.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
//            ->where('products.product_option', $option)
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftjoin('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->leftjoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftjoin('product_attributes', 'product_attributes.product_id', '=', 'products.id')
//            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->selectRaw("products.*")
            ->selectRaw(
                DB::raw("(CASE WHEN (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) IS NOT NULL THEN
                (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) ELSE products.product_quantity END) AS exist")
            )
            ->selectRaw(
                DB::raw("(CASE WHEN ((SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status = 2 GROUP BY order_details.product_id)) IS NOT NULL THEN
                ((SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status = 2 GROUP BY order_details.product_id)) ELSE 0 END) AS count_buy")
            )
            ->selectRaw('(SELECT count(ratings.user_id) FROM ratings WHERE ratings.product_id = products.id GROUP BY ratings.product_id) AS count_rating')
            ->selectRaw('(SELECT FORMAT(AVG(ratings.point), 1) FROM ratings WHERE ratings.product_id = products.id GROUP BY ratings.product_id) AS average_rating')
            ->with([
                'category' => function ($category) {
                    $category->whereNull('categories.deleted_at');
                },
                'productCategory' => function ($productCategory) {
                    $productCategory->whereNull('product_categories.deleted_at');
                },
                'productType' => function ($productType) {
                    $productType->whereNull('product_types.deleted_at');
                },
                'productImage' => function ($productImage) {
                    $productImage->whereNull('product_images.deleted_at')
                        ->where('product_images.product_image_name', '<>', '0');
                },
            ])
//            ->where('categories.category_slug', $slug)
//            ->orWhere('product_categories.product_category_slug', $slug)
//            ->orWhere('product_types.product_type_slug', $slug)
//            ->orWhere('products.product_slug', $slug)
            ->groupBy('products.id')
            ->orderByRaw($order);

        if ($isCategorySlug) {
            $products = $products->where('categories.category_slug', $slug);
        }
        if ($isProductCategorySlug) {
            $products = $products->where('product_categories.product_category_slug', $slug);
        }
        if ($isProductTypeSlug) {
            $products = $products->where('product_types.product_type_slug', $slug);
        }
        if ($isProductSlug) {
            $products = $products->where('products.product_slug', $slug);
        }

        $products = self::getQueryBySearchParams($products, $params, null);


//        if (isset($params[RATING])) {
//            $rating = (int) $params[RATING];
//            $rating = number_format($rating, 4, '.', ',');
//            if ($rating) {
//                $products = $products->where('avg_rating', '>=', $rating);
//            }
//        }

        return $products->paginate(FRONT_LIMIT);
    }

    public static function getArrayProductId($slug, $params = null)
    {
        $products = self::getListProductOnFrontEnd($slug, $params);
        $arrayProductId = [];

        foreach ($products as $product) {
            array_push($arrayProductId, $product->id);
        }

        return $arrayProductId;
    }

    public static function getListProductOnFrontEndByCategoryId($category_id, $params = null)
    {
        $products = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "products.id DESC ";
        }

        $products = $products->whereNull('products.deleted_at')
//            ->whereNull('product_types.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftjoin('product_types', 'product_types.id', '=', 'products.product_type_id')
//            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->selectRaw("products.*")
            ->with([
                'category' => function ($category) {
                    $category->whereNull('categories.deleted_at');
                },
                'productCategory' => function ($productCategory) {
                    $productCategory->whereNull('product_categories.deleted_at');
                },
                'productType' => function ($productType) {
                    $productType->whereNull('product_types.deleted_at');
                },
                'productImage' => function ($productImage) {
                    $productImage->whereNull('product_images.deleted_at');
                },
            ])
            ->where('categories.id', $category_id)
//            ->orWhere('product_categories.product_category_slug', $slug)
//            ->orWhere('product_types.product_type_slug', $slug)
//            ->orWhere('products.product_slug', $slug)
            ->groupBy('products.id')
            ->orderByRaw($order)
            ->paginate(FRONT_LIMIT);

        return $products;
    }

    public static function getProductBySlugAndId($description, $params = null)
    {
        $products = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "products.id DESC ";
        }

        $products = $products->whereNull('products.deleted_at')
//            ->whereNull('product_types.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftjoin('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->leftjoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->leftjoin('ratings', 'products.id', 'ratings.product_id')
            ->selectRaw("products.*")
            ->selectRaw(
                DB::raw("(CASE WHEN (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) IS NOT NULL THEN
                (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) ELSE products.product_quantity END) AS exist")
            )
            ->selectRaw(
                DB::raw("(CASE WHEN ((SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status = 2 GROUP BY order_details.product_id)) IS NOT NULL THEN
                ((SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status = 2 GROUP BY order_details.product_id)) ELSE 0 END) AS count_buy")
            )
            ->selectRaw('(SELECT count(ratings.user_id) FROM ratings WHERE ratings.product_id = products.id GROUP BY ratings.product_id) AS count_rating')
            ->selectRaw('(SELECT FORMAT(AVG(ratings.point), 1) FROM ratings WHERE ratings.product_id = products.id GROUP BY ratings.product_id) AS average_rating')
            ->with([
                'category' => function ($category) {
                    $category->whereNull('categories.deleted_at');
                },
                'productCategory' => function ($productCategory) {
                    $productCategory->whereNull('product_categories.deleted_at');
                },
                'productType' => function ($productType) {
                    $productType->whereNull('product_types.deleted_at');
                },
                'productImage' => function ($productImage) {
                    $productImage->whereNull('product_images.deleted_at');
                },
                'productAttribute' => function ($productAttribute) {

                },
            ])
            ->where('products.product_description_slug' , $description)
//            ->orWhere('categories.category_slug', $slug)
//            ->orWhere('product_categories.product_category_slug', $slug)
//            ->orWhere('product_types.product_type_slug', $slug)
            ->orderBy('products.created_at', 'desc')
            ->groupBy('products.id')
            ->first();

        return $products;
    }

    public static function getNameAndSlugBySlug($description)
    {
        $products = self::join('categories', 'categories.id', '=', 'products.category_id')
            ->leftjoin('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->leftjoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->selectRaw("categories.category_name, product_categories.product_category_name, product_types.product_type_name,
                        categories.category_slug, product_categories.product_category_slug, product_types.product_type_slug"
            )
            ->where('products.product_description_slug', $description)
            ->first();

        return $products;
    }

    public static function getProductByOption($option, $params = null)
    {
        $products = self::filter($params);

        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "products.id DESC ";
        }

        $products = self::whereNull('products.deleted_at')
//            ->whereNull('product_types.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
            ->where('products.product_option', $option)
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftjoin('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->leftjoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftjoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->leftjoin('ratings', 'products.id', 'ratings.product_id')
            ->selectRaw("products.*")
            ->whereRaw(
                DB::raw("((CASE WHEN (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) IS NOT NULL THEN
                (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) ELSE products.product_quantity END)) > 0")
            )
            ->selectRaw(
                DB::raw("(CASE WHEN (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) IS NOT NULL THEN
                (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) ELSE products.product_quantity END) AS exist")
            )
            ->selectRaw(
                DB::raw("(CASE WHEN ((SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status = 2 GROUP BY order_details.product_id)) IS NOT NULL THEN
                ((SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status = 2 GROUP BY order_details.product_id)) ELSE 0 END) AS count_buy")
            )
            ->selectRaw('(SELECT count(ratings.user_id) FROM ratings WHERE ratings.product_id = products.id GROUP BY ratings.product_id) AS count_rating')
            ->selectRaw('(SELECT FORMAT(AVG(ratings.point), 1) FROM ratings WHERE ratings.product_id = products.id GROUP BY ratings.product_id) AS average_rating')
            ->with([
                'category' => function ($category) {
                    $category->whereNull('categories.deleted_at');
                },
                'productCategory' => function ($productCategory) {
                    $productCategory->whereNull('product_categories.deleted_at');
                },
                'productType' => function ($productType) {
                    $productType->whereNull('product_types.deleted_at');
                },
                'productImage' => function ($productImage) {
                    $productImage->whereNull('product_images.deleted_at')
                        ->where('product_images.product_image_name', '<>', '0');
                },
            ])
            ->groupBy('products.id')
            ->orderByRaw($order)
            ->limit(LIMIT)
            ->get();

        return $products;
    }

    public static function getProductBySearch($params = null, $order = 'products.id')
    {
        $products = self::whereNull('products.deleted_at')
            ->whereNull('product_types.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
//            ->where('products.product_option', $option)
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftjoin('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->leftjoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
//            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->selectRaw("products.*")
            ->selectRaw(
                DB::raw("(CASE WHEN (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) IS NOT NULL THEN
                (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) ELSE products.product_quantity END) AS exist")
            )
            ->selectRaw(
                DB::raw("(CASE WHEN ((SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status = 2 GROUP BY order_details.product_id)) IS NOT NULL THEN
                ((SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status = 2 GROUP BY order_details.product_id)) ELSE 0 END) AS count_buy")
            )
            ->selectRaw('(SELECT count(ratings.user_id) FROM ratings WHERE ratings.product_id = products.id GROUP BY ratings.product_id) AS count_rating')
            ->selectRaw('(SELECT FORMAT(AVG(ratings.point), 1) FROM ratings WHERE ratings.product_id = products.id GROUP BY ratings.product_id) AS average_rating')
            ->with([
                'category' => function ($category) {
                    $category->whereNull('categories.deleted_at');
                },
                'productCategory' => function ($productCategory) {
                    $productCategory->whereNull('product_categories.deleted_at');
                },
                'productType' => function ($productType) {
                    $productType->whereNull('product_types.deleted_at');
                },
                'productImage' => function ($productImage) {
                    $productImage->whereNull('product_images.deleted_at')
                        ->where('product_images.product_image_name', '<>', '0');
                },
            ])
            ->groupBy('products.id')
            ->orderByRaw($order);

        $products = self::getQueryBySearchParams($products, $params, null);

        return $products->paginate(LIMIT);
    }

//    public static function getListAllProduct()
//    {
//        return self::select(
//            'category_id', 'product_category_id', 'product_id',
//            'product_name', 'product_image',
//            'product_description', 'product_content', 'product_price',
//            'product_promotion', 'count_buy',
//            'product_view', 'product_status')
//            ->orderBy('id', 'DESC')->get();
//    }

    public static function getCommentOfUser($params = null)
    {
        $products = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "products.id DESC ";
        }

        $products = $products->whereNull('products.deleted_at')
//            ->whereNull('product_types.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
//            ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
//            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->selectRaw("products.*")
            ->with([
                'comment' => function ($comment) {
                    $comment->where('comments.comment_status', true);
                    $comment->with([
                        'users' => function ($users) {
                            $users->where('users.status', true);
                        }
                    ]);
                },
            ])
            ->groupBy('products.id')
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $products;
    }

    public static function updateProductView($productId)
    {
        $product = self::showProduct($productId);

        return $product->update([
            'count_view' => $product->count_view++,
        ]);
    }

    public static function getListProduct()
    {
        return self::select(
            'category_id', 'product_category_id', 'product_id',
            'product_name', 'product_image',
            'product_description', 'product_content', 'product_price',
            'product_promotion',
            'count_view', 'product_status')
            ->orderBy('id', 'DESC')->paginate(2);
    }

    public static function createProduct($request)
    {
//        $productImages = Session::get(SESSION_PRODUCT_IMAGE) ?? [];
//        foreach ($productImages as $productImage) {
//            $request['product_image'] = $productImage['name'];
//        }
        $request['product_slug'] = utf8ToUrl($request['product_name']);
        $request['product_description_slug'] = convertStringToUrl($request['product_description']);

        if ($request['submit']) {
            return self::create($request);
        }
    }

    public static function showProduct($id_product)
    {
        return self::whereNull('products.deleted_at')
//            ->whereNull('product_types.deleted_at')
            ->whereNull('product_categories.deleted_at')
            ->whereNull('categories.deleted_at')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftjoin('product_types', 'product_types.id', '=', 'products.product_type_id')
//            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->selectRaw("products.*")
            ->with([
                'category' => function ($category) {
                    $category->whereNull('categories.deleted_at');
                },
                'productCategory' => function ($productCategory) {
                    $productCategory->whereNull('product_categories.deleted_at');
                },
                'productType' => function ($productType) {
                    $productType->whereNull('product_types.deleted_at');
                },
                'productImage' => function ($productImage) {
                    $productImage->whereNull('product_images.deleted_at');
                },
            ])
            ->groupBy('products.id')
            ->where('products.id', $id_product)
            ->first();
    }

    public static function updateProduct($request, $product_id)
    {
        $product = self::showProduct($product_id);
        $request['product_slug'] = utf8ToUrl($request['product_name']);
        $request['product_description_slug'] = convertStringToUrl($request['product_description']);
//
//        if ($request['submit']) {
//            return self::create($request);
//        }
//        if (isset($request['product_image']) && $request['product_image']) {
//            UploadService::deleteFile(FILE_PATH_PRODUCT, $product->product_image);
//        }
//        $productImage = (isset($request['product_image']) && $request['product_image']) ? UploadService::moveImage(FILE_PATH_PRODUCT, $request['product_image'], PREFIX_PRODUCT) : $product->product_image;
//        $request['product_image'] = $productImage;
//        $request['product_slug'] = utf8ToUrl($request['product_name']);

        if ($request['submit']) {
            return $product->update($request);
        }
    }

    public static function deleteImageListProduct($file_path, $product_id)
    {
        $product = self::showProduct($product_id);
        $product_image = $product->productImage->toArray();
        foreach ($product_image as $value) {
            File::delete($file_path.$value['product_image']);
        }
        return 1;
    }

    public static function deleteProduct($product_id)
    {
        $product = self::showProduct($product_id);

        return $product->delete();
    }

    public static function searchProduct($keyWord, $length)
    {
        if ($keyWord == '') {
            $product = self::orderBy('id', 'DESC')
                ->offset(0)->limit(2)
                ->get();
        } else {
            $product = self::where('product_name', 'like', '%' . $keyWord . '%')
                ->orWhere('product_slug', 'like', '%' . $keyWord . '%')
                ->orWhere('id', $keyWord)->get();
        }

        if ($length != '') {
            $product = self::orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $product;
    }

    public static function loadProductOfIdProductType($product_type_id)
    {
        $product = self::select(
            'category_id', 'product_category_id', 'product_type_id',
            'product_name', 'product_image',
            'product_description', 'product_content', 'product_price',
            'product_promotion',
            'count_view', 'product_status')
            ->orderby('id', 'DESC')->where('product_type_id', $product_type_id)->get();
        return $product;
    }

    public static function getQuantityProductById($productId)
    {
        return self::whereNull('products.deleted_at')
            ->where('products.id', $productId)
            ->leftjoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->selectRaw(
                DB::raw("(CASE WHEN (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) IS NOT NULL THEN
                (products.product_quantity - (SELECT SUM(order_details.quantity) FROM orders INNER JOIN order_details ON orders.id = order_details.order_id WHERE order_details.product_id = products.id AND orders.order_status < 3 GROUP BY order_details.product_id)) ELSE products.product_quantity END) as exist")
            )
            ->pluck('exist')
            ->first();
    }

    public static function updateStatusNotExists($productId)
    {
        $product = self::showProduct($productId);

        return $product->update([
            'product_is_free_ship' => 0
        ]);
    }
}
