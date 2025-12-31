@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">New Withdrawal Request</h1>

            <form action="{{ route('withdrawals.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="partner_id" class="block text-sm font-medium text-gray-700 mb-2">Partner</label>
                    <select name="partner_id" id="partner_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Partner</option>
                        @foreach(\App\Models\Partner::all() as $partner)
                        <option value="{{ $partner->id }}">{{ $partner->name }} (Invested: ${{ number_format($partner->invested_amount, 2) }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Withdrawal Amount</label>
                    <input type="number" name="amount" id="amount" step="0.01" min="0.01"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">Purpose</label>
                    <textarea name="purpose" id="purpose" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('withdrawals.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
