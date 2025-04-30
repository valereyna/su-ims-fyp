<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternshipRegistration;
use Illuminate\Support\Facades\Auth;
use PDF; // Assuming barryvdh/laravel-dompdf is installed for PDF generation

class InternshipRegistrationController extends Controller
{
    // Show registration form to student or show submitted info
    public function create()
    {
        $registration = InternshipRegistration::where('student_id', Auth::id())->first();
        return view('student.internship_registration_form', compact('registration'));
    }

    // Store registration data
    public function store(Request $request)
    {
        $request->validate([
            'student_campus_id' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:500',
            'internship_position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'additional_notes' => 'nullable|string',
        ]);

        InternshipRegistration::updateOrCreate(
            ['student_id' => Auth::id()],
            [
                'student_campus_id' => $request->student_campus_id,
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'internship_position' => $request->internship_position,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'additional_notes' => $request->additional_notes,
                'status' => 'pending',
            ]
        );

        return redirect()->route('internship.registration.create')->with('success', 'Registration submitted successfully.');
    }

    // Advisor view all registrations
    public function index()
    {
        $registrations = InternshipRegistration::with('student')->get();
        return view('advisor.internship_registrations', compact('registrations'));
    }

    public function approve($id) {
        $registration = InternshipRegistration::findOrFail($id);
        $registration->status = 'approved';
        $registration->save();
        return redirect()->route('advisor.internship.registrations')->with('success', 'Registration approved successfully.');

    }

    // Generate PDF for student or advisor
    public function generatePdf($id)
    {
        $registration = InternshipRegistration::with('student', 'advisor')->findOrFail($id);

        $pdf = PDF::loadView('pdf.internship_registration', compact('registration'));
        return $pdf->download('internship_registration_' . $registration->id . '.pdf');
    }
}
