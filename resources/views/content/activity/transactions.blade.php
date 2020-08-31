@extends('layouts.master')


@section('content')

<main id="content-container">
    <section>
        @include('modules.transactions-table', ['transactions' => $transactions, 'all' => True])
    </section>
</main>

@endsection
