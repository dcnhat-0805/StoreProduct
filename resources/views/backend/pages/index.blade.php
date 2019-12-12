@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('cssCustom')
@endsection
@section('content')
{{--    <div class="calender-area mg-b-15">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="calender-inner">--}}
{{--                    <div id='jsCalendar'></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
<div class="analytics-sparkle-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding-left: 0">
                <div class="analytics-sparkle-line reso-mg-b-30">
                    <div class="analytics-content">
                        <h5>Customer <span>( {{ $countUserBetweenFromTo }}/{{ $countUser }} )</span></h5>
                        <h2><span class="counter">{{ $countUserBetweenFromTo }}</span> <span class="tuition-fees">/ {{ $countUser }} customers</span></h2>
                        <span class="text-success">{{ $percentageUser }}%</span>
                        <div class="progress m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{ $percentageUser }}%;">
                                <span class="sr-only">{{ $percentageUser }}% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding: 0">
                <div class="analytics-sparkle-line reso-mg-b-30">
                    <div class="analytics-content">
                        <h5>Delivery <span>( {{ $countOrderDelivery }}/{{ $countOrder }} )</span></h5>
                        <h2><span class="counter">{{ \App\Helpers\Helper::loadMoney($countDeliveryFromTo) }}</span> <span class="tuition-fees">/ {{ \App\Helpers\Helper::loadMoney($countMoney) }}</span></h2>
                        <span class="text-danger">{{ \App\Helpers\Helper::loadPercentage($percentageDelivery) }}</span>
                        <div class="progress m-b-0">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{ \App\Helpers\Helper::loadPercentage($percentageDelivery) }};">
                                <span class="sr-only">{{ \App\Helpers\Helper::loadPercentage($percentageDelivery) }} Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding: 0">
                <div class="analytics-sparkle-line reso-mg-b-30 table-mg-t-pro dk-res-t-pro-30">
                    <div class="analytics-content">
                        <h5>Revenues <span>( {{ $countOrderFinish }}/{{ $countOrder }} )</span></h5>
                        <h2><span class="counter">{{ \App\Helpers\Helper::loadMoney($countMoneyBetweenFromTo) }}</span> <span class="tuition-fees">/ {{ \App\Helpers\Helper::loadMoney($countMoney) }}</span></h2>
                        <span class="text-info">{{ \App\Helpers\Helper::loadPercentage($percentageMoney) }}</span>
                        <div class="progress m-b-0">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{ \App\Helpers\Helper::loadPercentage($percentageMoney) }};">
                                <span class="sr-only">{{ \App\Helpers\Helper::loadPercentage($percentageMoney) }} Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding-right: 0">
                <div class="analytics-sparkle-line table-mg-t-pro dk-res-t-pro-30">
                    <div class="analytics-content">
                        <h5>Reimbursement <span>( {{ $countOrderCancel }}/{{ $countOrder }} )</span></h5>
                        <h2><span class="counter">{{ \App\Helpers\Helper::loadMoney($countReimbursementFromTo) }}</span> <span class="tuition-fees">/ {{ \App\Helpers\Helper::loadMoney($countMoney) }}</span></h2>
                        <span class="text-inverse">{{ \App\Helpers\Helper::loadPercentage($percentageReimbursement) }}</span>
                        <div class="progress m-b-0">
                            <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{ \App\Helpers\Helper::loadPercentage($percentageReimbursement) }};"> <span class="sr-only">{{ \App\Helpers\Helper::loadPercentage($percentageReimbursement) }} Complete</span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-sales-area mg-tb-30">
    <div class="charts-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
                    <div class="charts-single-pro">
                        <div class="alert-title">
                            <h2>The chart shows the number of customers, sales, and order reimbursement rates</h2>
                        </div>
                        <div id="axis-chart" class="box__chart">
                            <input type="hidden" class="data__label__chart" value="{{ $arrayStringDate }}">
                            <input type="hidden" class="data__analytics__user" value="{{ $analyticsUser }}">
                            <input type="hidden" class="data__analytics__order__delivery" value="{{ $analyticsOrderDelivery }}">
                            <input type="hidden" class="data__analytics__order__finish" value="{{ $analyticsOrderFinish }}">
                            <input type="hidden" class="data__analytics__order__cancel" value="{{ $analyticsOrderCancel }}">
                            <input type="hidden" class="date__from__to" value="{{ $from }} - {{ $to }}">
                            <canvas id="jsLineChart"></canvas>
                        </div>
                    </div>
                </div>
{{--                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">--}}
{{--                    <div class="charts-single-pro responsive-mg-b-30">--}}
{{--                        <div class="alert-title">--}}
{{--                            <h2>Pie Chart</h2>--}}
{{--                        </div>--}}
{{--                        <div id="pie-chart">--}}
{{--                            <canvas id="jsPieChart"></canvas>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('jsCustom')

    <script src="backend/js/backend/calendar_display.js"></script>
    <!-- Charts JS
		============================================ -->
    <script src="backend/js/charts/Chart.js"></script>
    <script src="backend/js/backend/pie_chart.js"></script>
    <script src="backend/js/backend/line_chart.js"></script>
    <script src="{{ App\Helpers\Helper::asset('backend/js/daterangepicker/datepicker_dashboard.js') }}"></script>

@endsection
