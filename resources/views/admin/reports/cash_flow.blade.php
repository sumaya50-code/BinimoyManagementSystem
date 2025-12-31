@extends('admin.partials.index')

@section('content')
    <div class="card p-6">
        <h3 class="text-lg font-bold mb-4">Cash Flow</h3>
        <table class="w-full table-auto">
            <thead>
                <tr><th>Date</th><th>Description</th><th>Debit</th><th>Credit</th></tr>
            </thead>
            <tbody>
                @foreach($entries as $e)
                    <tr>
                        <td>{{ $e->created_at->toDateString() }}</td>
                        <td>{{ $e->description }}</td>
                        <td>{{ number_format($e->debit,2) }}</td>
                        <td>{{ number_format($e->credit,2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <a href="?export=pdf" class="btn btn-primary">Export PDF</a>
            <a href="?export=csv" class="btn btn-secondary">Export CSV</a>
        </div>
    </div>
@endsection