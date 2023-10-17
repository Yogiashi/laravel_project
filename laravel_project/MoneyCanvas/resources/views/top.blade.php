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
        <div class="d-flex slant-bg">
            <div class="mx-auto">
                <h1 class="font-weight-bold" style="color: #2b2b2b; font-size: 80px; margin-top: 10vh;">MoneyCanvas</h1>
                <div style="margin-top: 50vh;">
                    <a class="nav-link btn text-light" href="{{ route('login') }}" style="background:orange;">{{ __('ログイン') }}</a>
                    <a class="nav-link btn text-light mt-3" href="{{ route('register') }}" style="background:green;">{{ __('新規登録') }}</a>
                </div>
            </div>
            <div class="p-3 slant-bg">
                <div class="d-flex justify-content-around text-center">
                    <div class="mb-3">
                        <h4 class="text-white">自分で描くシンプル家計簿。</h4>
                        <img src="{{ asset('images/record.png')}}" style="width: 30vw; height: 35vh;">
                    </div>
                </div>
                <div class="d-flex justify-content-around text-center">
                    <div class="mt-5 mr-3">
                        <h4 class="text-white mt-5">視覚的で分かりやすい。</h4>
                        <img src="{{ asset('images/graph.png')}}" style="width: 30vw; height: 35vh;">
                    </div>
                    <div class="">
                        <h4 class="text-white">予算決めて家計管理。</h4>
                        <img src="{{ asset('images/budget.png')}}" style="width: 30vw; height: 35vh;">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>