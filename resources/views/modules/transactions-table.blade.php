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