<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/storage/images/inwos/icon.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inwos</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/8303b38c5f.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('ijaboCropTool-master/ijaboCropTool.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('timepicker/tpicker.css') }}">
    <script type="text/javascript" src="{{ asset('timepicker/tpicker.js') }}" defer></script>

    <style>
        body {
            overflow-x: hidden;
        }

        .service {
            transition: box-shadow 0.2s ease;
            border-radius: 0.5rem;

        }

        .service:hover {
            box-shadow: 0 0.1rem 0.4rem #8b8a8a;
        }

        .disabled-wrapper {
            display: inline-block;
            cursor: not-allowed;
        }



        /* span {
            cursor: not-allowed;
        } */
    </style>
</head>

<body>
    <div id="app">
        <nav class="pr-0 navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid pl-3 pr-5">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="/storage/images/inwos/logo.png" alt="inwos" width="140px" height="50px">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse float-end" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if(Auth::user()->image)
                                <img src="/storage/{{ Auth::user()->image }}" class="rounded-circle border" alt="{{ Auth::user()->name }}" style="width:35px; height:35px;">
                                @else
                                <img src="/storage/images/users/default.png" class="rounded-circle border" alt="default" style="width:35px; height:35px;">
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->role_id == '1')

                                <a class="dropdown-item" href="{{ route('admin.home') }}">
                                    <i class="fa-solid fa-address-book"></i>
                                    {{__('Admin')}}
                                </a>

                                @endif
                                <a class="dropdown-item" href="{{ route('user.index') }}">
                                    <i class="fa-solid fa-gears"></i>
                                    {{__('My account')}}
                                </a>
                                <a class="dropdown-item" href="{{ route('userServices.index') }}">
                                    <i class="fa-solid fa-folder-open"></i>
                                    {{__('My services')}}
                                </a>
                                <a class="dropdown-item" href="{{ route('order.index') }}">
                                    <i class="fa-solid fa-folder-open"></i>
                                    {{__('My orders')}}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-door-open"></i>
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="ijaboCropTool-master/ijaboCropTool.min.js"></script>
    <script>
        $('#_userAvatarFile').ijaboCropTool({
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            buttonsText: ['ACCEPT', 'QUIT'],
            buttonsColor: ['#30bf7d', '#ee5155', -15],
            processUrl: '{{ route("user.updateImage") }}',
            withCSRF: ['_token', '{{ csrf_token() }}'],
            onSuccess: function(message, element, status) {
                alert(message);
            },
            onError: function(message, element, status) {
                alert(message);
            }
        });
    </script>
</body>

</html>
