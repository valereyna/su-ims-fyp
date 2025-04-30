<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All Consultations PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 4px 0;
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
        .signature-name {
            margin-top: 10px;
            font-weight: bold;
        }
        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #333;
            width: 80%;
        }
    </style>
</head>
<body>
    <h2>Internship Consultation Report</h2>

    <div class="info">
        <p><strong>Student's Name:</strong> {{ $student->name }}</p>
        <p><strong>Advisor:</strong> {{ $advisor ? $advisor->name : 'N/A' }}</p>
        <p><strong>Study Program and Cohort:</strong> {{ $student->study_program ?? 'N/A' }} - {{ $student->cohort ?? 'N/A' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Progress Report</th>
                <th>Notes</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultations as $consultation)
            <tr>
                <td>{{ \Carbon\Carbon::parse($consultation->date)->format('Y-m-d') }}</td>
                <td>{{ $consultation->progress_report }}</td>
                <td>{{ $consultation->notes }}</td>
                <td>{{ ucfirst($consultation->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signatures">
        <div class="signature-block" style="text-align: left;">
            <p>Student Signature</p>
            <div class="signature-name">{{ $student->name }}</div>
            <div class="signature-line"></div>
        </div>
        <div class="signature-block" style="text-align: right;">
            <p>Advisor Signature</p>
            <div class="signature-name">{{ $advisor ? $advisor->name : '_________________________' }}</div>
            <div class="signature-line"></div>
        </div>
    </div>
</body>
</html>
