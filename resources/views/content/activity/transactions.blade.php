@extends('layouts.master')


@section('content')

<main id="content-container">
    <section class="all-transactions">
        @include('modules.transactions-table', ['transactions' => $transactions, 'all' => True])
    </section>
</main>

@endsection
