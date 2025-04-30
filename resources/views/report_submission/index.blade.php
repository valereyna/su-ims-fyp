@extends('layouts.master')
@section('content')
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <h3>Report Submission</h3>
            <form action="{{ route('report_submission.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th>Upload</th>
                            <th>Current File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Internship Report (PDF, DOC, DOCX)</td>
                            <td><input type="file" name="internship_report" accept=".pdf,.doc,.docx"></td>
                            <td>
                                @if($submission && $submission->internship_report)
                                    <a href="{{ route('report_submission.view', ['id' => $submission->id, 'type' => 'internship_report']) }}" target="_blank">View</a>
                                @else
                                    No file uploaded
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Internship PPT (PDF, PPT, PPTX)</td>
                            <td><input type="file" name="internship_ppt" accept=".pdf,.ppt,.pptx"></td>
                            <td>
                                @if($submission && $submission->internship_ppt)
                                    <a href="{{ route('report_submission.view', ['id' => $submission->id, 'type' => 'internship_ppt']) }}" target="_blank">View</a>
                                @else
                                    No file uploaded
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
@endsection
