@extends('admin.partials.index')
@section('content')
    <div class="container">
        <h4>Savings Withdrawal Requests</h4>

        <!-- Withdrawal Requests -->
        <table id="withdrawals-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td>{{ $request->member->name }}</td>
                        <td>{{ number_format($request->amount, 2) }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td>
                            @if ($request->status == 'pending')
                                <a href="{{ route('savings.approveWithdrawal', $request->id) }}"
                                    class="btn btn-success btn-sm">Approve</a>
                            @endif
                            <a href="{{ route('savings.voucher', $request->id) }}" class="btn btn-secondary btn-sm">Voucher</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Withdrawal Request Form -->
        <h5>Submit Withdrawal Request</h5>
        <form method="POST" action="{{ route('savings.withdrawRequest') }}">
            @csrf
            <select name="member_id" class="form-control mb-2">
                @foreach (App\Models\Member::all() as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
            <input type="number" name="amount" class="form-control mb-2" placeholder="Amount">
            <button class="btn btn-danger">Request Withdrawal</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#withdrawals-table').DataTable();
        });
    </script>
@endsection
