<table class='mx-auto sortable table'>
    <thead>
    <tr>
        <th></th>
        <th scope='col' class='transaction-date' data-sort='date'></th>
        <th scope='col' class='transaction-amount' data-sort='amount'></th>
        <th scope='col' data-sort='name'></th>
        <th scope='col' data-sort='name'></th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td><i class="material-icons">{{ $transaction->budget->icon }}</i></td>
            <td class='transaction-date'><small>
                    {{ $transaction->date }}
                </small></td>
            <td class='transaction-description align-middle'>{{ $transaction->description }}</td>
            <td class='transaction-amount align-middle'>${{ $transaction->amount }}</td>
            <td class='budget-category align-middle' id='{{ $transaction->id }}'>{{ $transaction->category }}</td>
            <td class='category-edit'>
                <label class='w-50 mb-0 mr-auto' for='{{ $transaction->id }}' id='category-edit-label'>Change Category</label>
                <select class='w-50 mr-auto' name='category' id='{{ $transaction->id }}' class='category-edit-select'>
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
