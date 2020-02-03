<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Helper;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function daily()
    {
        $from = date("Y/m/d", strtotime('-6 days'));
        $to = date("Y/m/d");
        $dateRange = \request()->get('date_range', ' - ');
        $dates = explode(" - ", $dateRange);
        if (strtotime($dates[0])) {
            $from = $dates[0];
        }
        if (strtotime($dates[1])) {
            $to = $dates[1];
        }

        $countUserBetweenFromTo = User::getCountUSerBetweenFromTo($from, $to);
        $countUser = User::getCountUSer();
        $percentageUser = ($countUserBetweenFromTo * 100) / $countUser;

        $countMoney = Order::getCountMoney();

        $countDeliveryFromTo = Order::getCountMoneyBetWeenFromTo($from, $to, DELIVERY);
        $percentageDelivery = Order::getPercentageByStatusFromTo($from, $to, DELIVERY);

        $countMoneyBetweenFromTo = Order::getCountMoneyBetWeenFromTo($from, $to, FINISH);
        $percentageMoney = Order::getPercentageByStatusFromTo($from, $to, FINISH);

        $countReimbursementFromTo = Order::getCountMoneyBetWeenFromTo($from, $to, CANCEL);
        $percentageReimbursement = Order::getPercentageByStatusFromTo($from, $to, CANCEL);

        $countOrder = Order::getCountOrder();
        $countOrderDelivery = Order::getCountOrderFromTo($from, $to, DELIVERY);
        $countOrderFinish = Order::getCountOrderFromTo($from, $to, FINISH);
        $countOrderCancel = Order::getCountOrderFromTo($from, $to, CANCEL);

        $analyticsUser = User::getAnalyticsUSerBetweenFromTo($from, $to);
        $analyticsUser = substr(implode($analyticsUser), 0, -1);

        $analyticsOrderDelivery = Order::getAnalyticsOrderBetweenFromTo($from, $to, DELIVERY);
        $analyticsOrderDelivery = substr(implode($analyticsOrderDelivery), 0, -1);

        $analyticsOrderFinish = Order::getAnalyticsOrderBetweenFromTo($from, $to, FINISH);
        $analyticsOrderFinish = substr(implode($analyticsOrderFinish), 0, -1);

        $analyticsOrderCancel = Order::getAnalyticsOrderBetweenFromTo($from, $to, CANCEL);
        $analyticsOrderCancel = substr(implode($analyticsOrderCancel), 0, -1);

        $arrayStringDate = Helper::getArrayStringDateBetweenFromTo($from, $to);
        $arrayStringDate = substr(implode($arrayStringDate), 0, -1);

        return view('backend.pages.index', compact(
            'countUserBetweenFromTo', 'countUser', 'percentageUser',
            'countMoneyBetweenFromTo', 'countMoney', 'percentageMoney',
            'countReimbursement', 'countReimbursementFromTo', 'percentageReimbursement',
            'countOrder', 'countOrderFinish', 'countOrderCancel',
            'arrayStringDate', 'analyticsUser', 'analyticsOrderFinish', 'analyticsOrderCancel',
            'from', 'to', 'countDeliveryFromTo', 'percentageDelivery', 'countOrderDelivery', 'analyticsOrderDelivery'
        ));
    }

    public function monthly()
    {
        $from = date("Y/m/d", strtotime('-6 days'));
        $to = date("Y/m/d");
        $dateRange = \request()->get('date_range', ' - ');
        $dates = explode(" - ", $dateRange);
        if (strtotime($dates[0])) {
            $from = $dates[0];
        }
        if (strtotime($dates[1])) {
            $to = $dates[1];
        }

        $countUserBetweenFromTo = User::getCountUSerBetweenFromToMonth($from, $to);
        $countUser = User::getCountUSer();
        $percentageUser = ($countUserBetweenFromTo * 100) / $countUser;

        $countMoney = Order::getCountMoney();

        $countDeliveryFromTo = Order::getCountMoneyBetWeenFromToMonth($from, $to, DELIVERY);
        $percentageDelivery = Order::getPercentageByStatusFromToMonth($from, $to, DELIVERY);

        $countMoneyBetweenFromTo = Order::getCountMoneyBetWeenFromToMonth($from, $to, FINISH);
        $percentageMoney = Order::getPercentageByStatusFromToMonth($from, $to, FINISH);

        $countReimbursementFromTo = Order::getCountMoneyBetWeenFromToMonth($from, $to, CANCEL);
        $percentageReimbursement = Order::getPercentageByStatusFromToMonth($from, $to, CANCEL);

        $countOrder = Order::getCountOrder();
        $countOrderDelivery = Order::getCountOrderFromToMonth($from, $to, DELIVERY);
        $countOrderFinish = Order::getCountOrderFromToMonth($from, $to, FINISH);
        $countOrderCancel = Order::getCountOrderFromToMonth($from, $to, CANCEL);

        $analyticsUser = User::getAnalyticsUSerBetweenFromToMonth($from, $to);
        $analyticsUser = substr(implode($analyticsUser), 0, -1);

        $analyticsOrderDelivery = Order::getAnalyticsOrderBetweenFromToMonth($from, $to, DELIVERY);
        $analyticsOrderDelivery = substr(implode($analyticsOrderDelivery), 0, -1);

        $analyticsOrderFinish = Order::getAnalyticsOrderBetweenFromToMonth($from, $to, FINISH);
        $analyticsOrderFinish = substr(implode($analyticsOrderFinish), 0, -1);

        $analyticsOrderCancel = Order::getAnalyticsOrderBetweenFromToMonth($from, $to, CANCEL);
        $analyticsOrderCancel = substr(implode($analyticsOrderCancel), 0, -1);

        $arrayStringDate = Helper::getArrayStringDateBetweenFromToMonth($from, $to);
        $arrayStringDate = substr(implode($arrayStringDate), 0, -1);

        return view('backend.pages.index', compact(
            'countUserBetweenFromTo', 'countUser', 'percentageUser',
            'countMoneyBetweenFromTo', 'countMoney', 'percentageMoney'
            , 'countReimbursementFromTo', 'percentageReimbursement',
            'countOrder', 'countOrderFinish', 'countOrderCancel',
            'arrayStringDate', 'analyticsUser', 'analyticsOrderFinish', 'analyticsOrderCancel',
            'from', 'to', 'countDeliveryFromTo', 'percentageDelivery', 'countOrderDelivery', 'analyticsOrderDelivery'
        ));
    }
}
