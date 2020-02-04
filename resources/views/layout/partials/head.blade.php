<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="description" content="">

<meta name="author" content="">

<title>@yield('title', config('app.name'))</title>

<script src="{{ asset('js/app.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!-- Custom styles for this template -->
<link href='{{ '/css/app.css' }}' rel='stylesheet'>