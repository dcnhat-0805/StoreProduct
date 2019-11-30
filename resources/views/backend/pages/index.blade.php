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
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="analytics-sparkle-line reso-mg-b-30">
                    <div class="analytics-content">
                        <h5>Computer Technologies</h5>
                        <h2>$<span class="counter">5000</span> <span class="tuition-fees">Tuition Fees</span></h2>
                        <span class="text-success">20%</span>
                        <div class="progress m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only">20% Complete</span> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="analytics-sparkle-line reso-mg-b-30">
                    <div class="analytics-content">
                        <h5>Accounting Technologies</h5>
                        <h2>$<span class="counter">3000</span> <span class="tuition-fees">Tuition Fees</span></h2>
                        <span class="text-danger">30%</span>
                        <div class="progress m-b-0">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:30%;"> <span class="sr-only">230% Complete</span> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="analytics-sparkle-line reso-mg-b-30 table-mg-t-pro dk-res-t-pro-30">
                    <div class="analytics-content">
                        <h5>Electrical Engineering</h5>
                        <h2>$<span class="counter">2000</span> <span class="tuition-fees">Tuition Fees</span></h2>
                        <span class="text-info">60%</span>
                        <div class="progress m-b-0">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span class="sr-only">20% Complete</span> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="analytics-sparkle-line table-mg-t-pro dk-res-t-pro-30">
                    <div class="analytics-content">
                        <h5>Chemical Engineering</h5>
                        <h2>$<span class="counter">3500</span> <span class="tuition-fees">Tuition Fees</span></h2>
                        <span class="text-inverse">80%</span>
                        <div class="progress m-b-0">
                            <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">230% Complete</span> </div>
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
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="charts-single-pro">
                        <div class="alert-title">
                            <h2>Line Chart Multi Axis</h2>
                        </div>
                        <div id="axis-chart">
                            <canvas id="jsLineChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="charts-single-pro responsive-mg-b-30">
                        <div class="alert-title">
                            <h2>Pie Chart</h2>
                        </div>
                        <div id="pie-chart">
                            <canvas id="jsPieChart"></canvas>
                        </div>
                    </div>
                </div>
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

@endsection
