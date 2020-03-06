<nav class="navbar navbar-expand-sm navbar-light bg-white">
    <!-- Left Side Of Navbar -->
    <a href="{{ Auth::check() ? url('/dashboard') : url('/') }}" class="navbar-brand ml-5">{{ config('app.name') }}</a>
    <!-- Right Side Of Navbar -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
            <!-- authentication links -->
            @if(Auth::check())
                @foreach(config('app.navAuth') as $link => $label)
                    @if(Request::is(substr($link, 1)))
                        <li class='nav-item link-selected'>{{ $label }}</li>
                    @else
                        <li class="nav-item"><a href='{{ $link }}'>{{ $label }}</a></li>
                    @endif
                @endforeach
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a href='{{ '/account' }}' class='dropdown-item'>Account</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarLoginDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Login <span class="caret"></span>
                    </a>
                    <div id="login-dropdown" class="dropdown-menu dropdown-menu-right"
                         aria-labelledby="navbarLoginDropdown">
                        @include('modules.auth.login')
                    </div>
                </li>
            @endif
        </ul>
    </div>

</nav>
