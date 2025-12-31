@extends('admin.partials.index')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Edit Guarantor</h2>
    <form method="POST" action="{{ route('loan_guarantors.update', $loanGuarantor->id) }}">@csrf @method('PUT')
        <div><label>Name</label><input name="name" value="{{ $loanGuarantor->name }}" required></div>
        <button class="btn btn-primary mt-2">Update</button>
    </form>
</div>
@endsection