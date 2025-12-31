@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Add Cash Asset</h1>
    <form method="POST" action="{{ route('cash_assets.store') }}">@csrf
        <div><label>Type</label><select name="type"><option value="cash_in_hand">Cash in Hand</option><option value="bank">Bank</option></select></div>
        <div><label>Name</label><input name="name" required></div>
        <div><label>Balance</label><input name="balance" type="number" step="0.01"></div>
        <button type="submit">Save</button>
    </form>
</div>
@endsection