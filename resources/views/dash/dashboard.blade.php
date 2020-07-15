@extends('layouts.master')

@section('title', 'Dashboard | Ledgr')

@section('content')
    @include('modules.modals.layout-modal')
    @include('modules.modals.new-transaction-modal', ['labels' => $category_form_labels])
    <main id="dashboard-container" class="container-fluid {{ $theme }}">
        <button type="button" name="button" data-toggle="modal" data-target="#modalLayout">Layout modal</button>
        <div class="dashboard-row">
            <div class="col-md-8">
                <p class="dashboard-date">{{ $dates['todays_date'] }}</p><p class="dashboard-remaining">{{ $dates['days_remaining'] == 0 ? 'Last day of ' . date('F') : ($dates['days_remaining'] == 1 ? $dates['days_remaining'] . ' day left in ' . date('F') : $dates['days_remaining'] . ' days left in ' . date('F')) }}.</p>
            </div>
        </div>
        <div class="dashboard-row" id="toggle-modal-row">
            <button type="button" class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#modalCenter">Add Transaction</button>
        </div>
        <div class="dashboard-row total-spending">
            <div class="col-md-8">
                @include('modules.progress-bar', ['data' => $monthly_total_bar])
            </div>
        </div>
        <div class="dashboard-row">
            <div class="col-md-8">
                @include('modules.budget-progress-bars', ['data' => $budget_totals_bars])
            </div>
        </div>
        <div class="dashboard-row">
            <div class="col-md-8">
                @include('modules.line-chart')
            </div>
        </div>
        <div class="dashboard-row">
            <div class="col-md-8 border-bottom border-secondary mb-0 pb-5">
                @include('modules.accordion', ['categories' => $categories, 'actuals' => $actuals])
            </div>
        </div>
        <div class="dashboard-row" id="trans-table">
            <div class="col-md-8">
                @include('modules.transactions-table', ['transactions' => $transactions, 'categories' => $category_form_labels, 'all' => False])
            </div>
        </div>
    </main>

@endsection
