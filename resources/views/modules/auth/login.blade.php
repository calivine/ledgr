<form class="p-3" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email"
               class="form-control @error('email') is-invalid @enderror" name="email"
               value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <label class="mb-0" for="password">{{ __('Password') }}</label>


        <input id="password" type="password"
               class="form-control @error('password') is-invalid @enderror" name="password"
               required autocomplete="current-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
        <a class="btn btn-link mt-0" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
    </div>

    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember"
                   id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                {{ __('Keep Me Logged In') }}
            </label>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">
            {{ __('Login') }}
        </button>
    </div>
    <div class="row">
        <p class="px-3">Not a member? Join <a href="{{ '/register' }}">here</a>.</p>
    </div>
</form>
