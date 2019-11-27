<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_code', 'transaction_id', 'user_id', 'order_name', 'order_address', 'order_email', 'order_phone', 'order_monney', 'order_message', 'order_status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class,'order_id','id');
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

    public static function getListOrderByOrderCode($orderCode)
    {
        $order = self::where('orders.order_code', '=', $orderCode)
                ->whereNull('orders.deleted_at')
            ->whereNull('order_details.deleted_at')
                ->select(
                    'orders.id',
                    'orders.order_code',
                    'orders.transaction_id',
                    'orders.user_id',
                    'orders.order_name',
                    'orders.order_address',
                    'orders.order_email',
                    'orders.order_phone',
                    'orders.order_monney',
                    'orders.order_message',
                    'orders.order_status',
                    'orders.created_at'
                )
                ->join('order_details', 'order_details.order_id', 'orders.id')
                ->with([
                    'orderDetail' => function ($orderDetail) {
                        $orderDetail->whereNull('order_details.deleted_at');
                    },
                ])
                ->orderBy('orders.created_at')
                ->first();

        return $order;
    }

    public static function getListOrderById($id)
    {
        $order = self::where('orders.id', '=', $id)
                ->whereNull('orders.deleted_at')
                ->whereNull('order_details.deleted_at')
                ->select(
                    'orders.id',
                    'orders.order_code',
                    'orders.transaction_id',
                    'orders.user_id',
                    'orders.order_name',
                    'orders.order_address',
                    'orders.order_email',
                    'orders.order_phone',
                    'orders.order_monney',
                    'orders.order_message',
                    'orders.order_status',
                    'orders.created_at'
                )
                ->join('order_details', 'order_details.order_id', 'orders.id')
                ->with([
                    'orderDetail' => function ($orderDetail) {
                        $orderDetail->whereNull('order_details.deleted_at');
                    },
                ])
                ->orderBy('orders.created_at')
                ->first();

        return $order;
    }

    public static function getListOrderByUserId($userId)
    {
        $orders = self::where('orders.user_id', '=', $userId)
                ->whereNull('orders.deleted_at')
                ->where('users.status', STATUS_ENABLE)
                ->select(
                    'orders.id',
                    'orders.order_code',
                    'orders.transaction_id',
                    'orders.user_id',
                    'orders.order_name',
                    'orders.order_address',
                    'orders.order_email',
                    'orders.order_phone',
                    'orders.order_monney',
                    'orders.order_message',
                    'orders.order_status',
                    'orders.created_at'
                )
                ->join('order_details', 'order_details.order_id', 'orders.id')
                ->join('users', 'orders.user_id', 'users.id')
                ->with([
                    'orderDetail' => function ($orderDetail) {
                        $orderDetail->whereNull('order_details.deleted_at');
                    },
                ])
                ->orderBy('orders.created_at')
                ->get();

        return $orders;
    }

    private static function filter($params)
    {
        $orders = new Order();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            if ($keyword != 0 || $keyword != null) {
                $orders = $orders->where('users.name', 'like', "%$keyword%")
                    ->orWhere('users.email', 'like', "%$keyword%");
            }
        }

        if (isset($params['created_at'])) {
            $publishDate = $params['created_at'];
            if ($publishDate != 0) {
                $publishDate = str_replace('+', ' ', $publishDate);
                $publishDate = explode(' - ', $publishDate);
                $orders = $orders->whereRaw("orders.created_at BETWEEN ? AND ?", [$publishDate[0], date('Y/m/d', strtotime("+1 day", strtotime($publishDate[1])))]);
            }
        }

        if (isset($params['category_id'])) {
            $category_id = $params['category_id'];
            if ($category_id != 0) {
                $orders = $orders->whereIn('categories.id', explode(',', $category_id));
            }
        }

        if (isset($params['product_category_id'])) {
            $product_category_id = $params['product_category_id'];
            if ($product_category_id != 0) {
                $orders = $orders->whereIn('product_categories.id', explode(',', $product_category_id));
            }
        }

        if (isset($params['product_type_id'])) {
            $product_type_id = $params['product_type_id'];
            if ($product_type_id != 0) {
                $orders = $orders->whereIn('product_types.id', explode(',', $product_type_id));
            }
        }


        if (isset($params['status'])) {
            $status = $params['status'];

            $orders = $orders->where(function ($query) use ($status) {
                if (in_array(0, $status)) {
                    $query->orWhereRaw("(orders.order_status = 0)");
                }
                if (in_array(1, $status)) {
                    $query->orWhereRaw("(orders.order_status = 1)");
                }
            });
        }

        return $orders;
    }

    public static function getListAllOrder($params = null)
    {
        $orders = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "orders.id DESC ";
        }

        $orders = $orders->whereNull('orders.deleted_at')
            ->whereNull('users.deleted_at')
            ->whereNull('order_details.deleted_at')
            ->join('order_details', 'order_details.order_id', 'orders.id')
            ->join('users', 'orders.user_id', 'users.id')
            ->selectRaw("orders.*, order_details.order_id, users.name, users.email,  users.phone")
            ->with([
                'users' => function ($users) {
                    $users->whereNull('users.deleted_at')
                        ->where('users.status', true);
                },
                'orderDetail' => function ($orderDetail) {
                    $orderDetail->whereNull('order_details.deleted_at');
                },
            ])
            ->groupBy('orders.id')
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $orders;
    }

    public static function deliveryOrder($id)
    {
        $order = self::getListOrderById($id);

        if ($order->order_status == PENDING) {
            return $order->update([
                'order_status' => DELIVERY,
            ]);
        }

        return;
    }
}
