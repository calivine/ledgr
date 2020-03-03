<nav class="navbar navbar-expand-sm navbar-light bg-white shadow-sm">
    <!-- Left Side Of Navbar -->
    @if(Auth::check())
        <a class="navbar-brand" href="{{ url('/dashboard') }}">
            {{ config('app.name') }}
        </a>
    @else
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>
    @endif
    <!-- Right Side Of Navbar -->
    <ul class="nav ml-auto">
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
</nav>
