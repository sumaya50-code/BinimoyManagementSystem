@extends('admin.index')

@section('content')
<div class="container">
    <h3>Savings Interest Calculation</h3>

    <p><strong>Current Balance:</strong> {{ $lastBalance }} BDT</p>
    <p><strong>Annual Interest (5%):</strong> {{ $interest }} BDT</p>

    <h4>Transaction History</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Amount</th>
                <th>Balance</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ ucfirst($t->type) }}</td>
                <td>{{ $t->amount }}</td>
                <td>{{ $t->balance }}</td>
                <td>{{ ucfirst($t->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
