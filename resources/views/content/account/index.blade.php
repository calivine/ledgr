@extends('layouts.master')

@section('title', 'Account Details | Ledgr')

@section('content')
    @include('modules.modals.refresh-token')
    <main class="page-container {{ auth::user()->theme }}">
        <div class="content-row">
            <div class="col-md-8">
                <h2>Account Settings</h2>
                <h3>{{ $name }}</h3>
            </div>
        </div>
        <div class="content-row">
            <div class="col-md-8">
                <h4>API Token</h4>
                <div class="row">
                    <button type="button" class="btn btn-info" id="display-api-token">Show</button>
                    <button type="button" class="btn btn-warning" id="hide-api-token">Hide</button>
                    <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#refresh-token_modal">
                        Refresh Token
                    </button>
                </div>
                <div class="row pt-3">
                    <div class="col-md-10 offset-md-1">
                        <p id="api-token">{{ $api_token }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-row">
            <div class="col-md-8">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Change Password') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="content-row">
            <div class="col-md-8">
                <p>Change the site's theme:</p>
                <form class="" action="{{ route('changeTheme') }}" method="POST">
                    @csrf
                    {{ method_field('PUT')}}
                    <input type="radio" id="light" name="theme"
                           value="light" {{ auth::user()->theme == 'light' ? 'checked' : '' }}>
                    <label for="light">Light Theme</label>
                    <input type="radio" id="dark" name="theme"
                           value="dark" {{ auth::user()->theme == 'dark' ? 'checked' : '' }}>
                    <label for="dark">Dark Theme</label>
                    <button class="btn btn-outline-primary btn-block" id="theme-submit" type="submit"><i
                                class="material-icons icon md-18">save</i>Save
                    </button>
                </form>
            </div>
        </div>
    </main>
@endsection
