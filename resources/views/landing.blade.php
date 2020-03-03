@extends('layout.master')

@section('content')
    <h1 id="landing-title">{{ config('app.name') }}</h1>

    <script src="{{ asset('js/landing-text.js') }}"></script>
@endsection

