@extends('layouts.master')

@section('title', 'Account Details | Ledgr')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-4">
            <h1>Account Settings</h1>
            <h3>{{ $name }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-4">
            <div class="card">
                <div class="card-header"><h4>API Token</h4></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-info" id="display-api-token">Show</button>
                            <button type="button" class="btn btn-warning" id="hide-api-token">Hide</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-1">
                            <p id="api-token">{{ $api_token }}</p>
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
    <div class="row">
        <div class="col-md-6 offset-md-4">
            <p>Change the site's theme:</p>
            <form class="" action="{{ route('changeTheme') }}" method="POST">
                @csrf
                {{ method_field('PUT')}}
                <input type="radio" id="light" name="theme" value="light" selected>
                <label for="light">Light Theme</label>
                <input type="radio" id="dark" name="theme" value="dark">
                <label for="dark">Dark Theme</label>
                <button class="btn btn-outline-primary btn-block" id="theme-submit" type="submit">Save</button>
            </form>
        </div>


    </div>
@endsection
