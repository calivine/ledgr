@extends('layout.master')

@section('content')
    <p class='ml-4'>{{ $period }}</p>
    <button class='btn btn-outline-dark' id='add-new-category'>Add New Category</button>
    <table id='budget-table'>
        <thead>
        <tr>
            <th>Category</th>
            <th>Planned</th>
            <th>Actual</th>
            <th>Remaining</th>
        </tr>
        </thead>
        <tbody>
        @foreach($budget as $row)
            <tr class='budget-category'>
                <td id='{{ $row->id }}' class='budget-category-name'>{{ $row->category }}</td>
                <td class='budget-category-planned'>{{ $row->planned }}</td>
                <td>{{ $row->actual }}</td>
                <td>${{ $row->planned - $row->actual }}</td>
            </tr>
        @endforeach
        <tr id='budget-totals'>
            <td id='planned-total-label'>Total:</td>
            <td id='planned-total'></td>
        </tr>


        </tbody>
    </table>

    <script type='text/javascript' src="{{ asset('js/BudgetWorker.js') }}"></script>
    <script type='text/javascript' src="{{ asset('js/budget-index.js') }}"></script>
@endsection
