@extends('layout.master')

@section('content')
    <div class='container-fluid mt-50 bg-light shadow'>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                <table class='mx-auto p-2 sortable table shadow'>
                    <thead>
                    <tr>
                        <th scope='col' class='transaction-date' data-sort='date'></th>
                        <th scope='col' class='transaction-amount' data-sort='amount'></th>
                        <th scope='col' data-sort='name'></th>
                        <th scope='col' data-sort='name'></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td class='transaction-date'><small>
                                    {{ $transaction->date }}
                                </small></td>
                            <td class='transaction-description'>{{ $transaction->description }}</td>
                            <td class='transaction-amount'>${{ $transaction->amount }}</td>
                            <td class='category'>{{ $transaction->category }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                <fieldset class='shadow' id='manual-input-form'>
                    <div class='form-group'>
                        <label for='description-input'>Transaction Description:</label>
                        <input type='text' class='manual-input' name='description' id='description-input'>
                    </div>

                    <label for='amount-input'>Amount $:</label>
                    <input type='number' step='0.01' class='manual-input' id='amount-input' name='amount'>
                    <label for='manual-select-category'>Category</label>
                    <select name='category' id='manual-select-category' class='manual-input'>
                        @foreach($categories as $category)
                            <option value='{{ $category }}'>{{ $category }}</option>
                        @endforeach
                    </select>
                    <label for='transaction-date-input'>Transaction Date:</label>
                    <input type='date' class='manual-input' id='transaction-date-input' name='transaction_date'>
                    <button class='manual-input' id='manual-input-button' type='submit'>Save</button>
                </fieldset>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/save-transaction.js') }}"></script>
    <script src="{{ asset('js/sort-table.js') }}"></script>
@endsection

