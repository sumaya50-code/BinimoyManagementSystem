@extends('admin.index')

@section('content')
<h2>Transaction Details</h2>

<table class="table table-bordered">
    <tr><th>ID</th><td>{{ $saving->id }}</td></tr>
    <tr><th>Member</th><td>{{ $saving->member->name }}</td></tr>
    <tr><th>Type</th><td>{{ ucfirst($saving->type) }}</td></tr>
    <tr><th>Amount</th><td>{{ $saving->amount }}</td></tr>
    <tr><th>Balance After</th><td>{{ $saving->balance_after }}</td></tr>
    <tr><th>Remarks</th><td>{{ $saving->remarks }}</td></tr>
    <tr><th>Date</th><td>{{ $saving->created_at }}</td></tr>
</table>

<a class="btn btn-secondary" href="{{ route('savings.index') }}">Back</a>
@endsection
