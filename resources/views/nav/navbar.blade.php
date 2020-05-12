<nav class="navbar navbar-expand-sm navbar-light {{ Auth::check() ? 'bg-mint' : 'bg-white' }}" id="nav">
    <!-- Left Side Of Navbar -->
    <a href="{{ Auth::check() ? url('/dashboard') : url('/') }}" class="navbar-brand">{{ config('app.name') }}</a>
    <!-- Right Side Of Navbar -->

    <ul class="nav nav-list">
        <!-- authentication links -->
        @if(Auth::check())
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @foreach(config('app.navAuth') as $link => $label)
                        <a class="dropdown-item" href='{{ $link }}'>{{ $label }}</a>
                    @endforeach
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
            <li class="nav-item dropdown">
                <a id="navbarLoginDropdown" class="nav-link text-body" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="material-icons icon-size">vpn_key</i>
                    <span class="navLinkExpand">
                        Login
                   </span>
                </a>
                <div id="login-dropdown" class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="navbarLoginDropdown">
                    @include('modules.auth.login')
                </div>
            </li>
            <li class="nav-item">
                <a id="navbarRegister" class="nav-link text-body" href="{{ route('register') }}"><i
                            class="material-icons icon-size">assignment_ind</i><span
                            class="navLinkExpand">{{ __('Register') }}</span></a>
            </li>
        @endif
    </ul>
</nav>
