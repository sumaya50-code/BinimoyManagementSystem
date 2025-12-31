@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Add Partner</h1>
    <form method="POST" action="{{ route('partners.store') }}">@csrf
        <div><label>Name</label><input name="name" required></div>
        <div><label>Share %</label><input name="share_percentage"></div>
        <div><label>Invested Amount</label><input name="invested_amount"></div>
        <button type="submit">Save</button>
    </form>
</div>
@endsection