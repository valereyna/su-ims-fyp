<!DOCTYPE html>
<html>
<head>
    <title>Evaluation Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, h3 { margin: 0; }
        .header { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Evaluation Report</h2>
        <p><strong>Student Name:</strong> {{ $evaluation->student->name ?? 'N/A' }}</p>
        <p><strong>Student Campus ID:</strong> {{ $evaluation->student->campus_id ?? 'N/A' }}</p>
    </div>

    <h3>University Evaluation</h3>
    <table>
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
                <td>{{ $evaluation->job_knowledge ?? 0 }}</td>
                <td>10%</td>
                <td>{{ number_format(($evaluation->job_knowledge ?? 0) * 0.10, 2) }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Analysis</td>
                <td>{{ $evaluation->analysis ?? 0 }}</td>
                <td>10%</td>
                <td>{{ number_format(($evaluation->analysis ?? 0) * 0.10, 2) }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Report and Presentation</td>
                <td>{{ $evaluation->report_presentation ?? 0 }}</td>
                <td>20%</td>
                <td>{{ number_format(($evaluation->report_presentation ?? 0) * 0.20, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total University Score</strong></td>
                <td><strong>{{ number_format($evaluation->university_weighted_score ?? 0, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <h3>Company Evaluation</h3>
    <table>
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
                <td>{{ $evaluation->enthusiasm_attitude ?? 0 }}</td>
                <td>10%</td>
                <td>{{ number_format(($evaluation->enthusiasm_attitude ?? 0) * 0.10, 2) }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Work quality</td>
                <td>{{ $evaluation->work_quality ?? 0 }}</td>
                <td>10%</td>
                <td>{{ number_format(($evaluation->work_quality ?? 0) * 0.10, 2) }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Timeliness</td>
                <td>{{ $evaluation->timeliness ?? 0 }}</td>
                <td>10%</td>
                <td>{{ number_format(($evaluation->timeliness ?? 0) * 0.10, 2) }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Job knowledge</td>
                <td>{{ $evaluation->company_job_knowledge ?? 0 }}</td>
                <td>10%</td>
                <td>{{ number_format(($evaluation->company_job_knowledge ?? 0) * 0.10, 2) }}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Decision making</td>
                <td>{{ $evaluation->decision_making ?? 0 }}</td>
                <td>10%</td>
                <td>{{ number_format(($evaluation->decision_making ?? 0) * 0.10, 2) }}</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Reporting and communication</td>
                <td>{{ $evaluation->reporting_communication ?? 0 }}</td>
                <td>10%</td>
                <td>{{ number_format(($evaluation->reporting_communication ?? 0) * 0.10, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total Company Score</strong></td>
                <td><strong>{{ number_format($evaluation->company_weighted_score ?? 0, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <h3>Total Score: {{ number_format($evaluation->total_score ?? 0, 2) }}</h3>
</body>
</html>
