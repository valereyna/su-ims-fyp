@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <h3 class="mb-4">New Logbook Activity</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('logbook.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
            </div>
            <div class="mb-3">
                <label for="duration_hours" class="form-label">Duration (hours)</label>
                <input type="number" step="0.01" name="duration_hours" id="duration_hours" class="form-control" value="{{ old('duration_hours') }}" required>
            </div>
            <div class="mb-3">
                <label for="job_description" class="form-label">Job Description</label>
                <textarea name="job_description" id="job_description" class="form-control" rows="4" required>{{ old('job_description') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control" rows="3">{{ old('remarks') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Activity</button>
            <a href="{{ route('logbook.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
