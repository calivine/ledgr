@extends('layout.master')



@section('content')
    <h1>Account Settings</h1>

    <h3>{{ $name }}</h3>
    <h4>API Token</h4>
    <div class='row'>
        <button class='btn' id='display-api-token'>Show</button>
        <p id='api-token'>{{ $api_token }}</p>
    </div>

    <script type='text/javascript' src="{{ asset('js/api-token.js') }}"></script>

@endsection
