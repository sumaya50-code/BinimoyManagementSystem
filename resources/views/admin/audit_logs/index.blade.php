@extends('admin.partials.index')

@section('content')
    <div class="card p-6">
        <h3 class="text-lg font-bold mb-4">Audit Logs</h3>
        <table class="w-full table-auto">
            <thead>
                <tr><th>Date</th><th>User</th><th>Action</th><th>Model</th><th>Details</th></tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->toDateTimeString() }}</td>
                        <td>{{ $log->user_id }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->auditable_type }}</td>
                        <td>{{ json_encode(array_merge($log->old_values ?? [], $log->new_values ?? [])) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
@endsection
