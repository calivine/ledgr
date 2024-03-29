@include('modules.modals.confirm-delete-modal')
<table id="transaction-table" class="mx-auto sortable table">
    <thead>
        <tr>
            <th></th>
            <th scope="col" class="transaction-date" data-sort="date"></th>
            <th scope="col" data-sort="name"></th>
            <th scope="col" data-sort="amount"></th>
            <th scope="col" data-sort="name"></th>
            @if($all)
                <th></th>
            @endif
        </tr>
    </thead>
    <tbody id="transaction-body">
    @foreach($transactions as $transaction)
        <tr>
            <td><i class="material-icons">{{ $transaction->icon }}</i></td>
            <td class="transaction-date"><small>{{ $transaction->date }}</small></td>
            <td class="transaction-description">{{ $transaction->description }}</td>
            <td class="transaction-amount">${{ $transaction->amount }}</td>
            <td class="budget-category align-middle" id="{{ $transaction->id }}">{{ $transaction->category }}</td>
            @if($all)
                <td class="transaction-delete"><i class="material-icons">delete</i></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
