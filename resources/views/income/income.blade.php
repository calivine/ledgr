@extends('layouts.master')


@section('content');
    <div class='container-fluid bg-light shadow'>
        <div class='row justify-content-center'>
            <form method='POST' action='{{ '/income' }}'>
                {{ csrf_field() }}
                <div class='form-group'>
                    <label for='income-description' class='w-100 mb-0'>Description:</label>
                    <input type='text' name='description' id='income-description'>
                </div>
                <div class='form-group'>
                    <label for='income-frequency-select' class='w-100 mb-0'>Frequency:</label>
                    <select name='frequency' id='income-frequency-select'>
                        <option value='weekly'>Weekly</option>
                        <option value='bi-weekly'>Bi-Weekly</option>
                        <option value='monthly'>Monthly</option>
                        <option value='once'>Once</option>
                    </select>
                </div>
                <div class='form-group'>
                    <label for='income-amount' class='w-100 mb-0'>Amount:</label>
                    <input type='number' step='0.01' name='amount' id='income-amount'>
                </div>
                <div class='form-group'>
                    <button class='btn btn-block btn-success' type='submit'>Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection