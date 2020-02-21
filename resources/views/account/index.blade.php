@extends('layout.master')



@section('content')
    <h1>Account Settings</h1>

    <h3>{{ $name }}</h3>
    <h4>API Token</h4>
    <div class='row'>
        <button class='btn' id='display-api-token'>Show</button>
        <p id='api-token'>{{ $api_token }}</p>
    </div>
    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Change Password') }}
                </a>
            @endif
        </div>
    </div>

    <script type='text/javascript' src="{{ asset('js/api-token.js') }}"></script>

@endsection
