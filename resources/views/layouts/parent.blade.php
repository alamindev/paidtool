<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="16x16" href="/theme/assets/images/favicon.png">
    <link href="/theme/dist/css/style.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

<script src="/theme/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/theme/dist/js/materialize.min.js"></script>
<script src="/theme/assets/libs/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
<script src="/theme/dist/js/app.js"></script>
<script src="/theme/dist/js/app.init.js"></script>
<script src="/theme/dist/js/custom.min.js"></script>
{{-- Newly added files--}}
<script src="/theme/assets/libs/tinymce/tinymce.min.js"></script>

@yield("js")
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <div id="app">
        <div class="main-wrapper" id="main-wrapper">
            <div class="preloader">
                <div class="loader">
                    <div class="loader__figure"></div>
                    <p class="loader__label">Paidtool</p>
                </div>
            </div>

            <header class="topbar">
                <nav>
                    <div class="nav-wrapper">
                        <a href="javascript:void(0)" class="brand-logo">
                            <span class="icon hide-on-small-only">
                                <img class="light-logo" src="/theme/images/logo.jpg">
                            </span>
                            <span style="padding: 0 7px;" class="icon hide-on-large-only">
                                <img src="https://ui-avatars.com/api/?size=56&background=fff&color=000&name=paid tool">
                            </span>
                        </a>
                        <ul class="left m-b-20">
                            <li class="hide-on-med-and-down">
                                <a href="javascript: void(0);" class="nav-toggle">
                                    <span class="bars bar1"></span>
                                    <span class="bars bar2"></span>
                                    <span class="bars bar3"></span>
                                </a>
                            </li>
                            <li class="hide-on-large-only">
                                <a href="javascript: void(0);" class="sidebar-toggle">
                                    <span class="bars bar1"></span>
                                    <span class="bars bar2"></span>
                                    <span class="bars bar3"></span>
                                </a>
                            </li>
                        </ul>
                        <ul class="right chat-btn-main align-items-center">
                            <li class="chat--room-parent">
                                <a href="{{route('chat.index')}}" class="chat--room-btn">Chat Room</a>
                            </li>
                            @if(Auth::user()->balance)
                            <li>
                                <label class="label label-success">${{ number_format(Auth::user()->balance, 2) }}</label>
                            </li>
                            @endif
                            <li>
                                <a class="dropdown-trigger" href="javascript: void(0);" data-target="user_dropdown"><img
                                        src="https://ui-avatars.com/api/?background=273146&color=fff&size=128&name={{Auth::user()->name}}"
                                        alt="user" class="circle profile-pic"></a>
                                <ul id="user_dropdown" class="mailbox dropdown-content dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img
                                                    src="https://ui-avatars.com/api/?background=273146&color=fff&size=128&name={{Auth::user()->name}}"
                                                    alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{ Auth::user()->name }}</h4>
                                                <p>{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('logout_user') }}"><i class="material-icons">power_settings_new</i>
                                            Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            @if(Auth::user()->isAdmin() == 1)
            @include('layouts.sidebars.admin_sidebar')
            @else
            @include('layouts.sidebars.user_sidebar')
            @endif

            @yield("content")

        </div>
    </div>
@yield("javascript")
</body>
</html>
