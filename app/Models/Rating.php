<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = ['user_id', 'product_id', 'point', ];

    public static function getRatingByUserIdAndProductId($userId, $productId)
    {
        $rating = self::where('ratings.user_id', $userId)
                ->where('ratings.product_id', $productId)
                ->select('ratings.user_id', 'ratings.product_id', 'ratings.point')
                ->join('users', 'users.id', 'ratings.user_id')
                ->join('products', 'products.id', 'ratings.product_id')
                ->pluck('ratings.point');

        return $rating;
    }

    public static function getAvgRatingByProductId($productId)
    {
        $rating = self::where('ratings.product_id', $productId)
                ->select('ratings.user_id', 'ratings.product_id', 'ratings.point')
                ->join('products', 'products.id', 'ratings.product_id')
                ->avg('ratings.point');

        return $rating;
    }

    public static function getCountRating($productId) {
        $rating = self::where('ratings.product_id', $productId)
            ->select('ratings.user_id', 'ratings.product_id', 'ratings.point')
            ->join('products', 'products.id', 'ratings.product_id')
            ->count();

        return $rating;
    }

    public static function getCountRatingByPoint($productId, $point) {
        $rating = self::where('ratings.product_id', $productId)
            ->where('ratings.point', $point)
            ->select('ratings.user_id', 'ratings.product_id', 'ratings.point')
            ->join('products', 'products.id', 'ratings.product_id')
            ->count();

        return $rating;
    }
}
