@extends('admin.partials.index')

@section('content')
    <div class="card p-6">
        <h3 class="text-lg font-bold mb-4">Company Fund</h3>
        @if($fund)
            <p><strong>Balance:</strong> {{ number_format($fund->balance,2) }}</p>
            <p><small>Last updated: {{ $fund->updated_at->toDateTimeString() }}</small></p>
        @else
            <p>No company fund record found.</p>
        @endif
    </div>
@endsection