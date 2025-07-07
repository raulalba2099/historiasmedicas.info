<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    {{-- estilos propios --}}

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    <!-- Fonts -->|

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="container">
    <div class="row">
        <div class="col-12 d-md-none text-center">
            <a href="/">
                <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->
                <img src="{{url('/')}}/imgs/logo-general.jpeg" alt="logo" width="87px" height="80px">
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="">
            <div>
{{--                <a href="/">--}}
{{--                    <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->--}}
{{--                    <img src="{{url('/')}}/imgs/logo-general.jpeg" alt="logo" width="87px" height="80px">--}}
{{--                </a>--}}
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>

</div>

</body>
</html>
