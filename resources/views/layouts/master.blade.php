<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
</head>
<body>
@if(session('alert'))
    <div class='alert-success'>
        {{ session('alert') }}
    </div>
@endif
<!-- Navbar -->
@include('nav.navbar')
<!-- Page Content -->
@yield('content')
<!-- Footer -->
@include('layouts.partials.footer')

<script src="{{ asset('js/utility.js') }}"></script>
</body>
</html>
