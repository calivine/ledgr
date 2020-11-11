<form class="p-3 md-14" method="POST" action="{{ route('login') }}">
    @csrf

    <label class="mb-0" for="email">{{ __('E-Mail Address:') }}</label>
    <input id="email" type="email"
           class="form-control mb-3 @error('email') is-invalid @enderror" name="email"
           value="{{ old('email') }}" required autocomplete="email" autofocus>
    @error('email')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror

    <label class="mb-0" for="password__modal">{{ __('Password:') }}</label>


    <input id="password__modal" type="password"
           class="form-control @error('password') is-invalid @enderror" name="password"
           required autocomplete="current-password">

    @error('password')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
    <a class="m-0 p-0" href="{{ route('password.request') }}">
        {{ __('Forgot Your Password?') }}
    </a>
    <div class="form-check my-3">
        <input class="form-check-input" type="checkbox" name="remember"
               id="remember" {{ old('remember') ? 'checked' : '' }}>

        <label class="form-check-label" for="remember">
            {{ __('Keep Me Logged In') }}
        </label>
    </div>
    <button type="submit" class="btn btn-primary btn-block">
        <i class="material-icons md-14">vpn_key</i>{{ __('LOG IN') }}
    </button>

    <p class="mt-4 text-center">Not a member? Join <a href="{{ '/register' }}">here</a>.</p>
</form>
