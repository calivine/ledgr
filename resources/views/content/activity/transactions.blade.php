@extends('layouts.master')


@section('content')

<main class="page-container {{ auth::user()->theme }}">
    <div class="content-row">
        <div class="col-md-8">
            <section id="all-transactions">
                @include('modules.transactions-table', ['transactions' => $transactions, 'all' => True])
            </section>
        </div>
    </div>
</main>

@endsection
