<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
                ->where('orders.order_status', '<>', CANCEL)
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
                    ->orWhere('users.email', 'like', "%$keyword%")
                    ->orWhere('orders.order_name', 'like', "%$keyword%")
                    ->orWhere('orders.order_email', 'like', "%$keyword%")
                    ->orWhere('orders.order_phone', 'like', "%$keyword%")
                    ->orWhere('orders.order_monney', 'like', "%$keyword%");
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

        if (isset($params['status'])) {
            $status = $params['status'];

            $orders = $orders->where(function ($query) use ($status) {
                if (in_array(PENDING, $status)) {
                    $query->orWhereRaw("(orders.order_status = 0)");
                }
                if (in_array(DELIVERY, $status)) {
                    $query->orWhereRaw("(orders.order_status = 1)");
                }
                if (in_array(FINISH, $status)) {
                    $query->orWhereRaw("(orders.order_status = 2)");
                }
                if (in_array(CANCEL, $status)) {
                    $query->orWhereRaw("(orders.order_status = 3)");
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
            ->selectRaw("orders.*, order_details.order_id, users.name as user_name, users.email as user_email,  users.phone")
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

    public static function getCountMoneyBetWeenFromTo($from, $to, $status)
    {
        $amounts = self::whereNull('orders.deleted_at')
                ->where('orders.created_at', '>=', $from)
                ->where('orders.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
                ->where('orders.order_status', '=', $status)
                ->select(
                    DB::raw("SUM(orders.order_monney) as countMoney"),
                    DB::raw("DATE_FORMAT(orders.created_at, '%Y/%m/%d') as date")
                )
                ->groupby('date')
                ->orderBy('date')
//                ->pluck("countMoney")
                ->get();

        $total = 0;
        foreach ($amounts as $amount) {
            $total += $amount['countMoney'];
        }

        return $total;
    }

    public static function getCountMoneyBetWeenFromToMonth($from, $to, $status)
    {
        $amounts = self::whereNull('orders.deleted_at')
                ->where('orders.created_at', '>=', $from)
                ->where('orders.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
                ->where('orders.order_status', '=', $status)
                ->select(
                    DB::raw("SUM(orders.order_monney) as countMoney"),
                    DB::raw("DATE_FORMAT(orders.created_at, '%Y/%m') as month")
                )
                ->groupby('month')
                ->orderBy('month')
//                ->pluck("countMoney")
                ->get();

        $total = 0;
        foreach ($amounts as $amount) {
            $total += $amount['countMoney'];
        }

        return $total;
    }

    public static function getCountMoney()
    {
        $amount = self::whereNull('orders.deleted_at')
                ->selectRaw("orders.order_monney")
                ->sum("orders.order_monney");

        return $amount;
    }

    public static function getAnalyticsOrderBetweenFromTo($from, $to, $status)
    {
        $orders = self::where('orders.order_status', $status)
            ->where('orders.created_at', '>=', $from)
            ->where('orders.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
            ->select(
                DB::raw("SUM(orders.order_monney) as countMoney"),
                DB::raw("DATE_FORMAT(orders.created_at, '%Y/%m/%d') as date")
            )
            ->groupby('date')
            ->orderBy('date')
            ->pluck('countMoney', 'date');
//            ->get()
//            ->toArray();

        $arrayDate = Helper::getArrayDateBetweenFromTo($from, $to);
        $analyticsOrder = [];
        foreach ($arrayDate as $date) {
            $item = 0 . ',';
            foreach ($orders as $key => $value) {
                if ($key == $date) {
                    $item = number_format($value, 0, ',', '') . ',';
                }
            }

            array_push($analyticsOrder, $item);
        }

        return $analyticsOrder;
    }

    public static function getAnalyticsOrderBetweenFromToMonth($from, $to, $status)
    {
        $orders = self::where('orders.order_status', $status)
            ->where('orders.created_at', '>=', $from)
            ->where('orders.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
            ->select(
                DB::raw("SUM(orders.order_monney) as countMoney"),
                DB::raw("DATE_FORMAT(orders.created_at, '%Y/%m') as month")
            )
            ->groupby('month')
            ->orderBy('month')
            ->pluck('countMoney', 'month');
//            ->get()
//            ->toArray();

        $arrayDate = Helper::getArrayDateBetweenFromToMonth($from, $to);
        $analyticsOrder = [];

        foreach ($arrayDate as $date) {
            $item = 0 . ',';
            foreach ($orders as $key => $value) {
                if ($key == $date) {
                    $item = number_format($value, 0, ',', '') . ',';
                }
            }

            array_push($analyticsOrder, $item);
        }

        return $analyticsOrder;
    }

    public static function getCountOrder()
    {
        $orders = self::whereNull('orders.deleted_at')
            ->select(
                DB::raw("count(orders.order_monney) as countOrder"),
                DB::raw("DATE_FORMAT(orders.created_at, '%Y/%m/%d') as date")
            )
            ->groupby('date')
            ->orderBy('date')
            ->get();

        $total = 0;
        foreach ($orders as $order) {
            $total += $order['countOrder'];
        }

        return $total;
    }

    public static function getCountOrderFromTo($from, $to, $status)
    {
        $orders = self::whereNull('orders.deleted_at')
            ->where('orders.order_status', $status)
            ->where('orders.created_at', '>=', $from)
            ->where('orders.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
            ->select(
                DB::raw("SUM(orders.order_monney) as countMoney"),
                DB::raw("DATE_FORMAT(orders.created_at, '%Y/%m/%d') as date")
            )
            ->groupby('date')
            ->orderBy('date')
            ->pluck('countMoney', 'date');

        return count($orders);
    }

    public static function getCountOrderFromToMonth($from, $to, $status)
    {
        $orders = self::whereNull('orders.deleted_at')
            ->where('orders.order_status', $status)
            ->where('orders.created_at', '>=', $from)
            ->where('orders.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
            ->select(
                DB::raw("SUM(orders.order_monney) as countMoney"),
                DB::raw("DATE_FORMAT(orders.created_at, '%Y/%m') as month")
            )
            ->groupby('month')
            ->orderBy('month')
            ->pluck('countMoney', 'month');

        return count($orders);
    }

    public static function getPercentageByStatusFromTo($from, $to, $status)
    {
        $countOrder = self::getCountOrder();
        $countOrderByStatus = self::getCountOrderFromTo($from, $to, $status);

        return ($countOrderByStatus * 100) / $countOrder;
    }

    public static function getPercentageByStatusFromToMonth($from, $to, $status)
    {
        $countOrder = self::getCountOrder();
        $countOrderByStatus = self::getCountOrderFromToMonth($from, $to, $status);

        return ($countOrderByStatus * 100) / $countOrder;
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

    public static function cancelOrder($code)
    {
        $order = self::getListOrderByOrderCode($code);

        if ($order->order_status == PENDING) {
            return $order->update([
                'order_status' => CANCEL,
            ]);
        }

        return;
    }
}
