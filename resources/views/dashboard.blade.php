@extends('layout.master')

@section('content')

    <div class='container-fluid mt-50 bg-light shadow'>
        <div class='row justify-content-center'>
            <div class='col-md-6'>
                @include('modules.actuals-pie-chart', ['categories' => $categories, 'actuals' => $actuals]);
            </div>
        </div>
        <div class='row justify-content-center'>
            <h5>${{ $monthly_expenditure }}</h5>
        </div>
        <div class='row justify-content-center'>
            <h4>Spending:</h4>
            <div class='col-md-6'>
                @include('modules.progress-bar', ['monthly_budget' => $monthly_budget, 'monthly_expenditure' => $monthly_expenditure])
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                @include('modules.transactions-table', $transactions)
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                @include('modules.input-transaction', $categories)
            </div>
        </div>
    </div>

    <script src="{{ asset('js/save-transaction.js') }}"></script>
    <script src="{{ asset('js/sort-table.js') }}"></script>
@endsection

