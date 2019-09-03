<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Forget password</title>
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
    <link rel="stylesheet" href="backend/css/vendor-custom.min.css">
    <!-- modernizr JS
		============================================ -->
    <script src="backend/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- buttons CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/buttons.css">
    <link rel="stylesheet" href="backend/css/loading.css">
</head>

<body>
    @include('backend.loading')
    <div class="error-pagewrap">
        <div class="error-page-int">
            <div class="text-center m-b-md custom-login">
                <img src="backend/img/logo/store-online.png" alt="STORE ONLINE">
            </div>
            <div class="content-error">
                <!-- Step 1 -->
                <div class="step step-1 show">
                    <div class="content">
                        <form method="" class="mb-55" onsubmit="return false;" id="forgetPasswordForm">
                            <p class="info mb-35">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Nếu bạn quên mật khẩu cần thiết để truy cập Store
                                        Online®, hãy nhập ID xác thực (địa chỉ email) của bạn và tiếp tục đến ngay Tiếp
                                        theo.
                                    </font>
                                </font></p>

                            <div class="form-group mb-55">
                                <label for="email">Địa chỉ email</label>
                                {{ Form::text('email', null, [
                                    'class' => 'form-control simple',
                                    'id' => 'email',
                                    'type' => 'email',
                                    'autofocus' => 'autofocus',
                                ]) }}
                                <div class="error error-email hidden"></div>
                            </div>

                            <div class="submit-group">
                                <button type="button" class="btn btn-custon-three btn-primary next" id="submit-email" style="display: block; margin: 0 auto;">Tiếp theo</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ Step 1 -->

                <!-- Step 2 -->
                <div class="step step-2 hidden">
                    <div class="content">
                        <form method="post" action="#" class="mb-40">
                            <p class="info mb-0">Một email có mã xác thực đã được gửi đến địa chỉ email đã đăng ký.</p>
                            <p class="info xsmall mb-30">Nếu không đóng màn hình này, hãy nhập mã xác thực được ghi trong văn bản email, đặt mật khẩu mới và tiếp tục với nút tiếp theo.</p>

                            <div class="form-group mb-10">
                                <label for="auth-key">Mã xác thực</label>
                                <input type="text" id="auth_key" name="auth_key" class="form-control simple" autofocus>
                                <div class="error error-auth-key hidden"></div>
                            </div>

                            <p class="info warn xsmall mb-25">Nếu bạn không thay đổi mật khẩu mới trong vòng 30 phút sau khi lấy mã xác thực, mã xác thực sẽ không hợp lệ.</p>

                            <div class="form-group">
                                <label for="new-password">Mật khẩu mới</label>
                                <input type="password" id="new_password" name="new_password" class="form-control simple">
                                <div class="error error-new-password hidden"></div>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Nhập lại mật khẩu mới</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control simple">
                                <div class="error error-confirm-password hidden"></div>
                            </div>

                            <!-- ボタンエリア -->
                            <div class="submit-group">
                                <button type="button" class="btn btn-custon-three btn-primary next" id="submit-password" style="display: block; margin: 0 auto;">Tiếp theo</button>
                                <p class="info xsmall mt-25">Nếu không nhận được email,<a href="#">ở đây</a>vui lòng liên hê với chúng tôi.</p>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ Step 2 -->
                <!-- Page 3 -->
                <div class="step step-3 hidden">
                    <div class="content">
                        <form method="post" action="#" class="mb-50">
                            <p class="info">Đặt lại mật khẩu hoàn tất.</p>
                            <p class="info xsmall mb-40">Vui lòng tiếp tục với "Đăng nhập".</p>

                            <!-- ボタンエリア -->
                            <div class="submit-group">
                                <button type="button" class="btn btn-custon-three btn-primary login" onclick="location.href='/admin/login'" style="display: block; margin: 0 auto;">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ Page 3 -->
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
    {!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#loginForm') !!}
    <script src="{{ \App\Helpers\Helper::asset('backend/js/backend/admin.js') }}"></script>
    <script src="{{ \App\Helpers\Helper::asset('backend/js/backend/forget_password.js') }}"></script>
</body>

</html>
