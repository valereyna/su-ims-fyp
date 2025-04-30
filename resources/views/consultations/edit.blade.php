@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <h3 class="mb-4">Edit Consultation</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('consultations.update', $consultation->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="date" class="form-label">Consultation Date</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ old('date', \Carbon\Carbon::parse($consultation->date)->format('Y-m-d')) }}" required>
            </div>
            <div class="mb-3">
                <label for="progress_report" class="form-label">Progress Report</label>
                <textarea id="progress_report" name="progress_report" class="form-control" rows="4" required>{{ old('progress_report', $consultation->progress_report) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea id="notes" name="notes" class="form-control" rows="3">{{ old('notes', $consultation->notes) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Consultation</button>
            <a href="{{ route('consultations.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
