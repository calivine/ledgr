@extends('layouts.master')

@section('content')
    
    <section id="landing-title-bg">
        <blockquote id="landing-title">{{ Illuminate\Foundation\Inspiring::quote() }}</blockquote>
    </section>

    <script src="{{ asset('/static/js/landing-text.js') }}"></script>
@endsection
