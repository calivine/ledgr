<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Ledgr Is A Simple, Secure, Personal Budgeting Platform">
<meta name="author" content="">
<meta name="theme-color" content="{{ auth::check() ? auth::user()->theme == 'dark' ? '#1c1f2b' : '#38c172' : '#38c172' }}"/>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Title -->
<title>@yield('title', config('app.name'))</title>

<!-- Scripts -->
<script src="{{ asset('/static/js/app.js') }}"></script>
<script src='https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels'></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!-- Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Styles -->
<link href='{{ '/static/css/app.css' }}' rel='stylesheet'>

<script>
    $(function() {
        let tz_offset = new Date().getTimezoneOffset();
        tz_offset = tz_offset == 0 ? 0 : -tz_offset;
        $.post('/get_user_tz', {
            timezone: tz_offset
        });
        return false;
    });
</script>
