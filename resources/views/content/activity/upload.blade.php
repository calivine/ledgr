@extends('layouts.master')


@section('content')

    <main id="content-container" class="page-container">
        <div class="content-row">
            <div class="col-md-8">
                <section>
                    <table>
                        <tbody>
                            <form action="{{ route('saveAllTransactions') }}" method="POST">
                                @csrf
                                @foreach($transactions as $index => &$transaction)
                                <tr>
                                    <td>
                                        <input type="text" name="{{ 'date' . $index }}" value="{{ $transaction[0] }}">
                                    </td>
                                    <td>
                                        <input type="number" name="{{ 'amount' . $index }}" value="{{ $transaction[1] }}">
                                    </td>
                                    <td>
                                        <input type="text" name="{{ 'description' . $index }}" value="{{ $transaction[2] }}">
                                    </td>
                                    <td>
                                        <input type="text" name="{{ 'category' . $index }}" value="{{ $transaction[3] }}">
                                    </td>
                                </tr>
                                @endforeach
                                <button type="submit" name="button">Save Transactions</button>
                            </form>
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </main>
@endsection
