<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        
        <title>RU Port</title>

        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

        @if(Auth::check())
        <meta name="api_token" id="api_token" content="{{ Auth::user()->api_token }}">
        @endif

        <script type="text/javascript">
            var BASE_URL = "{{URL::to('/')}}";
        </script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/all.css')}}">
    </head>
    <body>
        @include('layout.partials.header')
        <div class="container-fluid">
            @if(Auth::check())
            <div class="row">
                @include('layout.partials.sidebar')
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    @yield('content')
                </main>
            </div>
            @else
            <main role="main">
                @yield('content')
            </main>
            @endif
        </div>
        @include('layout.partials.footer')

        @stack('added-modals')

        <script src="{{asset('js/all.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('added-scripts')
    </body>
</html>
