@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <h3 class="mb-4">Consultations for Approval</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card card-table comman-shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-center mb-0" id="ConsultationsList">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
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
                                <td>{{ $consultation->student->name ?? 'N/A' }}</td>
                                <td>{{ Str::limit($consultation->progress_report, 50) }}</td>
                                <td>{{ Str::limit($consultation->notes, 50) }}</td>
                                <td>{{ ucfirst($consultation->status) }}</td>
                                <td class="text-end">
                                    @if($consultation->status === 'pending')
                                    <form action="{{ route('advisor.consultations.approve', $consultation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    @else
                                    <span class="badge bg-success">Approved</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No consultations found.</td>
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
