@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Edit Partner</h1>
    <form method="POST" action="{{ route('partners.update', $partner->id) }}">@csrf @method('PUT')
        <div><label>Name</label><input name="name" value="{{ $partner->name }}" required></div>
        <div><label>Share %</label><input name="share_percentage" value="{{ $partner->share_percentage }}"></div>
        <div><label>Invested</label><input name="invested_amount" value="{{ $partner->invested_amount }}"></div>
        <button class="btn btn-primary mt-2">Update</button>
    </form>
</div>
@endsection