<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'user_id', 'product_id', 'comment_contents', 'comment_status',
    ];

    protected $guarded = [
        'count_like',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public static function getCommentByProductIdAndUserId($userId, $productId)
    {
        $comments = self::where('comments.user_id', $userId)
            ->where('comments.product_id', $productId)
            ->whereNull('users.deleted_at')
            ->whereNull('products.deleted_at')
            ->join('users', 'users.id', 'comments.user_id')
            ->join('products', 'products.id', 'comments.product_id')
            ->select('comments.*', 'users.id as userId', 'users.name', 'users.phone')
            ->selectRaw('users.id as userId')
            ->whereIn('users.id', function ($query) {
                $query->from('users')
                    ->selectRaw('users.id')
                    ->whereNull('users.deleted_at')
                    ->where('users.status', true)
                    ->groupBy('users.id');
            })
            ->orderBy('comments.created_at')
            ->groupBy('comments.id', 'users.id')
            ->paginate(LIMIT);

        return $comments;
    }
}
