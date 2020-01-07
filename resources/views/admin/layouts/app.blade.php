<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
	
	<link rel="stylesheet" href="{{url('public/assets/font-awesome/css/font-awesome.min.css')}}">
	
	<link rel="stylesheet" href="{{url('public/assets/sweet/sweetalert.min.css')}}">
	
	<style>
		.cust_error{ color:red;}
		.preview{ height: 70px; width: 70px;}
	</style>
	
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
						
                        @if(!empty(Auth::guard('admin')->user()))
							<li class="nav-item">
								<a class="nav-link" href="{{route('admin_dashboard')}}">Dashboard
                                </a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route('companies.index')}}">Company
                                </a>
							</li>							
							<li class="nav-item">
								<a class="nav-link" href="{{route('employees.index')}}">Employee
                                </a>
							</li>							
							
								
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('admin')->user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin_logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('admin_logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
						@else
							@php 
							/*
							@if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('show_admin_register_form') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
							*/
							@endphp
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
		
		<script src="{{url('public/assets/jquery/jquery-3.3.1.min.js')}}"  crossorigin="anonymous"></script>
		
		<script src="{{url('public/assets/sweet/sweetalert.min.js')}}"></script>
		
		<script>
			var BASE_URL = "@php echo BASE_URL; @endphp";
			var ADMIN_URL = "@php echo ADMIN_URL; @endphp";
		</script>
						
		@stack('scripts')
		
    </div>
</body>
</html>
