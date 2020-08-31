@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <p>Get started by setting up your first budget!</p>
            <p>Fill in the planned budget values.</p>
            <div class="col-md-8">
                <table id="budget-table" class="mx-auto table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Category</th>
                        <th>Planned</th>
                    </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="{{ route('setup') }}">
                            @csrf
                            @foreach($budget as $index => &$row)
                            <tr class="budget-category">
                                <td><i class="material-icons">{{ $row->icon }}</i></td>
                                <td id="{{ $row->id }}" class="budget-category-name text-wrap"><small>{{ $row->category }}</small></td>
                                <td class="budget-category-planned text-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                        </div>
                                        <input type="text" name="{{ $row->id }}" value="{{ $row->planned }}" required>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                        <tr class="border-top border-dark" id="budget-totals">
                            <td id="planned-total-label">Total:</td>
                            <td class="text-center" id="planned-total"></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <a href="/dashboard">I'd rather do this later.</a>

    </div>
@endsection
