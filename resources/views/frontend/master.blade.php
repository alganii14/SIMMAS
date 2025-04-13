<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masjid Khairul Amal</title>
    <link rel="icon" href="{{asset('masjid')}}/main_files/assets/img/favicon.png">
    <!-- CSS only -->
    <link rel="stylesheet" type="text/css" href="{{asset('masjid')}}/main_files/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('masjid')}}/main_files/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{asset('masjid')}}/main_files/assets/css/owl.theme.default.min.css">
    <!-- fancybox -->
    <link rel="stylesheet" href="{{asset('masjid')}}/main_files/assets/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="{{asset('masjid')}}/main_files/assets/css/nice-select.css">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="{{asset('masjid')}}/main_files/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{asset('masjid')}}/main_files/assets/css/audioplayer.css">
    <!-- style -->
    <link rel="stylesheet" href="{{asset('masjid')}}/main_files/assets/css/style.css">
    <!-- responsive -->
    <link rel="stylesheet" href="{{asset('masjid')}}/main_files/assets/css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="{{asset('masjid')}}/main_files/assets/js/jquery-3.6.0.min.js"></script>
    <script src="{{asset('masjid')}}/main_files/assets/js/preloader.js"></script>
</head>
<body>
    <!-- preloader -->
    <div class="preloader">
        <div class="loader">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>

    @include('frontend.navbar')
    @include('frontend.content')
    @include('frontend.footer')

    <!-- Bootstrap Js -->
    <script src="{{asset('masjid')}}/main_files/assets/js/bootstrap.min.js"></script>
    <script src="{{asset('masjid')}}/main_files/assets/js/jquery.nice-select.min.js"></script>
    <script src="{{asset('masjid')}}/main_files/assets/js/owl.carousel.min.js"></script>
    <script src="{{asset('masjid')}}/main_files/assets/js/circle-progres.js"></script>
    <!-- fancybox -->
    <script src="{{asset('masjid')}}/main_files/assets/js/jquery.fancybox.min.js"></script>
    <script src="{{asset('masjid')}}/main_files/assets/js/audioplayer.js"></script>
    <script>
        $(function() {
            $('audio').audioPlayer();
        });
    </script>
    <script src="{{asset('masjid')}}/main_files/assets/js/custom.js"></script>
</body>
</html>