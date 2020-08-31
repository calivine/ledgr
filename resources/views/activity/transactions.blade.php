@extends('layouts.master')


@section('content')

<main id="dashboard-container">
    <section>
        @include('modules.transactions-table', ['transactions' => $transactions, 'all' => True])
    </section>
</main>

@endsection
