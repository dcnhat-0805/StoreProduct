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

</head>

<body>

<div class="super_container">

    @include('frontend.layouts.header')

    @yield('content')

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
</body>

</html>
