<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('/images/logo-only.png')}}">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- vite(['resources/sass/app.scss', 'resources/js/app.js']) -->

</head>

<body>
    <style>
        body {
            /* @if(1) */
            background-color: #2E3236 !important;
            background-size: cover;
            background-repeat: no-repeat;
            font-family: "Marcellus SC";
            color: #FFFFFF !important;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* min-width: 400px; */
            /* @else */
            background-size: cover;
            background-repeat: no-repeat;
            font-family: "Marcellus SC";
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* min-width: 400px; */
            /* @endif */
        }

        #app {
            flex: 1;
            background-image: url("/images/bg-2.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            /* position: relative; */
        }

        .border-img {
            border: 10px solid transparent;
            border-image-source: url(images/border.png);
            border-image-slice: 20;
        }

        .border-gradient {
            border: 10px solid;
            border-image-slice: 1;
            border-width: 5px;
        }

        .border-gradient-purple {
            border-image-source: linear-gradient(to left, #FEDB37, #8A6E2F);
        }

        .navbar {
            font-size: 18px;
        }

        a.nav-link,
        a.dropdown-item {
            /* padding: 9px 14px; */
            border-bottom: 1.5px solid transparent;
            /* color: #ab9002; */
            position: relative;
        }

        a.nav-link {
            /* top: 3px; */
        }

        a.nav-link::after {
            content: "";
            height: 1px;
            width: 100%;
            position: absolute;
            background-color: gold;
            transform: scaleX(0);
            transition: transform 250ms ease-in-out;
            left: 0;
            bottom: 0;
        }

        a.nav-link:hover::after {
            transform: scaleX(1);
        }

        .active a.nav-link:hover::after {
            transform: scaleX(0);
        }

        a.nav-link:hover {
            color: gold !important;
            /* border-bottom-color: gold; */
        }

        .active a.nav-link {
            color: gold !important;
            /* border-bottom-color: gold; */
        }

        ul.navbar-nav>li {
            width: fit-content;
        }


        /* add arrow */
        /* .active a.nav-link::before {
            content: "";
            width: 0;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-bottom: 7px solid gold;
            position: absolute;
            lef                  t: 50%;
            transform: translate(-7px, 0);
            bottom: 0;
        } */

        .active a.nav-link::before {
            content: "";
            height: 1px;
            width: 100%;
            position: absolute;
            background-color: gold;
            left: 0;
            bottom: 1px;
        }

        .breadcrumb {
            padding: 8px 15px;
            margin-bottom: 20px;
            list-style: none;
            background-color: #434651;
            border-radius: 4px;
        }

        /* .breadcrumb-item {
            display: inline-block;
            margin-right: 0.5rem;
        } */

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            vertical-align: middle;
            margin: 0 0.5rem;
            color: #6c757d;
        }

        .breadcrumb-item.active {
            font-weight: 500;
            color: #212529;
        }

        .background-image {
            background-image: url("/images/3_2.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            height: 91vh;
            position: relative;
        }

        .footer {
            padding-top: 20px;
            /* position: absolute;
            bottom: 0;
            width: 100%; */
        }

        /* .navbar-nav .dropdown-menu {
            position: relative;
        } */

        @media (max-width: 992px) {
            .navbar-nav .dropdown-menu {
                position: absolute;
                right: auto;
            }

            .navbar-bar {
                flex-direction: unset;
            }

            .navbar-brand img {
                width: 260px;
            }
        }

        @media (max-width: 480px) {
            .navbar-brand img {
                width: 240px;
            }
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus {
            -webkit-text-fill-color: white;
            -webkit-box-shadow: 0 0 0px 1000px #212529 inset;
        }

        #loader {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75) center center;
            z-index: 99999;
            text-align: center;
            padding: calc(100vh/2 - 50px) 0;
        }
    </style>

    <div id='loader'>
        <img src="{{asset('/images/logo-loading.svg')}}" alt="Loading" width="95" loading="lazy">
        <h4 class="text-warning mt-2">Loading ...</h4>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid" style="justify-content: left;">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                @if(1)
                <img src="{{asset('/images/logo-dark.svg')}}" alt="Gold Asset Management Logo" width="280" loading="lazy">
                @else
                <img src="{{asset('/images/logo-light.svg')}}" alt="Gold Asset Management Logo" width="280" loading="lazy">
                @endif
            </a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/') }}">{{__('Home')}}</a>
                    </li>
                    <li class="nav-item {{ Request::is('plan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/plan') }}">{{__('Plan')}}</a>
                    </li>
                    <li class="nav-item {{ Request::is('calculator') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/calculator') }}">{{__('Calculator')}}</a>
                    </li>
                    <li class="nav-item {{ Request::is('goldprice') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/goldprice') }}">{{__('Gold Price')}}</a>
                    </li>
                    <li class="nav-item {{ Request::is('about') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('#about') }}">{{__('About Us')}}</a>
                    </li>
                    <li class="nav-item {{ Request::is('contact') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('#contact') }}">{{__('Contact Us')}}</a>
                    </li>
                    <li class="nav-item {{ Request::is('transaction') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('transaction') }}">{{__('Transaction')}}</a>
                    </li>
                </ul>

                <hr>

                <ul class="navbar-nav ms-auto" style="flex-direction: unset;">
                    @auth
                    <li class="nav-item dropdown">
                        @else
                    <li class="nav-item dropdown p-2">
                        @endauth
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
                                <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z" />
                                <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.94.31z" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('locale.setting', 'en') }}">{{__('EN')}}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('locale.setting', 'zh_CN') }}">{{__('简中')}}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('locale.setting', 'ms') }}">{{__('BM')}}</a>
                            </li>
                        </ul>
                    </li>

                    @auth
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                            {{ Auth::user()->name}}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>

                    @else
                    <li class="nav-item {{ Request::is('login') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item {{ Request::is('register') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endauth
                </ul>
            </div> -->

            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width: 300px;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Gold Asset Calculator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @auth
                        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/') }}">{{__('Home')}}</a>
                        </li>
                        <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/admin') }}">{{__('Plan')}}</a>
                        </li>
                        @endauth
                    </ul>

                    <hr>

                    <ul class="navbar-nav ms-auto" style="flex-direction: unset;gap: 8px;">
                        <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle h-100" data-bs-toggle="dropdown" aria-expanded="false" title="{{__('language')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
                                    <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z" />
                                    <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.94.31z" />
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" onclick="langChange('en')">{{__('EN')}}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" onclick="langChange('zh_CN')">{{__('简中')}}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" onclick="langChange('ms')">{{__('BM')}}</a>
                                </li>
                            </ul>
                        </li>

                        @auth
                        <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle h-100" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                </svg>
                                {{ Auth::user()->name}}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                <li class="{{ Request::is('admin') ? 'active' : '' }}">
                                    <a class="dropdown-item" href="{{ url('admin') }}">{{__('Admin Panel')}}</a>
                                </li>
                                <li><a class="dropdown-item" href="#">{{ __('Profile') }}</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('admin/logout') }}" id="logoutBtn">
                                        {{ __('Logout') }}
                                    </a>
                                </li>
                                <form id="logout-form" action="admin/logout" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>

                        @else
                        <li class="nav-item {{ Request::is('login') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item {{ Request::is('register') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>

        </div>
    </nav>

    <div id="app">
        <main>
            @yield('content')
        </main>

    </div>

    <footer class="footer bg-dark">
        <div class="container">
            <p>Email: info@goldassetmanagement.com</p>
            <p>Phone: 1-800-GOLD-123</p>
        </div>
    </footer>

    <script>
        //if page not loaded more than 200ms
        const pageLoadTimeout = setTimeout(startLoader, 200);

        $(window).on('load', function() {
            $("#loader").fadeOut(200, function() {
                // fadeOut complete. Remove the loading div
                $("#loader").remove(); //makes page more lightweight 
            });
        })

        function startLoader() {
            $("#loader").fadeIn();
            clearTimeout(pageLoadTimeout);
        }

        function langChange(locale) {
            $.get("set-locale/" + locale, function(data, status) {
                if (status != 404) {
                    window.location.reload();
                }
            });
        };

        $(`#${$('html')[0].lang}`).addClass("bg-warning text-black");

        $("#logoutBtn").on("click", function() {
            event.preventDefault();
            localStorage.clear();
            $("#logout-form").submit();
        });
    </script>
</body>

</html>