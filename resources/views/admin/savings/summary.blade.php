@extends('admin.partials.index')



@section('content')
    <div class="container">
        <h5>Savings Accounts Summary</h5>
        <table id="summary-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Account No</th>
                    <th>Balance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->member->name }}</td>
                        <td>{{ $account->account_no }}</td>
                        <td>{{ number_format($account->balance, 2) }}</td>
                        <td>
                            <a href="{{ route('savings.statement', $account->member_id) }}"
                                class="btn btn-secondary btn-sm">Statement</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#summary-table').DataTable();
        });
    </script>
@endsection
