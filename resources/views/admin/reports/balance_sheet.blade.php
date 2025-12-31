@extends('admin.partials.index')

@section('content')
    <div class="card p-6">
        <h3 class="text-lg font-bold mb-4">Balance Sheet</h3>
        <h4>Assets</h4>
        <ul>
            @foreach($assets as $a)
                <li>{{ $a['account']->name }} - {{ number_format($a['amount'],2) }}</li>
            @endforeach
        </ul>

        <h4>Liabilities</h4>
        <ul>
            @foreach($liabilities as $a)
                <li>{{ $a['account']->name }} - {{ number_format($a['amount'],2) }}</li>
            @endforeach
        </ul>

        <h4>Equity</h4>
        <ul>
            @foreach($equity as $a)
                <li>{{ $a['account']->name }} - {{ number_format($a['amount'],2) }}</li>
            @endforeach
        </ul>

        <div class="mt-4">
            <a href="?export=pdf" class="btn btn-primary">Export PDF</a>
            <a href="?export=csv" class="btn btn-secondary">Export CSV</a>
        </div>
    </div>
@endsection