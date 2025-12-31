@extends('admin.partials.index') @section('content')
    <div class="container">
        <h4>Savings Statement</h4>
        <p><strong>Member:</strong> {{ $account->member->name }}</p>
        <p><strong>Current Balance:</strong> {{ number_format($account->balance, 2) }}</p>
        <table id="statementTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($account->transactions as $txn)
                    <tr>
                        <td>{{ $txn->transaction_date }}</td>
                        <td>{{ ucfirst($txn->type) }}</td>
                        <td>{{ number_format($txn->amount, 2) }}</td>
                        <td>{{ $txn->remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> @push('scripts')
        <script>
            $(document).ready(function() {
                $('#statementTable').DataTable();
            });
        </script>
    @endpush
@endsection
