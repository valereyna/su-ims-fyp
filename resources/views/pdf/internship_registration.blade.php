<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Internship Registration</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background-color: #f2f2f2; }
        .signature { margin-top: 50px; }
        .signature div { display: inline-block; width: 45%; text-align: center; }
        .signature-line { border-top: 1px solid #000; margin-top: 60px; }
    </style>
</head>
<body>
    <h2>Internship Registration Form</h2>
    <table>
        <tr>
            <th>Student Campus ID</th>
            <td>{{ $registration->student_campus_id }}</td>
        </tr>
        <tr>
            <th>Student Name</th>
            <td>{{ $registration->student->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Company Name</th>
            <td>{{ $registration->company_name }}</td>
        </tr>
        <tr>
            <th>Company Address</th>
            <td>{{ $registration->company_address }}</td>
        </tr>
        <tr>
            <th>Internship Position</th>
            <td>{{ $registration->internship_position }}</td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td>{{ $registration->start_date }}</td>
        </tr>
        <tr>
            <th>End Date</th>
            <td>{{ $registration->end_date }}</td>
        </tr>
        <tr>
            <th>Additional Notes</th>
            <td>{{ $registration->additional_notes }}</td>
        </tr>
    </table>

    <div class="signature">
        <div>
            <p>Student Signature</p>
            <div class="signature-line"></div>
        </div>
        <div>
            <p>Advisor Signature</p>
            <div class="signature-line"></div>
        </div>
    </div>
</body>
</html>
