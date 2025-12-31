@extends('admin.partials.index')

@section('content')
    <div class="card p-6">
        <h3 class="text-lg font-bold mb-4">Profit & Loss</h3>
        <p><strong>Income:</strong> {{ number_format($income,2) }}</p>
        <p><strong>Expenses:</strong> {{ number_format($expenses,2) }}</p>
        <p><strong>Net Profit:</strong> {{ number_format($profit,2) }}</p>

        <div class="mt-4">
            <a href="?export=pdf" class="btn btn-primary">Export PDF</a>
            <a href="?export=csv" class="btn btn-secondary">Export CSV</a>
        </div>
    </div>
@endsection