@extends('layouts.master')
@section('content')
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <h3>University Evaluation</h3>
            <h4>Students with Company Evaluation Submitted</h4>
            <ul class="list-group mb-3">
                @forelse($students as $student)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $student->name }}
                        <a href="{{ route('evaluation.advisor.index', ['student_id' => $student->id]) }}" class="btn btn-sm btn-primary">Add/Edit University Evaluation</a>
                    </li>
                @empty
                    <li class="list-group-item">No students have submitted company evaluations yet.</li>
                @endforelse
            </ul>

            @if($evaluation)
            <form action="{{ route('evaluation.advisor.store') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{ $selectedStudentId }}">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Performance Factor</th>
                            <th>Score (1-100)</th>
                            <th>Weight</th>
                            <th>Score x Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Job Knowledge</td>
                            <td><input type="number" name="job_knowledge" value="{{ old('job_knowledge', $evaluation->job_knowledge) }}" min="0" max="100" required></td>
                            <td>10%</td>
                            <td>{{ number_format(($evaluation->job_knowledge ?? 0) * 0.10, 2) }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Analysis</td>
                            <td><input type="number" name="analysis" value="{{ old('analysis', $evaluation->analysis) }}" min="0" max="100" required></td>
                            <td>10%</td>
                            <td>{{ number_format(($evaluation->analysis ?? 0) * 0.10, 2) }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Report and Presentation</td>
                            <td><input type="number" name="report_presentation" value="{{ old('report_presentation', $evaluation->report_presentation) }}" min="0" max="100" required></td>
                            <td>20%</td>
                            <td>{{ number_format(($evaluation->report_presentation ?? 0) * 0.20, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total Score</strong></td>
                            <td><strong>{{ number_format($evaluation->total_score ?? 0, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Save Evaluation</button>
            </form>
            @endif
        </div>
    </div>
@endsection
