@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('cssCustom')
@endsection
@section('content')
    <div class="calender-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="calender-inner">
                    <div id='jsCalendar'></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
    <script src="backend/js/backend/calendar_display.js"></script>
@endsection
