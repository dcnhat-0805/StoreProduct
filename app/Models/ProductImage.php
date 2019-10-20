<?php

namespace App\Models;

use App\Services\UploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;

    protected $table = 'product_images';

    protected $fillable = [
        'product_image_name',
        'product_id',
        'product_image_order',
        'product_image_status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public static function getListAllProductImage()
    {
        return self::select(
                'product_image_name',
                'product_id',
                'product_image_order',
                'product_image_status'
            )
            ->join('products', 'products.id', '=', 'product_images.product_id')
            ->orderBy('product_images.id', 'DESC')
            ->whereNull('product_images.deleted_at')
            ->get();
    }

    public static function getListProductImage()
    {
        return self::select(
            'product_image_name',
            'product_id',
            'product_image_order',
            'product_image_status'
            )
            ->orderBy('id', 'DESC')->paginate(2);
    }

    public static function createProductImage($request, $productId)
    {
        $image_array = $request['image_list'] ?? [];
        $image_thump = self::getDataImageByProductId($productId);

        if (isset($image_array) && count($image_array)) {
            foreach ($image_array as $image) {
                if (!in_array($image, $image_thump)) {
                    $productImages = self::firstOrNew([
                        'product_id' => $productId,
                        'product_image_name' => $image,
                        'product_image_order' => count(self::getListAllProductImage()),
                    ]);

                    $productImages->save();
                }

            }
        }
    }

    public static function showProductImage($product_image_id)
    {
        return self::find($product_image_id);
    }

    public static function updateProductImage($request, $product_image_id)
    {
        $productImage = self::showProductImage($product_image_id);
        return $productImage->update($request);
    }

    public static function deleteProductImage($product_image_id)
    {
        $product_image = self::showProductImage($product_image_id);
        $image_path = 'assets/uploads/image/product/detail/';
        if (isset($product_image)) {
            if (File::exists($image_path.$product_image->product_image_name)) {
                unlink($image_path.$product_image->imageproduct_image_name_Product_Image);
            }
            return $product_image->delete();
        }

    }

    public static function deleteProductImageByProductId($productId)
    {
        return self::where('product_id', $productId)
                    ->delete();
    }

    public static function deleteProductImageByArrayProductId($arrayProductId)
    {
        return self::whereIn('product_id', $arrayProductId)
                    ->delete();
    }

    public static function deleteProductImageByName($fileName)
    {
        $productImage =  self::where('product_image_name', $fileName)
                                ->first();

        if ($productImage !== null && count($productImage) !== 0) {
//            UploadService::deleteFile(FILE_PATH_PRODUCT_IMAGE, $fileName);
            return $productImage->delete();
        }
    }

    public static function getDataImageByProductId($productId)
    {
        $productImage =  self::select(
            'product_image_name'
        )
            ->join('products', 'products.id', '=', 'product_images.product_id')
            ->orderBy('product_images.id', 'DESC')
            ->whereNull('product_images.deleted_at')
            ->where('product_id', $productId)
            ->pluck('product_image_name')
            ->toArray();

        return $productImage;
    }
}
