@extends('admin.partials.index')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                {{ $member->name }}
                <span class="text-sm text-slate-500"> ({{ $member->member_no }})</span>
            </h1>
            <p class="text-slate-500 mt-1">Member Detailed Overview & Activities</p>
        </div>

        <a href="{{ route('members.index') }}" class="px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-900 text-white shadow">
            ← Back to Members
        </a>
    </div>

    {{-- Top Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="p-6 rounded-xl shadow border bg-blue-100">
            <p class="text-sm text-blue-700">Total Loans</p>
            <h2 class="text-3xl font-bold text-blue-900">{{ $member->loanProposals->count() }}</h2>
        </div>

        <div class="p-6 rounded-xl shadow border bg-green-100">
            <p class="text-sm text-green-700">Savings Accounts</p>
            <h2 class="text-3xl font-bold text-green-900">{{ $member->savingsAccounts->count() }}</h2>
        </div>

        <div class="p-6 rounded-xl shadow border bg-yellow-100">
            <p class="text-sm text-yellow-700">Total Withdrawal Amount</p>
            <h2 class="text-3xl font-bold text-yellow-900">{{ number_format($member->savingsWithdrawalRequests->sum('amount') ?? 0, 2) }}</h2>
        </div>

    </div>


    {{-- Personal Information Only --}}
    <div class="bg-white rounded-xl shadow border p-6 mb-8">
        <h2 class="text-xl font-semibold text-slate-800 mb-4 border-b pb-2">
            Personal Information
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2">
            <p><strong>Guardian:</strong> {{ $member->guardian_name ?? '-' }}</p>
            <p><strong>NID:</strong> {{ $member->nid }}</p>
            <p><strong>Phone:</strong> {{ $member->phone }}</p>
            <p><strong>Email:</strong> {{ $member->email ?? '-' }}</p>
            <p><strong>Present Address:</strong> {{ $member->present_address }}</p>
            <p><strong>Permanent Address:</strong> {{ $member->permanent_address ?? '-' }}</p>
            <p><strong>Nominee:</strong> {{ $member->nominee_name ?? '-' }} ({{ $member->nominee_relation ?? '-' }})</p>

            <p>
                <strong>Status:</strong>
                <span
                    class="px-2 py-1 text-xs rounded-full
                {{ $member->status == 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $member->status }}
                </span>
            </p>

            <p><strong>Gender:</strong> {{ $member->gender ?? '-' }}</p>
            <p><strong>DOB:</strong> {{ $member->dob ?? '-' }}</p>
            <p><strong>Marital Status:</strong> {{ $member->marital_status ?? '-' }}</p>
            <p><strong>Education:</strong> {{ $member->education ?? '-' }}</p>
            <p><strong>Dependents:</strong> {{ $member->dependents ?? 0 }}</p>
        </div>
    </div>


    {{-- Tabs Section --}}
    <div class="bg-white shadow rounded-xl border p-6">

        <ul class="flex border-b mb-6 text-sm font-medium text-slate-600">
            <li class="mr-4">
                <a href="#loans" class="py-2 px-4 rounded-t bg-slate-100">Loans</a>
            </li>
            <li class="mr-4">
                <a href="#savings" class="py-2 px-4 rounded-t bg-slate-100">Savings</a>
            </li>
            <li>
                <a href="#withdrawals" class="py-2 px-4 rounded-t bg-slate-100">Withdrawals</a>
            </li>
        </ul>

        {{-- Loans --}}
        <div id="loans">
            <h3 class="text-lg font-semibold mb-3 text-slate-800">Loan Records</h3>

            @if ($member->loanProposals->isEmpty())
                <p class="text-slate-500">No loan records found.</p>
            @else
                <table class="w-full border rounded overflow-hidden">
                    <thead class="bg-slate-100 text-left">
                        <tr>
                            <th class="py-2 px-3">Loan ID</th>
                            <th class="py-2 px-3">Amount</th>
                            <th class="py-2 px-3">Status</th>
                            <th class="py-2 px-3">Applied Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member->loanProposals as $loan)
                            <tr class="border-b">
                                <td class="py-2 px-3">{{ $loan->id }}</td>
                                <td class="py-2 px-3">{{ $loan->loan_amount }}</td>
                                <td class="py-2 px-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded
                                    {{ $loan->status == 'approved'
                                        ? 'bg-green-100 text-green-700'
                                        : ($loan->status == 'pending'
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="py-2 px-3">{{ $loan->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>


        {{-- Savings --}}
        <div id="savings" class="mt-8">
            <h3 class="text-lg font-semibold mb-3 text-slate-800">Savings Accounts</h3>

            @if ($member->savingsAccounts->isEmpty())
                <p class="text-slate-500">No savings account records found.</p>
            @else
                <table class="w-full border rounded overflow-hidden">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="py-2 px-3">Account No</th>
                            <th class="py-2 px-3">Balance</th>
                            <th class="py-2 px-3">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member->savingsAccounts as $account)
                            <tr class="border-b">
                                <td class="py-2 px-3">{{ $account->account_no }}</td>
                                <td class="py-2 px-3">{{ $account->balance }}</td>
                                <td class="py-2 px-3">{{ $account->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>


        {{-- Withdrawals --}}
        <div id="withdrawals" class="mt-8">
            <h3 class="text-lg font-semibold mb-3 text-slate-800">Withdrawals</h3>

            @if ($member->savingsWithdrawalRequests->isEmpty())
                <p class="text-slate-500">No withdrawal records found.</p>
            @else
                <table class="w-full border rounded overflow-hidden">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="py-2 px-3">Withdrawal ID</th>
                            <th class="py-2 px-3">Amount</th>
                            <th class="py-2 px-3">Status</th>
                            <th class="py-2 px-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member->savingsWithdrawalRequests as $withdraw)
                            <tr class="border-b">
                                <td class="py-2 px-3">{{ $withdraw->id }}</td>
                                <td class="py-2 px-3">{{ number_format($withdraw->amount, 2) }}</td>
                                <td class="py-2 px-3">
                                    <span class="px-2 py-1 text-xs rounded
                                    {{ $withdraw->status == 'approved' ? 'bg-green-100 text-green-700' : ($withdraw->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($withdraw->status) }}
                                    </span>
                                </td>
                                <td class="py-2 px-3">{{ $withdraw->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>

@endsection
