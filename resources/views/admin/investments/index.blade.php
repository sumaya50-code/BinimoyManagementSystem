@extends('admin.partials.index')

@section('content')
<div class="card p-6">
    <h3 class="text-lg font-bold mb-4">Investment Applications</h3>
    <table class="w-full table-auto">
        <thead><tr><th>#</th><th>Member</th><th>Partner</th><th>Amount</th><th>Status</th></tr></thead>
        <tbody>
            @foreach($apps as $app)
                <tr>
                    <td>{{ $app->id }}</td>
                    <td>{{ $app->member->name ?? '-' }}</td>
                    <td>{{ $app->partner->name ?? '-' }}</td>
                    <td>{{ number_format($app->applied_amount,2) }}</td>
                    <td>{{ $app->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $apps->links() }}</div>
</div>
@endsection