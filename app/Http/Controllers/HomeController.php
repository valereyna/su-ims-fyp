<?php

namespace App\Http\Controllers;

use App\Models\LogbookActivity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    /** home dashboard */
    public function index()
    {
        $user =  Auth::user();
        $usersTotal = User::count();
        $studentCount = User::where('role_name', 'student')->count();
        $advisorCount = User::where('role_name', 'advisor')->count();

        return view('dashboard.admin', compact('usersTotal', 'studentCount', 'advisorCount'));
    }

    /** profile user */
    public function userProfile()
    {
        return view('dashboard.profile');
    }

    /** teacher dashboard */
    public function teacherDashboardIndex()
    {
        // Count of pending internship registrations (submitted but not approved)
        $pendingRegistrationsCount = \App\Models\InternshipRegistration::where('status', 'pending')->count();

        // Fetch list of students with their company names for advisor dashboard
        $studentsWithCompanies = \App\Models\InternshipRegistration::with('student')
        ->select('student_id', 'company_name')
        ->where('status', '!=', 'rejected') // optionally filter out rejected
        ->get();

        // Count of consultations not approved
        $advisorCount = \App\Models\Consultation::where('status', '!=', 'approved')->count();

        // Other counts can be fetched here as needed
        $studentCount = 0; // Placeholder, update as needed
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

    /** student dashboard */
    public function studentDashboardIndex()
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

        $consultationCount = \App\Models\Consultation::where('student_id', $studentId)->count();

        return view('dashboard.student_dashboard', compact('studentCount', 'registrationStatus', 'logbookCount', 'consultationCount'));
    }
}
