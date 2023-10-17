<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf/token" content="{{ csrf_token()}}">
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
        <script src="{{ asset('/js/app.js') }}"></script>
        <title>MoneyCanvas</title>
    </head>
    <body>
        <header>@include('header')</header>
        <main>
            <div class="container">
                @if (session('flash_message'))
                    <div class="flash_message">
                        {{ session('flash_message') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </body>
</html>