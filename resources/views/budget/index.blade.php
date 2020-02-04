@extends('layout.master')

@section('content')
    <table>
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
                <td class='budget-category-name'>{{ $row->category }}</td>
                <td class='budget-category-planned'>{{ $row->planned }}</td>
                <td>{{ $row->actual }}</td>
                <td></td>
            </tr>
        @endforeach
        <tr id='budget-totals'>
            <td id='planned-total-label'>Total:</td>
            <td id='planned-total'></td>
        </tr>

        </tbody>
    </table>

@endsection
