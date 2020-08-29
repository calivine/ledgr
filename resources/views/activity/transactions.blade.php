@extends('layouts.master')


@section('content')

<main class="container-fluid">
    <section>
        <div>
            <div class="col-lg-12">
                @include('modules.transactions-table', ['transactions' => $transactions, 'all' => True])
            </div>
        </div>
    </section>
</main>

@endsection
