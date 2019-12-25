<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProductAttribute extends Model
{
//    use SoftDeletes;

    protected $table = 'product_attributes';

    protected $fillable = [
        'product_id',
        'attribute_code',
        'attribute_name',
        'attribute_item_name',
        'is_filterable',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
//        'deleted_at'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public static function createProductAttribute($requests, $product_id)
    {
        $attributesThump = self::getProductAttributeByProductId($product_id);
        if (count($attributesThump)) {
            self::deleteProductAttributeByProductId($product_id);
        }

        foreach ($requests['attributes'] as $key => $request) {
            $attributes = self::firstOrNew([
                'product_id' => $product_id,
                'attribute_code' => isset($request['attribute_code']) && $request['attribute_code'] ? $request['attribute_code'] : 'SOP-'. uniqid() . '-' . time(),
                'attribute_name' => $request['attribute_name'],
                'attribute_item_name' => $request['attribute_item_name'],
                'is_filterable' => isset($request['is_filterable']) ? $request['is_filterable'] : 0,
            ]);

            $attributes->touch();
        }
    }

    public static function getProductAttributeByProductId($productId)
    {
        $attributes = self::where('product_id', $productId)
//                        ->whereNull('product_attributes.deleted_at')
                        ->select('product_attributes.attribute_code',
                         'product_attributes.attribute_name',
                         'product_attributes.attribute_item_name',
                         'product_attributes.is_filterable')
                        ->join('products', 'products.id', '=', 'product_attributes.product_id')
                        ->orderBy('product_attributes.id')
                        ->get();

        return $attributes;
    }

    public static function deleteProductAttributeByProductId($productId)
    {
        return self::where('product_id', $productId)
            ->delete();
    }

    public static function deleteProductAttributeByArrayProductId($arrayProductId)
    {
        return self::whereIn('product_id', $arrayProductId)
            ->delete();
    }

    public static function getAttributeItemName($arrayProductId, $attributeName)
    {
        $attributes = self::whereIn('product_id', $arrayProductId)
            ->where('attribute_name', $attributeName)
            ->where('is_filterable', true)
            ->select('attribute_item_name', DB::raw('count(product_id) as total'))
            ->groupBy('attribute_item_name')
            ->pluck('attribute_item_name');

        return $attributes;
    }
}
