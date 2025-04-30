@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <h3 class="mb-4">Logbook Activity</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('logbook.create') }}" class="btn btn-primary">New Activity</a>
            <a href="{{ route('logbook.pdf') }}" class="btn btn-secondary">Generate PDF</a>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table comman-shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-center mb-0 align-middle" id="LogbookActivitiesList">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Duration (hours)</th>
                                        <th>Job Description</th>
                                        <th>Remarks</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activities as $index => $activity)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($activity->date)->format('Y-m-d') }}</td>
                                            <td>{{ $activity->duration_hours }}</td>
                                            <td>{{ $activity->job_description }}</td>
                                            <td>{{ $activity->remarks }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('logbook.edit', $activity->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No activities found.</td>
                                        </tr>
                                    @endforelse
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
        $('#LogbookActivitiesList').DataTable({
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
