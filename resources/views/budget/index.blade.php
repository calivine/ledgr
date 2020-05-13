@extends('layouts.master')

@section('content')
    @include('modules.modals.update-planned-modal')
    @include('modules.modals.new-category-modal')
    <div class="container-fluid">
        <p class='ml-4'>{{ $period }}</p>
        <div class="row">
            <button class='btn btn-outline-dark' id='add-new-category'><i class="material-icons md-16">add</i>Add New Category</button>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table id='budget-table' class='table'>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Category</th>
                            <th class='text-center'>Planned</th>
                            <th class='text-center'>Actual</th>
                            <th class='text-right'>Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($budget as $index => &$row)
                        <tr class='budget-category'>
                            <td><i class="material-icons">{{ $row->icon }}</i></td>
                            <td class='budget-category-name' id='{{ $row->id }}'><small>{{ $row->category }}</small></td>
                            <td class='budget-category-planned'>$<span class='planned-value' id='{{ $row->id }}'>{{ $row->planned }}</span>@include('modules.icons.edit')</td>
                            <td class='text-center'>${{ $row->actual }}</td>
                            <td class='text-right'>${{ $row->planned - $row->actual }}</td>
                        </tr>
                    @endforeach
                        <tr class='border-top border-dark' id='budget-totals'>
                            <td id='planned-total-label'>Total: $</td>
                            <td class='text-center' id='planned-total'></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
