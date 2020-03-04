@extends('layout.master')

@section('title', 'Dashboard | Ledgr')

@section('content')
    <div class='container-fluid mt-50'>
        <div class='row'>
            <div class='col-md-6'>
                <p>{{ $today }}</p>
            </div>
            <div class='col-md-6'>
                <p class='float-right'>{{ $days_remaining  }} days remaining</p>
            </div>
        </div>
        <div class='row justify-content-center my-4'>
            <div class='col-md-8'>
                <p class='progress-bar-label text-left' style='font-size: 20px'>Total Spending:</p><p class='progress-bar-label float-right' style='font-size: 20px'>${{ round($monthly_expenditure) }} of ${{ $monthly_budget }}</p>
                @include('modules.progress-bar', ['monthly_budget' => $monthly_budget, 'monthly_expenditure' => $monthly_expenditure, 'percent' => $budget_percent])
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                @include('modules.budget-progress-bars', $budget)
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                @include('modules.accordion', ['category_form_labels' => $category_form_labels, 'categories' => $categories, 'actuals' => $actuals])
            </div>
        </div>
        <div class='row justify-content-center' id='trans-table'>
            <div class='col-md-8'>
                @include('modules.transactions-table', ['transactions' => $transactions, 'categories' => $category_form_labels])
            </div>
        </div>
    </div>

    <script src="{{ asset('js/save-transaction.js') }}"></script>

    <script src="{{ asset('js/edit-category.js') }}"></script>
@endsection

