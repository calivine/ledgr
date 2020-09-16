@extends('layouts.master')

@section('content')
    <script>
        $(function() {
            let tz_offset = new Date().getTimezoneOffset();
            tz_offset = tz_offset == 0 ? 0 : -tz_offset;
            console.log(tz_offset);
            $.post('/get_user_tz', {
                timezone: tz_offset
            });
            return false;
        });
    </script>
    <section id="landing-title-bg">
        <blockquote id="landing-title">{{ Illuminate\Foundation\Inspiring::quote() }}</blockquote>
    </section>

    <script src="{{ asset('/static/js/landing-text.js') }}"></script>
@endsection
