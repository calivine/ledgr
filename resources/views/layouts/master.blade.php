<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
</head>
<body class="{{ auth::check() ? auth::user()->theme : '' }}">
@if(session('alert'))
    <div class="alert-success">
        <span class="alert-text">{{ session('alert') }}</span>
    </div>
@endif
<!-- Navbar -->
@include('nav.navbar')
<!-- Page Content -->
@yield('content')
<!-- Footer -->
@include('layouts.partials.footer')

<script src="{{ asset('/static/js/utility.js') }}"></script>
</body>
</html>
