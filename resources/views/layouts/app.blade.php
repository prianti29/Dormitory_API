<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('loginCSS/login.css') }}"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&family=Roboto:ital,wght@0,100;0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('loginCSS/main.css') }}">
</head>

<body>
    @include('layouts.navigation')
    <div class="container">
        @yield('contents')
    </div>
</body>
