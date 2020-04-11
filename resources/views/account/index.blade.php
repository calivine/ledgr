@extends('layouts.master')

@section('title', 'Account Details | Ledgr')

@section('content')
    <div class='row'>
        <div class='col-md-6 offset-md-4'>
            <h1>Account Settings</h1>
            <h3>{{ $name }}</h3>
        </div>
    </div>
    <div class='row'>
        <div class='col-md-6 offset-md-4'>
            <div class='card'>
                <div class='card-header'><h4>API Token</h4></div>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-md-6'>
                            <button type='button' class='btn btn-info' id='display-api-token'>Show</button>
                            <button type='button' class='btn btn-warning' id='hide-api-token'>Hide</button>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6 offset-md-1'>
                            <p id='api-token'>{{ $api_token }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
@endsection
