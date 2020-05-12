@extends('layouts.master')

@section('title', 'Dashboard | Ledgr')

@section('content')
    @include('modules.modals.new-transaction-modal', ['labels' => $category_form_labels])
    <main class='container-fluid'>
        <div class='dashboard-row'>
            <div class='col-md-8'>
                <p class='dashboard-date'>{{ $today }}</p><p class='float-right d-inline-block'>{{ $days_remaining == 0 ? 'Last day of ' . date('F') : ($days_remaining == 1 ? $days_remaining . ' day left in ' . date('F') : $days_remaining . ' days left in ' . date('F')) }}.</p>
            </div>
        </div>
        <div class="dashboard-row" id="toggle-modal-row">
            <button type="button" class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#modalCenter">Add Transaction</button>
        </div>
        <div class='dashboard-row my-4'>
            <div class='col-md-8'>
                @include('dash.modules.progress-bar', ['data' => $monthly_total_bar])
            </div>
        </div>
        <div class='dashboard-row'>
            <div class='col-md-8'>
                @include('dash.modules.budget-progress-bars', ['data' => $budget_totals_bars])
            </div>
        </div>
        <div class='dashboard-row mb-0 pb-0'>
            <div class='col-md-8 border-bottom border-secondary mb-0 pb-5'>
                @include('dash.modules.accordion', ['category_form_labels' => $category_form_labels, 'categories' => $categories, 'actuals' => $actuals])
            </div>
        </div>
        <div class='dashboard-row' id='trans-table'>
            <div class='col-md-8'>
                @include('dash.modules.transactions-table', ['transactions' => $transactions, 'categories' => $category_form_labels])
            </div>
        </div>
    </main>

@endsection
