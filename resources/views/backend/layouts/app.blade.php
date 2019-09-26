<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Store Online - @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('') }}">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="backend/img/store-online.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="backend/css/font.css" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/font-awesome.min.css">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/owl.carousel.css">
    <link rel="stylesheet" href="backend/css/owl.theme.css">
    <link rel="stylesheet" href="backend/css/owl.transitions.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/normalize.css">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/meanmenu.min.css">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/main.css">
    <!-- educate icon CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/educate-custon-icon.css">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/morrisjs/morris.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="backend/css/metisMenu/metisMenu-vertical.css">
    <!-- calendar CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="backend/css/calendar/fullcalendar.print.min.css">
    <!-- x-editor CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/editor/select2.css">
    <link rel="stylesheet" href="backend/css/editor/datetimepicker.css">
    <link rel="stylesheet" href="backend/css/editor/bootstrap-editable.css">
    <link rel="stylesheet" href="backend/css/editor/x-editor-style.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/data-table/bootstrap-table.css">
    <link rel="stylesheet" href="backend/css/data-table/bootstrap-editable.css">
    <!-- notifications CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/notifications/Lobibox.min.css">
    <link rel="stylesheet" href="backend/css/notifications/notifications.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/custom.css">
    <link rel="stylesheet" href="backend/style.css">
    <!-- modal CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/modals.css">
    <!-- buttons CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/buttons.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/responsive.css">

    <!-- modernizr JS
		============================================ -->
    <script src="backend/js/vendor/modernizr-2.8.3.min.js"></script>
    @yield('cssCustom')
    <style>
        .form-control.is-valid, .was-validated .form-control:valid {
            border-color: #28a745;
            padding-right: calc(1.5em + .75rem);
        }
    </style>
</head>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Start Left menu area -->
@include('backend.layouts.menu')
<!-- End Left menu area -->
<!-- Start Welcome area -->
<div class="all-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="logo-pro">
                    <a href="{{route(ADMIN_DASHBOARD)}}"><img class="main-logo" src="backend/img/logo/store-online.png" alt=""/></a>
                </div>
            </div>
        </div>
    </div>
@include('backend.layouts.header')
<!-- Static Table Start -->
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- Static Table End -->
    @include('backend.layouts.footer')
</div>

<!-- jquery
    ============================================ -->
<script src="backend/js/vendor/jquery-1.12.4.min.js"></script>
<!-- bootstrap JS
    ============================================ -->
<script src="backend/js/bootstrap.min.js"></script>
<!-- wow JS
    ============================================ -->
<script src="backend/js/wow.min.js"></script>
<!-- price-slider JS
    ============================================ -->
<script src="backend/js/jquery-price-slider.js"></script>
<!-- meanmenu JS
    ============================================ -->
<script src="backend/js/jquery.meanmenu.js"></script>
<!-- owl.carousel JS
    ============================================ -->
<script src="backend/js/owl.carousel.min.js"></script>
<!-- sticky JS
    ============================================ -->
<script src="backend/js/jquery.sticky.js"></script>
<!-- scrollUp JS
    ============================================ -->
<script src="backend/js/jquery.scrollUp.min.js"></script>
<!-- mCustomScrollbar JS
    ============================================ -->
<script src="backend/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="backend/js/scrollbar/mCustomScrollbar-active.js"></script>
<!-- metisMenu JS
    ============================================ -->
<script src="backend/js/metisMenu/metisMenu.min.js"></script>
<script src="backend/js/metisMenu/metisMenu-active.js"></script>
<!-- data table JS
    ============================================ -->
<script src="backend/js/data-table/bootstrap-table.js"></script>
<script src="backend/js/data-table/tableExport.js"></script>
<script src="backend/js/data-table/data-table-active.js"></script>
{{--<script src="backend/js/data-table/bootstrap-table-editable.js"></script>--}}
<script src="backend/js/data-table/bootstrap-editable.js"></script>
<script src="backend/js/data-table/bootstrap-table-resizable.js"></script>
<script src="backend/js/data-table/colResizable-1.5.source.js"></script>
<script src="backend/js/data-table/bootstrap-table-export.js"></script>
<!--  editable JS
    ============================================ -->
<script src="backend/js/editable/jquery.mockjax.js"></script>
<script src="backend/js/editable/mock-active.js"></script>
<script src="backend/js/editable/select2.js"></script>
<script src="backend/js/editable/moment.min.js"></script>
<script src="backend/js/editable/bootstrap-datetimepicker.js"></script>
<script src="backend/js/editable/bootstrap-editable.js"></script>
<script src="backend/js/editable/xediable-active.js"></script>
<!-- Chart JS
    ============================================ -->
<script src="backend/js/chart/jquery.peity.min.js"></script>
<script src="backend/js/peity/peity-active.js"></script>
<!-- tab JS
    ============================================ -->
<script src="backend/js/tab.js"></script>
<!-- plugins JS
    ============================================ -->
<script src="backend/js/plugins.js"></script>
<!-- main JS
    ============================================ -->
<script src="backend/js/main.js"></script>
<!-- notification JS
    ============================================ -->
<script src="backend/js/notifications/Lobibox.js"></script>
<script src="backend/js/notifications/notification-active.js"></script>
<!-- icheck JS
    ============================================ -->
<script src="backend/js/icheck/icheck.min.js"></script>
<script src="backend/js/icheck/icheck-active.js"></script>
<!-- tawk chat JS
    ============================================ -->
{{--    <script src="backend/js/tawk-chat.js"></script>--}}
<!-- Laravel Javascript Validation
    ============================================ -->
<script src="backend/js/backend/common.js"></script>
<script src="backend/js/calendar/moment.min.js"></script>
<script src="{{ App\Helpers\Helper::asset('backend/js/datepicker/jquery-ui.min.js') }}"></script>

<!-- Date picker
    ============================================ -->
<script src="{{ App\Helpers\Helper::asset('backend/js/daterangepicker/daterangepicker.min.js') }}"></script>
<script src="{{ App\Helpers\Helper::asset('backend/js/daterangepicker/datepicker_range.js') }}"></script>
@yield('jsCustom')
@yield('jsCustomTwo')

@if(Session::has('success'))
    <script type="text/javascript">
        jQuery.getMessageSuccess("{{Session::get('success')}}")
    </script>
@endif

@if(Session::has('error'))
    <script type="text/javascript">
        jQuery.getMessageError("{{Session::get('error')}}")
    </script>
@endif
</body>

</html>
