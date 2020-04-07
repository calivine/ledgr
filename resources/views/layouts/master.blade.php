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
@include('modules.navbar')
<!-- Page Content -->
@yield('content')
<!-- Footer -->
@include('layouts.partials.footer')
</body>


</html>
