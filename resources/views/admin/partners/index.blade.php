@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Partners</h1>
    <a href="{{ route('partners.create') }}" class="btn btn-primary mb-4">Add Partner</a>
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-100"><tr><th>Name</th><th>Invested</th><th>Share %</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($partners as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->invested_amount }}</td>
                    <td>{{ $p->share_percentage }}</td>
                    <td>
                        <a href="{{ route('partners.edit', $p->id) }}">Edit</a>
                        <form action="{{ route('partners.destroy', $p->id) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button>Delete</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection