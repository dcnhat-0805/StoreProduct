<!DOCTYPE html>
<html lang="en">
<head>
    <title>Store Online</title>
    <link rel="shortcut icon" type="image/x-icon" href="backend/img/store-online.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="OneTech shop project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="{{ asset('') }}">
    <link rel="stylesheet" type="text/css" href="frontend/styles/bootstrap4/bootstrap.min.css">
    <link href="frontend/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="frontend/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="frontend/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="frontend/plugins/OwlCarousel2-2.2.1/animate.css">
    <link rel="stylesheet" type="text/css" href="frontend/plugins/slick-1.8.0/slick.css">
    <link rel="stylesheet" type="text/css" href="frontend/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="frontend/styles/responsive.css">
    <link rel="stylesheet" type="text/css" href="frontend/styles/custom.css">
    <!--//tags -->
    <link href="frontend/assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="frontend/assets/css/font-awesome.css" rel="stylesheet">
    <!--pop-up-box-->
    <link href="frontend/assets/css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
    <!--//pop-up-box-->
    <!-- price range -->
    <link rel="stylesheet" type="text/css" href="frontend/assets/css/jquery-ui1.css">
    <link href="frontend/assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- buttons CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/buttons.css">
    <link rel="stylesheet" href="backend/style.css">
    <!-- notifications CSS
		============================================ -->
    <link rel="stylesheet" href="backend/css/notifications/Lobibox.min.css">
    <link rel="stylesheet" href="backend/css/notifications/notifications.css">
    @yield('cssCustom')
</head>

<body>

<div class="super_container">

    @include('frontend.layouts.header')

    <div class="container main-container">
        @yield('content')
    </div>

    @include('frontend.layouts.footer')
</div>

<script src="frontend/js/jquery-3.3.1.min.js"></script>
<script src="frontend/styles/bootstrap4/popper.js"></script>
<script src="frontend/styles/bootstrap4/bootstrap.min.js"></script>
<script src="frontend/plugins/greensock/TweenMax.min.js"></script>
<script src="frontend/plugins/greensock/TimelineMax.min.js"></script>
<script src="frontend/plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="frontend/plugins/greensock/animation.gsap.min.js"></script>
<script src="frontend/plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="frontend/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="frontend/plugins/slick-1.8.0/slick.js"></script>
<script src="frontend/plugins/easing/easing.js"></script>
<script src="frontend/js/custom.js"></script>
<!-- tawk chat JS
    ============================================ -->
    <script src="backend/js/tawk-chat.js"></script>
<!-- start-smooth-scrolling -->
<script src="frontend/assets/js/move-top.js"></script>
<script src="frontend/assets/js/easing.js"></script>
<!-- smoothscroll -->
<script src="frontend/assets/js/SmoothScroll.min.js"></script>
<!-- //smoothscroll -->
<!-- flexisel (for special offers) -->
<script src="frontend/assets/js/jquery.flexisel.js"></script>
<!-- price range (top products) -->
<script src="frontend/assets/js/jquery-ui.js"></script>
<!-- cart-js -->
<script src="frontend/assets/js/minicart.js"></script>
<!-- popup modal (for signin & signup)-->
<script src="frontend/assets/js/jquery.magnific-popup.js"></script>
<script src="frontend/assets/js/product.js"></script>
<!-- icheck JS
    ============================================ -->
<script src="backend/js/icheck/icheck.min.js"></script>
<!-- notification JS
    ============================================ -->
<script src="backend/js/notifications/Lobibox.js"></script>
<script src="backend/js/notifications/notification-active.js"></script>

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
@yield('jsCustom')
</body>

</html>
