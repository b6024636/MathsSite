<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tailored Maths</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

{{ HTML::script('js/jquery.js') }}
{{ HTML::script('js/bootstrap.js') }}
{{ HTML::style('css/styles/style.css') }}
{{ HTML::style('css/bootstrap.css') }}

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


</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="banner">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/"><span>Logo</span> Here</a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/tasks/task">Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
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
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="main-container d-flex position-ref full-height">
    <div class="content">
        @yield('content')
    </div>
</div>
{{--<div class="footer-block mt-4">--}}
{{--    <p>footer</p>--}}
{{--</div>--}}
{{ HTML::script('js/maths/school.js') }}
</body>
</html>
