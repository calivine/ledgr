@extends('layout.master')

@section('content')
    <div class='container-fluid w-50 mt-50 bg-light shadow'>
        <h2>Dashboard</h2>
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

        <fieldset class='shadow' id='manual-input-form'>
            <legend id='manual-input-legend'>
                Manual Input
            </legend>
            <label for='description-input'>Transaction Description:</label>
            <input type='text' class='manual-input' name='description' id='description-input'>
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

    <script>
        $(function () {
            $('button#manual-input-button').bind('click', function () {
                console.log($('input#description-input').val());
                $.post('/save_transaction', {
                    description: $('input#description-input').val(),
                    amount: $('input#amount-input').val(),
                    category: $('select#manual-select-category').val(),
                    transaction_date: $('input#transaction-date-input').val()
                }).done( function () {
                    let $inputForm = $('fieldset#manual-input-form');
                    let $successAlert = $('<div></div>');
                    let $closeButton = $('<button></button>');
                    let $x = $('<span></span>');
                    $inputForm.fadeOut();
                    $('input#description-input').val("");
                    $('input#amount-input').val("");
                    $('input#transaction-date-input').val("");
                    $inputForm.fadeIn();
                    $x.attr('aria-hidden', 'true').text('&times;');
                    $closeButton.attr('type', 'button')
                        .attr('aria-label', 'Close')
                        .attr('data-dismiss', 'alert')
                        .addClass('close')
                        .prepend($x);
                    // $closeButton.prepend($x);
                    $successAlert.addClass('alert alert-primary').attr('role', 'alert').text('Saved New Transaction');
                    $successAlert.prepend($closeButton);
                    $inputForm.prepend($successAlert);
                }).fail( function () {
                    $('fieldset#manual-input-form').fadeOut().fadeIn();
                });
                return false;
            });
        });
    </script>

@endsection

