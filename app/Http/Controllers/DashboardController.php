<?php

namespace App\Http\Controllers;
use App\Models\LogbookActivity;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        return view('dashboard.admin');
    }
    
    public function coordinatorDashboard()
    {
        return view('dashboard.coordinator');
    }
    
    public function advisorDashboard()
    {
        // Count of pending internship registrations (submitted but not approved)
        $pendingRegistrationsCount = \App\Models\InternshipRegistration::where('status', 'pending')->count();

        // Fetch list of students with their company names for advisor dashboard
        $studentsWithCompanies = \App\Models\InternshipRegistration::with('student')
        ->select('student_id', 'company_name')
        ->where('status', '!=', 'rejected') // optionally filter out rejected
        ->get();

        // Other counts can be fetched here as needed
        $studentCount = 0; // Placeholder, update as needed
        $advisorCount = 0; // Placeholder, update as needed
        $coordinatorCount = 0; // Placeholder, update as needed
        $totalUsers = 0; // Placeholder, update as needed

        return view('dashboard.teacher_dashboard', compact(
            'pendingRegistrationsCount',
            'studentsWithCompanies',
            'studentCount',
            'advisorCount',
            'coordinatorCount',
            'totalUsers'
        ));
    }
    
    public function studentDashboard()
    {
        $studentId = auth()->id();
        $registration = \App\Models\InternshipRegistration::where('student_id', $studentId)->first();

        if (!$registration) {
            $studentCount = 1; // Not registered yet
            $registrationStatus = null;
        } else {
            $studentCount = 0; // Registered
            $registrationStatus = $registration->status;
        }

        $logbookCount = LogbookActivity::where('student_id', $studentId)->count();

        return view('dashboard.student_dashboard', compact('studentCount', 'registrationStatus', 'logbookCount'));
    }
}