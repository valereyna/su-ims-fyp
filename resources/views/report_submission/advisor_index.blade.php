@extends('layouts.master')
@section('content')
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <h3>Report Submissions</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Internship Report</th>
                        <th>Internship PPT</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr>
                            <td>{{ $submission->student->name ?? 'N/A' }}</td>
                            <td>
                                @if($submission->internship_report)
                                    <a href="{{ route('report_submission.advisor.view', ['id' => $submission->id, 'type' => 'internship_report']) }}" target="_blank">See Report</a>
                                    <br>
                                    <iframe src="{{ route('report_submission.advisor.view', ['id' => $submission->id, 'type' => 'internship_report']) }}" width="200" height="150"></iframe>
                                @else
                                    No file uploaded
                                @endif
                            </td>
                            <td>
                                @if($submission->internship_ppt)
                                    <a href="{{ route('report_submission.advisor.view', ['id' => $submission->id, 'type' => 'internship_ppt']) }}" target="_blank">See Report</a>
                                    <br>
                                    <iframe src="{{ route('report_submission.advisor.view', ['id' => $submission->id, 'type' => 'internship_ppt']) }}" width="200" height="150"></iframe>
                                @else
                                    No file uploaded
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('report_submission.download', ['id' => $submission->id, 'type' => 'internship_report']) }}" class="btn btn-primary btn-sm" target="_blank">Download Report</a>
                                <a href="{{ route('report_submission.download', ['id' => $submission->id, 'type' => 'internship_ppt']) }}" class="btn btn-primary btn-sm" target="_blank">Download PPT</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No submissions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
