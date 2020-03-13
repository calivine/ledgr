@extends('layout.master')

@section('title', 'Dashboard | Ledgr')

@section('content')
    @include('modules.new-transaction-modal', ['labels' => $category_form_labels])
    <div class='container-fluid mt-50'>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                <p class='text-left w-50 d-inline-block'>{{ $today }}</p><p class='float-right d-inline-block'>{{ $days_remaining  }} days remaining</p>
            </div>
        </div>
        <div id="toggle-modal-row" class="row justify-content-center">
            <button type="button" class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#modalCenter">Add Transaction</button>
        </div>
        <div class='row justify-content-center my-4'>
            <div class='col-md-8'>
                @include('modules.progress-bar', ['data' => $monthly_total_bar])
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                @include('modules.budget-progress-bars', ['data' => $budget_totals_bars])
            </div>
        </div>
        <div class='row justify-content-center mb-0 pb-0'>
            <div class='col-md-8 border-bottom border-secondary mb-0 pb-5'>
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

