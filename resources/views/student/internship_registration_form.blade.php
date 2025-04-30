@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <h3 class="page-title">Internship Registration</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($registration)
            <div class="card p-4 mb-3">
                <h5>Submitted Registration Information</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Student Campus ID</th>
                        <td>{{ $registration->student_campus_id }}</td>
                    </tr>
                    <tr>
                        <th>Company Name</th>
                        <td>{{ $registration->company_name }}</td>
                    </tr>
                    <tr>
                        <th>Company Address</th>
                        <td>{{ $registration->company_address }}</td>
                    </tr>
                    <tr>
                        <th>Internship Position</th>
                        <td>{{ $registration->internship_position }}</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ $registration->start_date }}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{ $registration->end_date }}</td>
                    </tr>
                    <tr>
                        <th>Additional Notes</th>
                        <td>{{ $registration->additional_notes }}</td>
                    </tr>
                </table>
                <a href="{{ route('internship.registration.pdf', $registration->id) }}" class="btn btn-primary" target="_blank">Generate PDF</a>
            </div>
        @else
            <div class="card p-4">
                <form action="{{ route('internship.registration.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="student_campus_id">Student Campus ID</label>
                        <input type="text" name="student_campus_id" id="student_campus_id" class="form-control @error('student_campus_id') is-invalid @enderror" value="{{ old('student_campus_id') }}" required>
                        @error('student_campus_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="company_address">Company Address</label>
                        <textarea name="company_address" id="company_address" class="form-control @error('company_address') is-invalid @enderror" rows="3" required>{{ old('company_address') }}</textarea>
                        @error('company_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="internship_position">Internship Position</label>
                        <input type="text" name="internship_position" id="internship_position" class="form-control @error('internship_position') is-invalid @enderror" value="{{ old('internship_position') }}" required>
                        @error('internship_position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="additional_notes">Additional Notes</label>
                        <textarea name="additional_notes" id="additional_notes" class="form-control @error('additional_notes') is-invalid @enderror" rows="3">{{ old('additional_notes') }}</textarea>
                        @error('additional_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Registration</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
