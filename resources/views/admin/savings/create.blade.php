@extends('admin.partials.index')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Savings Account</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('savings.store') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="member_id">Member</label>
                                <select name="member_id" id="member_id"
                                    class="form-control @error('member_id') is-invalid @enderror" required>
                                    <option value="">Select Member</option>
                                    @foreach (\App\Models\Member::all() as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="interest_rate">Interest Rate (%)</label>
                                <input type="number" name="interest_rate" id="interest_rate"
                                    class="form-control @error('interest_rate') is-invalid @enderror"
                                    value="{{ old('interest_rate', 5) }}" step="0.01" min="0" max="100"
                                    required>
                                @error('interest_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create Account</button>
                                <a href="{{ route('savings.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
