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
            <td class='budget-category' id='{{ $transaction->id }}'>{{ $transaction->category }}</td>
            <td class='category-edit'>
                <label for='{{ $transaction->id }}' id='category-edit-label'>Change Category</label>
                <select name='category' id='{{ $transaction->id }}' class='category-edit-select'>
                    @foreach($categories as $category)
                        <option value='{{ $category }}'>{{ $category }}</option>
                    @endforeach
                </select>
                <button class='category-edit-submit btn btn-success' type='submit'>Save</button>
                <button class='category-edit-cancel btn' type='submit'>Cancel</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>