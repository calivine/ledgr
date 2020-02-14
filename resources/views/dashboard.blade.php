@extends('layout.master')

@section('content')

    <div class='container-fluid mt-50 bg-light shadow'>
        <div class='row justify-content-center'>
            <div class='col-md-6'>
                @include('modules.actuals-pie-chart', ['categories' => $categories, 'actuals' => $actuals])
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                <p class='progress-bar-label text-left'>Total Spending:</p><p class='progress-bar-label float-right'>${{ $monthly_expenditure }} of ${{ $monthly_budget }}</p>
                @include('modules.progress-bar', ['monthly_budget' => $monthly_budget, 'monthly_expenditure' => $monthly_expenditure, 'percent' => $budget_percent])
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                @include('modules.transactions-table', ['transactions' => $transactions, 'categories' => $categories])
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
    <script src="{{ asset('js/edit-category.js') }}"></script>
@endsection

