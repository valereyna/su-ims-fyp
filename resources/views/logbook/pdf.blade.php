<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logbook PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2, h3 {
            margin-bottom: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .signatures {
            width: 100%;
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature-block {
            width: 40%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #333;
            width: 80%;
        }
        .signature-name {
            margin-top: 10px;
            font-weight: bold;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .info-row p {
            width: 48%;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Logbook Activity</h2>
    </div>

    <div class="info">
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>Position:</strong>
            @if($internshipRegistration && $internshipRegistration->internship_position)
                {{ $internshipRegistration->internship_position }}
            @else
                N/A
            @endif
        </p>
        <p><strong>Internship Period:</strong> 
            @if($internshipRegistration && $internshipRegistration->start_date && $internshipRegistration->end_date)
                {{ \Carbon\Carbon::parse($internshipRegistration->start_date)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($internshipRegistration->end_date)->format('Y-m-d') }}
            @else
                N/A
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Date</th>
                <th>Duration (hours)</th>
                <th>Job Description</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $index => $activity)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($activity->date)->format('Y-m-d') }}</td>
                <td>{{ $activity->duration_hours }}</td>
                <td>{{ $activity->job_description }}</td>
                <td>{{ $activity->remarks }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signatures">
        <div style="width: 40%; text-align: left; display: flex; flex-direction: column; align-items: flex-start;">
            <p>Student Signature</p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <div style="margin-top: 10px; font-weight: bold;">{{ $student->name }}</div>
        </div>
        <div style="width: 40%; text-align: right; display: flex; flex-direction: column; align-items: flex-end;">
            <p>Supervisor Signature</p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <div style="margin-top: 10px; font-weight: bold;">_________________________</div>
        </div>
    </div>
</body>
</html>
