<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
</head>
<body class="{{ auth::check() ? auth::user()->theme : '' }}">
<!-- Navbar -->
@include('nav.navbar')
<!-- Alerts -->
@include('alerts.success')
<!-- Page Content -->
@yield('content')
<!-- Footer -->
@include('layouts.partials.footer')

<script src="{{ asset('/static/js/utility.js') }}"></script>
</body>
</html>
