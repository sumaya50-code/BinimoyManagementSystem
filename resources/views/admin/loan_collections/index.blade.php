@extends('admin.partials.index')

@section('content')
<div class="sm:p-6 mb-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">Loan Collections</h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('loan_collections.create') }}" class="btn btn-secondary">New Collection</a>
            <button id="openCollectionModal" class="btn btn-primary">Quick Collect</button>
        </div>
    </div>
</div>

<!-- Quick Collect Modal -->
<div id="quickCollectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h3 class="text-lg font-semibold mb-4">Quick Collection</h3>
        <form id="quickCollectForm" action="{{ route('loan.collections.store') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label class="font-medium">Installment</label>
                <select name="loan_installment_id" required class="w-full border px-3 py-2 rounded">
                    <option value="">Select Installment</option>
                    @foreach(App\Models\LoanInstallment::with('loan')->where('status','pending')->get() as $inst)
                        <option value="{{ $inst->id }}">Loan #{{ $inst->loan->id ?? 'N/A' }} - Installment {{ $inst->installment_no }} - Due {{ $inst->due_date }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label class="font-medium">Amount</label>
                <input type="number" name="amount" step="0.01" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="closeCollectModal" class="btn">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<div class="card p-4">
    <table class="min-w-full divide-y divide-slate-200" id="collectionsTable">
        <thead class="bg-slate-100"><tr><th>#</th><th>Loan</th><th>Installment</th><th>Collector</th><th>Amount</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($collections as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->installment->loan->id ?? 'N/A' }}</td>
                    <td>{{ $c->installment->installment_no ?? 'N/A' }}</td>
                    <td>{{ $c->collector->name ?? 'N/A' }}</td>
                    <td>{{ $c->amount }}</td>
                    <td>{{ $c->status }}</td>
                    <td>
                        <a href="{{ route('loan_collections.show', $c->id) }}">View</a>
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
            $('#collectionsTable').DataTable();

            // Modal handlers
            $('#openCollectionModal').on('click', function(){
                $('#quickCollectModal').removeClass('hidden').addClass('flex');
            });
            $('#closeCollectModal').on('click', function(){
                $('#quickCollectModal').removeClass('flex').addClass('hidden');
            });

            // Client-side validation on forms
            $('#quickCollectForm').on('submit', function(e){
                if (!this.checkValidity()) { e.preventDefault(); this.reportValidity(); }
            });
        });
    </script>
@endpush
@endsection
