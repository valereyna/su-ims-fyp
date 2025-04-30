@extends('layouts.master')
@section('content')
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <h3>Company Evaluation</h3>
            <form action="{{ route('evaluation.student.store') }}" method="POST">
                @csrf
                <table class="table table-bordered">
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
                            <td>Enthusiasm and attitude</td>
                            <td><input type="number" name="enthusiasm_attitude" value="{{ old('enthusiasm_attitude', $evaluation->enthusiasm_attitude) }}" min="0" max="100" required></td>
                            <td>10%</td>
                            <td>{{ number_format(($evaluation->enthusiasm_attitude ?? 0) * 0.10, 2) }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Work quality</td>
                            <td><input type="number" name="work_quality" value="{{ old('work_quality', $evaluation->work_quality) }}" min="0" max="100" required></td>
                            <td>10%</td>
                            <td>{{ number_format(($evaluation->work_quality ?? 0) * 0.10, 2) }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Timeliness</td>
                            <td><input type="number" name="timeliness" value="{{ old('timeliness', $evaluation->timeliness) }}" min="0" max="100" required></td>
                            <td>10%</td>
                            <td>{{ number_format(($evaluation->timeliness ?? 0) * 0.10, 2) }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Job knowledge</td>
                            <td><input type="number" name="company_job_knowledge" value="{{ old('company_job_knowledge', $evaluation->company_job_knowledge) }}" min="0" max="100" required></td>
                            <td>10%</td>
                            <td>{{ number_format(($evaluation->company_job_knowledge ?? 0) * 0.10, 2) }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Decision making</td>
                            <td><input type="number" name="decision_making" value="{{ old('decision_making', $evaluation->decision_making) }}" min="0" max="100" required></td>
                            <td>10%</td>
                            <td>{{ number_format(($evaluation->decision_making ?? 0) * 0.10, 2) }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Reporting and communication</td>
                            <td><input type="number" name="reporting_communication" value="{{ old('reporting_communication', $evaluation->reporting_communication) }}" min="0" max="100" required></td>
                            <td>10%</td>
                            <td>{{ number_format(($evaluation->reporting_communication ?? 0) * 0.10, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total Score</strong></td>
                            <td><strong>{{ number_format($evaluation->total_score ?? 0, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Save Evaluation</button>
                @if($evaluation->total_score !== null)
                    <a href="{{ route('evaluation.student.pdf') }}" class="btn btn-success" target="_blank">Generate PDF</a>
                @endif
            </form>
        </div>
    </div>
@endsection
