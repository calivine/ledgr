@extends('layout.master')

@section('title', 'Dashboard | Ledgr')

@section('content')
    <div class='container-fluid mt-50'>
        <div class='row justify-content-center mt-4'>
            <div class='col-md-8'>
                <p class='progress-bar-label text-left'>Total Spending:</p><p class='progress-bar-label float-right'>${{ round($monthly_expenditure) }} of ${{ $monthly_budget }}</p>
                @include('modules.progress-bar', ['monthly_budget' => $monthly_budget, 'monthly_expenditure' => $monthly_expenditure, 'percent' => $budget_percent])
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-4'>
                @include('modules.budget-progress-bars', $budget)
            </div>
        </div>
        <div class='row justify-content-center m-3'>
            <div class='col-md-8'>
                <button class='btn btn-outline-info btn-block' type='button' data-toggle='collapse' data-target='#collapseBody' aria-expanded='false' aria-controls='collapseBody'>View Chart</button>
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-4'>
                <div class='collapse' id='collapseBody'>
                    @include('modules.actuals-pie-chart', ['categories' => $categories, 'actuals' => $actuals])
                </div>
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                @include('modules.transactions-table', ['transactions' => $transactions, 'categories' => $category_form_labels])
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                @include('modules.input-transaction', ['categories' => $category_form_labels])
            </div>
        </div>
    </div>

    <script src="{{ asset('js/save-transaction.js') }}"></script>
    <script src="{{ asset('js/sort-table.js') }}"></script>
    <script src="{{ asset('js/edit-category.js') }}"></script>
@endsection

