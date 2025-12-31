@extends('admin.partials.index')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Investment Application Details</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Application Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium text-gray-600">Member:</span>
                            <span>{{ $investment->member->name }} ({{ $investment->member->member_no }})</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Partner:</span>
                            <span>{{ $investment->partner->name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Amount:</span>
                            <span>${{ number_format($investment->amount, 2) }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Status:</span>
                            <span class="px-2 py-1 rounded text-sm font-medium
                                @if($investment->status === 'approved') bg-green-100 text-green-800
                                @elseif($investment->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($investment->status) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Applied Date:</span>
                            <span>{{ $investment->applied_at ? $investment->applied_at->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        @if($investment->approved_at)
                        <div>
                            <span class="font-medium text-gray-600">Approved Date:</span>
                            <span>{{ $investment->approved_at->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Purpose</h3>
                    <p class="text-gray-600">{{ $investment->purpose ?: 'No purpose specified' }}</p>
                </div>
            </div>

            @if($investment->status === 'pending')
            <div class="border-t pt-6">
                <form action="{{ route('investments.approve', $investment->id) }}" method="POST" class="inline">
                    @csrf
                    @method('POST')
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                            onclick="return confirm('Are you sure you want to approve this investment?')">
                        Approve Investment
                    </button>
                </form>
            </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('investments.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Back to Investments</a>
            </div>
        </div>
    </div>
</div>
@endsection
