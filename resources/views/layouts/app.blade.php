<!DOCTYPE html>
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

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light navbar-white">
            <div class="container">
                <a href="" class="navbar-brand">
                    <img src="images/icono.png" alt="" class="brand-image img-circle elevation-3"
                         style="opacity: .8; width: 40px; height: 40px; border-radius: 50%;">
                    <span class="brand-text font-weight-light">CocoaSweet</span>
                </a>
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Contacto</a>
                    </li>
                </ul>
                <!-- SEARCH FORM -->
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

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
     <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
         {{ Auth::user()->name }}
     </a>

     <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
         <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
             {{ __('Logout') }}
         </a>

         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
             @csrf
         </form>
     </div>
 </li>
@endguest
           </div>
        </nav>
        <!-- /.navbar -->

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
