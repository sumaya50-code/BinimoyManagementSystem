@extends('admin.partials.index')
@section('content')
    <div class="container">
        <h4>Savings Transactions</h4>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Account No</th>
                            <th>Member</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->account->account_no }}</td>
                                <td>{{ $transaction->account->member->name }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    <span
                                        class="badge {{ $transaction->status == 'approved' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                                <td>{{ $transaction->remarks }}</td>
                                <td>
                                    @if ($transaction->type == 'deposit' && $transaction->status == 'pending')
                                        <a href="{{ route('savings.approveDeposit', $transaction->id) }}"
                                            class="btn btn-success btn-sm">Approve</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $transactions->links() }}
    </div>
@endsection
