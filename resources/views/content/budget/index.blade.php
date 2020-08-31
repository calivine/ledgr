@extends('layouts.master')

@section('content')
    @include('modules.modals.update-planned-modal')
    @include('modules.modals.new-category-modal')
    @include('modules.modals.update-icon-modal', ['icons' => $icons])
    <div class="page-container">
        <p class="ml-4">{{ $month }}</p>
        <div class="row">
            <button class="btn btn-dark" id="add-new-category"><i class="material-icons md-16">add</i>Add New Category</button>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table id="budget-table" class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Category</th>
                            <th class="text-center">Planned</th>
                            <th class="text-center">Actual</th>
                            <th class="text-right">Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($budget as $index => &$row)
                        <tr class="budget-category" id="{{ $row->id }}">
                            <td class="budget-icon"><i class="material-icons">{{ $row->icon }}</i></td>
                            <td class="budget-category-name" id="{{ $row->id }}"><small>{{ $row->category }}</small></td>
                            <td class='budget-category-planned'>$<span class="planned-value" id="{{ $row->id }}">{{ $row->planned }}</span>@include('modules.icons.edit')</td>
                            <td class="text-center">${{ $row->actual }}</td>
                            <td class="text-right">${{ $row->planned - $row->actual }}</td>
                            @if($row->actual == 0)
                                <td><a href="{{ '/budget/' . $row->id . '/delete' }}"><i class="material-icons">delete</i></a></td>
                            @endif
                        </tr>
                    @endforeach
                        <tr class="border-top border-dark" id="budget-totals">
                            <td id="planned-total-label">Total: $</td>
                            <td class="text-center" id="planned-total"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
