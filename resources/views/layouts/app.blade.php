<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="16x16" href="/theme/assets/images/favicon.png">

    <link href="/theme/dist/css/style.css" rel="stylesheet">
    <link href="/theme/dist/css/pages/authentication.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <div class="main-wrapper">
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Paidtool</p>
            </div>
        </div>

        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(/theme/assets/images/big/auth-bg2.jpg) no-repeat left center;">
            <div class="container">
                <div class="row">
                    <div class="col s12 l8 m6 demo-text">
                        <span class="db"><img src="/theme/images/logo.jpg" alt="logo" /></span>
                        <h1 class="font-light m-t-40">Welcome to the PaidTool<span class="font-medium black-text">{{ env("APP_NAME") }}</span></h1>
                        <p>A Largest Data Collection Center <p>
                             Join now and get start to work from home. Paidtool is one of the best data collection centers in the world.  Do the task and get paid everyday. <p>
                                 Please do the tasks with most valuable information and high quality images and get a chance to win huge cash prices.<p>
                        <a href="https://paidtool.com/about.html" class="btn btn-round red m-t-5">Know more</a>
                    </div>
                </div>

                <div class="auth-box auth-sidebar">
                    @yield("content")
                </div>

            </div>
        </div>

        

    </div>

    <script src="/theme/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="/theme/dist/js/materialize.min.js"></script>

    <script>
        $(function() {
            $(".preloader").fadeOut();
        });
    </script>
</body>
</html>
