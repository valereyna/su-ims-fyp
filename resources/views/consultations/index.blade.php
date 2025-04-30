@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <h3 class="mb-4">My Consultations</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('consultations.create') }}" class="btn btn-primary">New Consultation</a>
            <a href="{{ route('consultations.generateAllPdf') }}" class="btn btn-secondary" target="_blank">Generate PDF</a>
        </div>

        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-center mb-0" id="ConsultationsList">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Progress Report</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($consultations as $consultation)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($consultation->date)->format('Y-m-d') }}</td>
                                <td>{{ Str::limit($consultation->progress_report, 50) }}</td>
                                <td>{{ Str::limit($consultation->notes, 50) }}</td>
                                <td>{{ ucfirst($consultation->status) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('consultations.edit', $consultation->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No consultations found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    $(document).ready(function() {
        $('#ConsultationsList').DataTable({
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
