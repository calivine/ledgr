@extends('layouts.master')


@section('content')

<main id="content-container" class="page-container {{ auth::check() ? auth::user()->theme : '' }}">
    <div class="content-row">
        <div class="col-md-8">
            <section class="all-transactions">
                @include('modules.transactions-table', ['transactions' => $transactions, 'all' => True])
            </section>
        </div>
    </div>

</main>

@endsection
