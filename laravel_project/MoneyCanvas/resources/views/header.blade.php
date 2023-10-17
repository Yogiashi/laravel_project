<div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
                @else
                <a class="navbar-brand font-weight-bold" href="{{ url('/home') }}">
                    {{ config('app.name') }}
                </a>
                @endguest
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
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-light" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('record-home').submit();">
                                        {{ __('ホーム') }}
                                    </a>
                                    <form id="record-home" action="{{ route('home') }}" method="get" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('index') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('record-index').submit();">
                                        {{ __('履歴一覧') }}
                                    </a>
                                    <form id="record-index" action="{{ route('index') }}" method="get" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('new') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('record-form').submit();">
                                        {{ __('記録する') }}
                                    </a>
                                    <form id="record-form" action="{{ route('new') }}" method="get" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('categoryNew') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('category-form').submit();">
                                        {{ __('カテゴリ登録') }}
                                    </a>
                                    <form id="category-form" action="{{ route('categoryNew') }}" method="get" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('budgetNew') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('budget-form').submit();">
                                        {{ __('予算作成') }}
                                    </a>
                                    <form id="budget-form" action="{{ route('budgetNew') }}" method="get" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('budgetIndex') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('budgetIndex-form').submit();">
                                        {{ __('予算一覧') }}
                                    </a>
                                    <form id="budgetIndex-form" action="{{ route('budgetIndex') }}" method="get" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>