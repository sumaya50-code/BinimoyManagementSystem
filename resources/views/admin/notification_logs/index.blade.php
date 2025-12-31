@extends('admin.partials.index')

@section('content')
    <div class="card p-6">
        <h3 class="text-lg font-bold mb-4">Notification Logs</h3>
        <table class="w-full table-auto">
            <thead>
                <tr><th>Date</th><th>Type</th><th>To</th><th>Channels</th><th>Status</th></tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->toDateTimeString() }}</td>
                        <td>{{ $log->type }}</td>
                        <td>{{ is_array($log->to) ? implode(',', $log->to) : $log->to }}</td>
                        <td>{{ implode(',', $log->channels ?? []) }}</td>
                        <td>{{ $log->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
@endsection
