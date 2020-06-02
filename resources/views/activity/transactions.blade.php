@extends('layouts.master')


@section('content')

<main class="container">
    <section>
        @include('dash.modules.transactions-table', ['transactions' => $transactions])
    </section>
</main>

@endsection
