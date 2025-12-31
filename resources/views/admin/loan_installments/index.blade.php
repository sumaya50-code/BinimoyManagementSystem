@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Loan Installments</h2>
    <table id="loanInstallmentsTable" class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-100"><tr><th>#</th><th>Loan</th><th>Installment No</th><th>Due Date</th><th>Amount</th><th>Paid</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($installments as $inst)
                <tr>
                    <td>{{ $inst->id }}</td>
                    <td>{{ $inst->loan->id ?? '-' }}</td>
                    <td>{{ $inst->installment_no }}</td>
                    <td>{{ $inst->due_date }}</td>
                    <td>{{ $inst->amount }}</td>
                    <td>{{ $inst->paid_amount }}</td>
                    <td>{{ $inst->status }}</td>
                    <td>
                        <a href="{{ route('loan_installments.show', $inst->id) }}">View</a>
                        <a href="{{ route('loan_installments.edit', $inst->id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script>
        $(function(){
            $('#loanInstallmentsTable').DataTable();
        });
    </script>
@endpush
@endsection