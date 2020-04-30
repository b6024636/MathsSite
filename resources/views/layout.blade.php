<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Tailored Maths</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

{{ HTML::style('css/bootstrap.css') }}
{{ HTML::style('css/mdb.css') }}
{{ HTML::style('css/style.css') }}
{{ HTML::script('js/jquery.js') }}
{{ HTML::script('js/bootstrap.js') }}
{{ HTML::style('css/styles/style.css') }}
    <script src="https://kit.fontawesome.com/54970f57fd.js" crossorigin="anonymous"></script>

<!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .content {
            /*text-align: center;*/
        }
        .title {
            font-size: 84px;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <style type="text/css">
        html,
        body,
        header,
        .carousel {
            height: 60vh;
        }

        @media (max-width: 740px) {

            html,
            body,
            header,
            .carousel {
                height: 100vh;
            }
        }

        @media (min-width: 800px) and (max-width: 850px) {

            html,
            body,
            header,
            .carousel {
                height: 100vh;
            }
        }

        @media (min-width: 800px) and (max-width: 850px) {
            .navbar:not(.top-nav-collapse) {
                background: #929FBA !important;
            }
        }

    </style>


</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="banner">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/"><strong>Tailored Maths</strong></a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/tasks/task">Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @if(Auth::guard('admin')->check() || Auth::guard('teacher')->check() || Auth::guard('student')->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/login/student">
                            Login
                        </a>
                    </li>
                @endif
                @if(Auth::guard('teacher')->check() || Auth::guard('student')->check())
                <!-- Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            My School
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/myschool">View</a>
                            @if(Auth::guard('teacher')->check())
                                <a class="dropdown-item" href="/myschool/task/manage">Manage Tasks</a>
                                <a class="dropdown-item" href="/register/student">Register a new student</a>
                            @endif

                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="main-container d-flex position-ref full-height flex-column justify-content-between">
    <div class="content container">
        @yield('content')
    </div>
    <footer class="page-footer text-center font-small mt-4 wow fadeIn">

        <hr class="my-4">

        <!-- Social icons -->
        <div class="pb-4">
            <a href="https://www.facebook.com/" target="_blank">
                <i class="fab fa-facebook-f mr-3"></i>
            </a>

            <a href="https://twitter.com/" target="_blank">
                <i class="fab fa-twitter mr-3"></i>
            </a>

            <a href="https://dribbble.com/" target="_blank">
                <i class="fab fa-dribbble mr-3"></i>
            </a>

            <a href="https://pinterest.com/" target="_blank">
                <i class="fab fa-pinterest mr-3"></i>
            </a>

            <a href="https://github.com/" target="_blank">
                <i class="fab fa-github mr-3"></i>
            </a>

            <a href="http://codepen.io" target="_blank">
                <i class="fab fa-codepen mr-3"></i>
            </a>
        </div>
        <!-- Social icons -->

        <!--Copyright-->
        <div class="footer-copyright py-3">
            © 209 Copyright:
            <a href="https://mdbootstrap.com/education/bootstrap/" target="_blank"> MDBootstrap.com </a>
        </div>
        <!--/.Copyright-->

    </footer>
</div>
{{--<div class="footer-block mt-4">--}}
{{--    <p>footer</p>--}}
{{--</div>--}}
{{ HTML::script('js/maths/school.js') }}
{{ HTML::script('js/popper.min.js') }}
{{ HTML::script('js/mdb.js') }}
</body>
</html>
