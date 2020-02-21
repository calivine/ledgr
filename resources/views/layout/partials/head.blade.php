<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Ledgr Is A Simple, Secure, Personal Budgeting Platform">
<meta name="author" content="">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Title -->
<title>@yield('title', config('app.name'))</title>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src='https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js'></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!-- Styles -->
<link href='{{ '/css/app.css' }}' rel='stylesheet'>