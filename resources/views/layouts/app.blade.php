<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'hackatum') }}</title>

    <!-- Fonts -->
		<link rel="stylesheet" href="/css/fa-solid.css" />
		<link rel="stylesheet" href="/css/fa-regular.css" />
		<link rel="stylesheet" href="/css/fontawesome.css" />


    <!-- Scripts -->
		@yield('scripts')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'hackatum') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
											<li class="nav-item">
												<a class="nav-link" href="{{ route('home') }}">
													Home
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="{{ route('ideas.list') }}">
													Ideas
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="{{ route('idea.new') }}">
													New
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="{{ route('leaderboard') }}">
													Community
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="{{ route('areas') }}">
													Areas
												</a>
											</li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
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
                    </ul>
                </div>
            </div>
        </nav>

				@if(Session::has('success'))
				    <div class="alert alert-success">
				        {{Session::get('success')}}
				    </div>
				@endif
				@if(Session::has('fail'))
				    <div class="alert alert-danger">
				        {{Session::get('fail')}}
				    </div>
				@endif
				@if(Session::has('warning'))
				    <div class="alert alert-warning">
				        {{Session::get('warning')}}
				    </div>
				@endif
				@if(Session::has('info'))
				    <div class="alert alert-info">
				        {{Session::get('info')}}
				    </div>
				@endif


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
