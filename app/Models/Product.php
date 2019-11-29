<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id', 'product_category_id', 'product_type_id',
        'product_name', 'product_slug', 'product_image',
        'product_description','product_description_slug', 'product_content', 'product_price',
        'product_meta_title', 'product_meta_description', 'product_weight',
        'product_is_shipping', 'product_option',
        'product_promotion', 'product_status',
    ];

    public $guarded = [
        'count_buy',
        'product_view',
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
    private static function filter($params)
    {
        $products = new Product();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            if ($keyword != 0 || $keyword != null) {
                $products = $products->where('product_name', 'like', "%$keyword%")
                    ->orWhere('product_slug', 'like', "%$keyword%");
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

        return $products;
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
//            ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
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
                    $productImage->whereNull('product_images.deleted_at')
                                ->where('product_images.product_image_name', '<>', '0');
                },
            ])
            ->groupBy('products.id')
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $products;
    }

    public static function getListProductOnFrontEnd($slug, $params = null)
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
            ->where('categories.category_slug', $slug)
            ->orWhere('product_categories.product_category_slug', $slug)
            ->orWhere('product_types.product_type_slug', $slug)
            ->orWhere('products.product_slug', $slug)
            ->groupBy('products.id')
            ->orderByRaw($order)
            ->paginate(FRONT_LIMIT);

        return $products;
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

    public static function updateCountBuy($productId)
    {
        $product = self::showProduct($productId);

        return $product->update([
            'count_buy' => $product->count_buy++,
        ]);
    }

    public static function updateProductView($productId)
    {
        $product = self::showProduct($productId);

        return $product->update([
            'product_view' => $product->product_view++,
        ]);
    }

    public static function getListProduct()
    {
        return self::select(
            'category_id', 'product_category_id', 'product_id',
            'product_name', 'product_image',
            'product_description', 'product_content', 'product_price',
            'product_promotion', 'count_buy',
            'product_view', 'product_status')
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
            'product_promotion', 'count_buy',
            'product_view', 'product_status')
            ->orderby('id', 'DESC')->where('product_type_id', $product_type_id)->get();
        return $product;
    }
}
