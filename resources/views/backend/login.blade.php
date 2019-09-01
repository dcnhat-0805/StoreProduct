<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>
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
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/main.css">
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
    <!-- forms CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/form/all-type-forms.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/custom.css">
    <link rel="stylesheet" href="backend/style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="backend/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
<div class="error-pagewrap">
    <div class="error-page-int">
        <div class="text-center m-b-md custom-login">
            <img src="backend/img/logo/store-online.png" alt="STORE ONLINE">
        </div>
        <div class="content-error">
            <div class="hpanel">
                <div class="panel-body">
                    <form action="{{route(ADMIN_LOGIN)}}" id="loginForm" method="POST">
                        @csrf

                        <div class="flash-message">
                            @foreach (['danger', 'warning', 'success', 'info', 'error'] as $msg)
                                @if(Session::has($msg))
                                    <div class="alert alert-{{ $msg }}">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                                onclick="this.parentElement.style.display='none';"
                                                style="font-size: 1rem;line-height: 13px;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <li>
                                            {!! Session::get($msg) !!}
                                        </li>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            {{ Form::text('email', null, [
                                'id' => 'email',
                                'class' => 'form-control',
                                'type' => 'email',
                                'autofocus' => 'autofocus',
                                'title' => 'Email',
                                'placeholder' => 'Vui lòng nhập email...'
                            ]) }}
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Password</label>
                            <input type="password" title="Password" placeholder="Vui lòng nhập password..."
                                   name="password" id="password" class="form-control">
                        </div>
                        <div class="checkbox login-checkbox">
                            <label><input type="checkbox" class="i-checks" name="remember_token" {{ old('remember_token') ? 'checked' : '' }}> Remember me </label>
                        </div>
                        <button class="btn btn-success btn-block loginbtn">Login</button>
                        <a class="forget-password" href="#">Quên mật khẩu ?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center login-footer">
        <p>Copyright © 2019 Store Online. All rights reserved.</p>
        <nav class="nav-footer">
            <ul>
                <li><a href="#"><font style="vertical-align: inherit;"><font
                                style="vertical-align: inherit;">Chính sách bảo mật</font></font></a></li>
                <li><a href="#"><font style="vertical-align: inherit;"><font
                                style="vertical-align: inherit;">Điều khoản sử dụng</font></font></a></li>
            </ul>
        </nav>
    </div>
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
<!-- tab JS
    ============================================ -->
<script src="backend/js/tab.js"></script>
<!-- icheck JS
    ============================================ -->
<script src="backend/js/icheck/icheck.min.js"></script>
<script src="backend/js/icheck/icheck-active.js"></script>
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
<!-- tawk chat JS
    ============================================ -->
{{--    <script src="backend/js/tawk-chat.js"></script>--}}
<!-- Laravel Javascript Validation
    ============================================ -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
</body>

</html>
