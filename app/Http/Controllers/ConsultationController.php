<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use PDF;

class ConsultationController extends Controller
{
    // Student: list consultations
    public function index()
    {
        $studentId = Auth::id();
        $consultations = Consultation::where('student_id', $studentId)
            ->orderBy('date', 'desc')
            ->get();

        return view('consultations.index', compact('consultations'));
    }

    // Student: show create form
    public function create()
    {
        return view('consultations.create');
    }

    // Student: store new consultation
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'progress_report' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $student = Auth::user();
        $internshipRegistration = \App\Models\InternshipRegistration::where('student_id', $student->id)->first();
        $advisorId = $internshipRegistration ? $internshipRegistration->advisor_id : null;

        Consultation::create([
            'student_id' => $student->id,
            'advisor_id' => $advisorId,
            'date' => $request->date,
            'progress_report' => $request->progress_report,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('consultations.index')->with('success', 'Consultation created successfully.');
    }

    // Student: show edit form
    public function edit($id)
    {
        $consultation = Consultation::findOrFail($id);
        $this->authorize('update', $consultation);

        return view('consultations.edit', compact('consultation'));
    }

    // Student: update consultation
    public function update(Request $request, $id)
    {
        $consultation = Consultation::findOrFail($id);
        $this->authorize('update', $consultation);

        $request->validate([
            'date' => 'required|date',
            'progress_report' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $consultation->update([
            'date' => $request->date,
            'progress_report' => $request->progress_report,
            'notes' => $request->notes,
        ]);

        return redirect()->route('consultations.index')->with('success', 'Consultation updated successfully.');
    }

    // Advisor: list consultations for approval
    public function advisorIndex()
    {
        $consultations = Consultation::with('student')->orderBy('date', 'desc')->get();

        return view('consultations.advisor_index', compact('consultations'));
    }

    // Advisor: approve consultation
    public function approve($id)
    {
        $consultation = Consultation::findOrFail($id);
        $user = auth()->user();

        //if ($user->cannot('approve', $consultation)) {
            //abort(403, 'Unauthorized action.');
        //}

        $consultation->status = 'approved';
        $consultation->save();

        return redirect()->back()->with('success', 'Consultation approved successfully.');
    }

    // Student: generate PDF of consultation
    public function generatePdf($id)
    {
        $consultation = Consultation::findOrFail($id);
        $this->authorize('view', $consultation);

        $student = $consultation->student;
        $advisor = $consultation->advisor;

        $pdf = PDF::loadView('consultations.pdf', [
            'consultation' => $consultation,
            'student' => $student,
            'advisor' => $advisor,
        ]);

        return $pdf->download('consultation_'.$consultation->id.'.pdf');
    }

    // Student: generate PDF of all consultations
    public function generateAllPdf()
    {
        $student = Auth::user();
        $consultations = Consultation::where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->get();

        $advisor = $student->advisor; // Assuming relation exists

        $pdf = PDF::loadView('consultations.all_pdf', [
            'consultations' => $consultations,
            'student' => $student,
            'advisor' => $advisor,
        ]);

        return $pdf->download('all_consultations_'.$student->id.'.pdf');
    }
}
