@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Edit Cash Asset</h1>
    <form method="POST" action="{{ route('cash_assets.update', $cashAsset->id) }}">@csrf @method('PUT')
        <div><label>Name</label><input name="name" value="{{ $cashAsset->name }}" required></div>
        <div><label>Type</label><select name="type"><option value="cash_in_hand" {{ $cashAsset->type=='cash_in_hand' ? 'selected':'' }}>Cash</option><option value="bank" {{ $cashAsset->type=='bank' ? 'selected':'' }}>Bank</option></select></div>
        <div><label>Balance</label><input name="balance" value="{{ $cashAsset->balance }}" type="number" step="0.01"></div>
        <button class="btn btn-primary mt-2">Update</button>
    </form>
</div>
@endsection