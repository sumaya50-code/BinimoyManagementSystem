@extends('admin.partials.index')
@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Withdrawal Requests</h2>
        <a href="{{ route('withdrawals.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> New Request
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Member</th>
                    <th>Amount (৳)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawals as $key => $w)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $w->member->name }}</td>
                    <td>{{ number_format($w->amount, 2) }}</td>
                    <td>{{ ucfirst($w->status) }}</td>
                    <td>
                        @if($w->status=='pending')
                        <form action="{{ route('withdrawals.approve', $w->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        @endif
                        <a href="{{ route('withdrawals.edit', $w->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('withdrawals.destroy', $w->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($withdrawals->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No withdrawal requests found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
