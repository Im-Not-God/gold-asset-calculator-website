<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
</head>

<body>
    <style>
        body {
            background-color: #2E3236 !important;
            background-size: cover;
            background-repeat: no-repeat;
            font-family: "Marcellus SC";
            color: #FFFFFF !important;
        }

        .navbar {
            font-size: 18px;
        }

        a.nav-link {
            padding: 14px;
            border-bottom: 1.5px solid transparent;
            /* color: #ab9002; */
            position: relative;
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
            bottom: -1px;
        }

        a.nav-link:hover::after {
            transform: scaleX(1);
        }

        a.nav-link:hover {
            color: gold;
            /* border-bottom-color: gold; */
        }

        .active a.nav-link {
            color: gold !important;
            /* border-bottom-color: gold; */
        }

        #navbarSupportedContent ul li {
            width: fit-content;
        }

        .active a.nav-link::before {
            content: "";
            /* height: 0; */
            width: 0;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-bottom: 7px solid gold;
            position: absolute;
            left: 50%;
            transform: translate(-7px, 0);
            bottom: 0;
        }

        .breadcrumb {
            padding: 8px 15px;
            margin-bottom: 20px;
            list-style: none;
            background-color: #cecece;
            border-radius: 4px;
        }

        .breadcrumb-item {
            display: inline-block;
            margin-right: 0.5rem;
        }

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
            background-image: url("images/3_2.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            height: 91vh;
        }

    </style>
    <div id="app">

        @include('components.navbar')

        <main>
            @yield('content')
        </main>


        <footer class="footer bg-dark">
            <div class="container">
                <p class="text-white">I am footer</p>

            </div>
        </footer>

    </div>
</body>

</html>