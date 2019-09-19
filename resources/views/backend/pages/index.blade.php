@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('cssCustom')
    <!-- calendar CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="backend/css/calendar/fullcalendar.print.min.css">
@endsection
@section('content')
    <div class="calender-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="calender-inner">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
    <!-- calendar JS
		============================================ -->
    <script src="backend/js/calendar/fullcalendar.min.js"></script>
    <script src="backend/js/calendar/fullcalendar-active.js"></script>
@endsection
