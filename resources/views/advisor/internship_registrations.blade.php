@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Internship Registrations</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Internship Registrations</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12">
                {{-- Optional: Add buttons or filters here --}}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table comman-shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover table-center mb-0" id="InternshipRegistrationsList">
                                <thead class="student-thread">
                                    <tr>
                                        <th>Student Campus ID</th>
                                        <th>Student Name</th>
                                        <th>Company Name</th>
                                        <th>Position</th>
                                        <th>Period</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $registration)
                                    <tr>
                                        <td>{{ $registration->student_campus_id }}</td>
                                        <td>{{ $registration->student->name ?? 'N/A' }}</td>
                                        <td>{{ $registration->company_name }}</td>
                                        <td>{{ $registration->internship_position }}</td>
                                        <td>{{ $registration->start_date }} to {{ $registration->end_date }}</td>
                                        <td>{{ ucfirst($registration->status) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('internship.registration.pdf', $registration->id) }}" class="btn btn-sm btn-primary" target="_blank" title="Generate PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            @if($registration->status !== 'approved')
                                            <form action="{{ route('advisor.internship.registration.approve', $registration->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to approve this registration?')" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @else
                                            <span class="badge bg-success">Approved</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    $(document).ready(function() {
        $('#InternshipRegistrationsList').DataTable({
            processing: true,
            serverSide: false,
            ordering: true,
            searching: true,
            paging: true,
            lengthChange: true,
            pageLength: 10,
        });
    });
</script>
@endsection

@endsection
