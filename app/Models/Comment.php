<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'user_id', 'product_id', 'comment_contents', 'comment_status', 'type'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function repComment() {
        return $this->hasMany(ReplyComment::class, 'comment_id', 'id');
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

    private static function filter($params)
    {
        $comment = new Comment();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            if ($keyword != 0 || $keyword != null) {
                $comment = $comment->where('users.name', 'like', "%$keyword%")
                    ->orWhere('users.email', 'like', "%$keyword%")
                    ->orWhere('users.phone', 'like', "%$keyword%")
                    ->orWhere('products.product_name', 'like', "%$keyword%");
            }
        }

        if (isset($params['created_at'])) {
            $publishDate = $params['created_at'];
            if ($publishDate != 0) {
                $publishDate = str_replace('+', ' ', $publishDate);
                $publishDate = explode(' - ', $publishDate);
                $comment = $comment->whereRaw("comments.created_at BETWEEN ? AND ?", [$publishDate[0], date('Y/m/d', strtotime("+1 day", strtotime($publishDate[1])))]);
            }
        }

        if (isset($params['status'])) {
            $status = $params['status'];

            $comment = $comment->where(function ($query) use ($status) {
                if (in_array(0, $status)) {
                    $query->orWhereRaw("(comments.comment_status = 0)");
                }
                if (in_array(1, $status)) {
                    $query->orWhereRaw("(comments.comment_status = 1)");
                }
            });
        }

        return $comment;
    }

    public static function getListAllComment($params = null)
    {
        $comments = self::filter($params);

        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "comments.id DESC ";
        }

        $comments = $comments->whereNull('comments.deleted_at')
            ->whereNull('users.deleted_at')
            ->whereNull('products.deleted_at')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('products', 'products.id', '=', 'comments.product_id')
            ->select(
                'comments.id as commentId',
                'comments.user_id',
                'comments.product_id',
                'comments.comment_contents',
                'comments.comment_status',
                'comments.created_at',
                'users.id as userId',
                'users.name',
                'users.email',
                'users.phone',
                'products.id as productId'
            )
            ->with([
                'users' => function ($users) {
                    $users->whereNull('users.deleted_at')
                        ->where('users.status', true);
                },
                'product' => function ($product) {
                    $product->whereNull('products.deleted_at');
                },
            ])
            ->groupBy('comments.id')
            ->groupBy('users.id')
            ->groupBy('products.id')
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $comments;
    }

    public static function getCommentByUserIdAndProductId($userId, $productId, $params = null)
    {
        $comments = self::filter($params);
        $comments = self::whereNull('comments.deleted_at')
            ->whereNull('users.deleted_at')
            ->whereNull('products.deleted_at')
            ->where('comments.user_id', $userId)
            ->where('comments.product_id', $productId)
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('products', 'products.id', '=', 'comments.product_id')
            ->select(
                'comments.id as commentId',
                'comments.user_id',
                'comments.product_id',
                'comments.comment_contents',
                'comments.comment_status',
                'comments.created_at',
                'users.id as userId',
                'users.name',
                'users.email',
                'users.phone',
                'products.id as productId'
            )
            ->with([
                'users' => function ($users) {
                    $users->whereNull('users.deleted_at')
                        ->where('users.status', true);
                },
                'product' => function ($product) {
                    $product->whereNull('products.deleted_at');
                },
            ])
            ->get();

        return $comments;
    }

    public static function getDistinct($params = null)
    {
        $comments = self::filter($params);

        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "comments.product_id DESC ";
        }

        $comments = $comments->selectRaw("DISTINCT(comments.product_id), comments.user_id")
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->join('products', 'products.id', '=', 'comments.product_id')
                ->distinct()
                ->orderByRaw($order)
                ->paginate(LIMIT);

        return $comments;
    }


}
