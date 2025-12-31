@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Cash Assets</h1>
    <a href="{{ route('cash_assets.create') }}" class="btn btn-primary mb-4">Add Cash Asset</a>
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-100"><tr><th>Name</th><th>Type</th><th>Balance</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($assets as $a)
                <tr>
                    <td>{{ $a->name }}</td>
                    <td>{{ $a->type }}</td>
                    <td>{{ $a->balance }}</td>
                    <td>
                        <a href="{{ route('cash_assets.edit', $a->id) }}">Edit</a>
                        <form action="{{ route('cash_assets.destroy', $a->id) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button>Delete</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection