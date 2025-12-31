@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Partner: {{ $partner->name }}</h1>
    <div class="card p-4">
        <p><strong>Share %:</strong> {{ $partner->share_percentage }}</p>
        <p><strong>Invested Amount:</strong> {{ $partner->invested_amount }}</p>
        <p><strong>Total Investments:</strong> {{ $partner->investments->count() }}</p>
    </div>
</div>
@endsection