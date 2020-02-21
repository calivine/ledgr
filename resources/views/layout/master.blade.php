<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layout.partials.head')
</head>
<body>
@if(session('alert'))
    <div class='alert-success'>
        {{ session('alert') }}
    </div>
@endif

@include('layout.partials.navbar')

@yield('content')

@include('layout.partials.footer')
</body>


</html>