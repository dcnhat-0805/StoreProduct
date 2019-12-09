<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Helper;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $from = date("Y/m/d", strtotime('-6 days'));
        $to = date("Y/m/d");
        $countUserBetweenFromTo = User::getCountUSerBetweenFromTo($from, $to);
        $countUser = User::getCountUSer();
        $percentageUser = ($countUserBetweenFromTo * 100) / $countUser;
        $countMoney = Order::getCountMoney();
        $countMoneyBetweenFromTo = Order::getCountMoneyBetWeenFromTo($from, $to);
        $percentageMoney = Order::getPercentageByStatusFromTo($from, $to, FINISH);
        $countReimbursement = Order::getReimbursement();
        $countReimbursementFromTo = Order::getCountReimbursementBetWeenFromTo($from, $to);
        $percentageReimbursement = Order::getPercentageByStatusFromTo($from, $to, CANCEL);
        $countOrder = Order::getCountOrder();
        $countOrderFinish = Order::getCountOrderFromTo($from, $to, FINISH);
        $countOrderCancel = Order::getCountOrderFromTo($from, $to, CANCEL);
        $analyticsUser = User::getAnalyticsUSerBetweenFromTo($from, $to);
        $analyticsUser = substr(implode($analyticsUser), 0, -1);
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
            'arrayStringDate', 'analyticsUser', 'analyticsOrderFinish', 'analyticsOrderCancel'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
