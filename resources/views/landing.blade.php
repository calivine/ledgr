@extends('layout.master')

@section('content')
    <h1 id="landing-title">{{ config('app.randomText')[rand(0,sizeOf(config('app.randomText'))-1)] }}</h1>

    <script src="{{ asset('js/landing-text.js') }}"></script>
@endsection

