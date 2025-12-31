@extends('admin.partials.index')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Collection Report</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('reports.collections', request()->query()) }}&export=pdf"
                       class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Export PDF
                    </a>
                    <a href="{{ route('reports.collections', request()->query()) }}&export=excel"
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Export Excel
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="officer_id" class="block text-sm font-medium text-gray-700 mb-1">Field Officer</label>
                        <select name="officer_id" id="officer_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Officers</option>
                            @foreach(\App\Models\User::where('role', 'field_officer')->get() as $officer)
                            <option value="{{ $officer->id }}" {{ request('officer_id') == $officer->id ? 'selected' : '' }}>
                                {{ $officer->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filter</button>
                    <a href="{{ route('reports.collections') }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Clear</a>
                </div>
            </form>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-800">Total Collections</h3>
                    <p class="text-2xl font-bold text-blue-600">${{ number_format($summary['total_collections'], 2) }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800">Verified Collections</h3>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($summary['verified_collections'], 2) }}</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-yellow-800">Pending Collections</h3>
                    <p class="text-2xl font-bold text-yellow-600">${{ number_format($summary['pending_collections'], 2) }}</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-red-800">Overdue Amount</h3>
                    <p class="text-2xl font-bold text-red-600">${{ number_format($summary['overdue_amount'], 2) }}</p>
                </div>
            </div>

            <!-- Collections Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 border-b text-left">Date</th>
                            <th class="px-4 py-2 border-b text-left">Member</th>
                            <th class="px-4 py-2 border-b text-left">Loan</th>
                            <th class="px-4 py-2 border-b text-left">Officer</th>
                            <th class="px-4 py-2 border-b text-left">Amount</th>
                            <th class="px-4 py-2 border-b text-left">Status</th>
                            <th class="px-4 py-2 border-b text-left">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($collections as $collection)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $collection->transaction_date->format('M d, Y') }}</td>
                            <td class="px-4 py-2 border-b">{{ $collection->installment->loan->member->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $collection->installment->loan->loan_amount }}</td>
                            <td class="px-4 py-2 border-b">{{ $collection->collector->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border-b">${{ number_format($collection->amount, 2) }}</td>
                            <td class="px-4 py-2 border-b">
                                <span class="px-2 py-1 rounded text-sm font-medium
                                    @if($collection->status === 'verified') bg-green-100 text-green-800
                                    @elseif($collection->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($collection->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border-b">{{ $collection->remarks ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">No collections found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($collections->hasPages())
            <div class="mt-6">
                {{ $collections->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
