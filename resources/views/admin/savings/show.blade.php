@extends('admin.partials.index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Savings Account Details</h4>
                            <div>
                                <a href="{{ route('savings.edit', $account->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('savings.index') }}" class="btn btn-secondary btn-sm">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Account Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Account No:</th>
                                        <td>{{ $account->account_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Member:</th>
                                        <td>{{ $account->member->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Balance:</th>
                                        <td>{{ number_format($account->balance, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Interest Rate:</th>
                                        <td>{{ $account->interest_rate }}%</td>
                                    </tr>
                                    <tr>
                                        <th>Created At:</th>
                                        <td>{{ $account->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Quick Actions</h5>
                                <a href="{{ route('savings.statement', $account->member_id) }}"
                                    class="btn btn-info btn-sm mb-2">View Statement</a>
                                <br>
                                <a href="{{ route('savings-dashboard') }}" class="btn btn-primary btn-sm">Go to
                                    Dashboard</a>
                            </div>
                        </div>

                        <hr>

                        <h5>Transaction History</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($account->transactions->sortByDesc('transaction_date') as $transaction)
                                        <tr>
                                            <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                                            <td>{{ ucfirst($transaction->type) }}</td>
                                            <td>{{ number_format($transaction->amount, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $transaction->status == 'approved' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $transaction->remarks }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No transactions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
