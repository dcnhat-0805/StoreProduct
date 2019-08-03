<?php

namespace App\Models;

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

    public function getListAllProductImage()
    {
        return $this->select(
                'product_image_name',
                'product_id',
                'product_image_order',
                'product_image_status'
            )
            ->orderBy('id', 'DESC')->get();
    }

    public function getListProductImage()
    {
        return $this->select(
            'product_image_name',
            'product_id',
            'product_image_order',
            'product_image_status'
            )
            ->orderBy('id', 'DESC')->paginate(2);
    }

    public function createProductImage($request)
    {
        return $this->create($request);
    }

    public function showProductImage($product_image_id)
    {
        return $this->find($product_image_id);
    }

    public function updateProductImage($request, $product_image_id)
    {
        $productImage = $this->showProductImage($product_image_id);
        return $productImage->update($request);
    }

    public function deleteProductImage($product_image_id)
    {
        $product_image = $this->showProductImage($product_image_id);
        $image_path = 'assets/upload/image/product/detail/';
        if (isset($product_image)) {
            if (File::exists($image_path.$product_image->product_image_name)) {
                unlink($image_path.$product_image->imageproduct_image_name_Product_Image);
            }
            return $product_image->delete();
        }

    }
}
