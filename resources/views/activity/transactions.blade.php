@extends('layouts.master')


@section('content')

<main class="container">
    <section>
        @include('modules.transactions-table', ['transactions' => $transactions, 'all' => True])
    </section>
</main>

@endsection
