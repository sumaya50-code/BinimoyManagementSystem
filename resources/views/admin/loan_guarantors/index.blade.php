@extends('admin.partials.index')

@section('content')
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">Loan Guarantors</h2>
        <a href="{{ route('loan_guarantors.create') }}" class="btn btn-secondary mb-4">Add Guarantor</a>
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-100">
                <tr>
                    <th>Name</th>
                    <th>Loan Proposal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guarantors as $g)
                    <tr>
                        <td>{{ $g->name }}</td>
                        <td>{{ $g->loanProposal->id ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('loan_guarantors.show', $g->id) }}" class="text-blue-600 mr-2">View</a>
                            <a href="{{ route('loan_guarantors.edit', $g->id) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
