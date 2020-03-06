@extends('layout.master')

@section('content')
    <div class="container-fluid">
        <p class='ml-4'>{{ $period }}</p>
        <button class='btn btn-outline-dark' id='add-new-category'>Add New Category</button>
        <table id='budget-table'>
            <thead>
            <tr>
                <th>Category</th>
                <th class='text-center'>Planned</th>
                <th class='text-center'>Actual</th>
                <th class='text-right'>Remaining</th>
            </tr>
            </thead>
            <tbody>
            @foreach($budget as $index => &$row)
                <tr class='budget-category'>
                    <td id='{{ $row['id'] }}' class='budget-category-name text-wrap'>{{ $row['category'] }}</td>
                    <td class='budget-category-planned text-center'>{{ $row['planned'] }}</td>
                    <td class='text-center'>{{ $row['actual'] }}</td>
                    <td class='text-right'>${{ $row['planned'] - $row['actual'] }}</td>
                </tr>
            @endforeach
            <tr id='budget-totals'>
                <td id='planned-total-label'>Total:</td>
                <td class='text-center' id='planned-total'></td>
            </tr>
            </tbody>
        </table>
    </div>


    <script type='text/javascript' src="{{ asset('js/BudgetWorker.js') }}"></script>
    <script type='text/javascript' src="{{ asset('js/budget-index.js') }}"></script>
@endsection
