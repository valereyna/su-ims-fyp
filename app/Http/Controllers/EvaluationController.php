<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PDF;

class EvaluationController extends Controller
{
    // Advisor view: list evaluations and add/edit university evaluation
    public function advisorIndex(Request $request)
    {
        // Get students who have submitted company evaluation (non-null company evaluation fields)
        $evaluatedStudentIds = Evaluation::whereNotNull('enthusiasm_attitude')
            ->orWhereNotNull('work_quality')
            ->orWhereNotNull('timeliness')
            ->orWhereNotNull('company_job_knowledge')
            ->orWhereNotNull('decision_making')
            ->orWhereNotNull('reporting_communication')
            ->pluck('student_id')
            ->unique();

        $students = User::whereIn('id', $evaluatedStudentIds)->get();

        $selectedStudentId = $request->input('student_id');
        $evaluation = null;

        if ($selectedStudentId) {
            $evaluation = Evaluation::firstOrNew(['student_id' => $selectedStudentId]);
        }

        return view('evaluation.advisor_index', compact('students', 'evaluation', 'selectedStudentId'));
    }

    // Advisor store/update university evaluation
    public function advisorStore(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'job_knowledge' => 'required|integer|between:0,100',
            'analysis' => 'required|integer|between:0,100',
            'report_presentation' => 'required|integer|between:0,100',
        ]);

        $evaluation = Evaluation::firstOrNew(['student_id' => $request->student_id]);
        $evaluation->advisor_id = Auth::id();

        $evaluation->job_knowledge = $request->job_knowledge;
        $evaluation->analysis = $request->analysis;
        $evaluation->report_presentation = $request->report_presentation;

        // Calculate university weighted score as sum of score times weight (no extra 40% multiplication)
        $evaluation->university_weighted_score = (
            ($evaluation->job_knowledge ?? 0) * 0.10 +
            ($evaluation->analysis ?? 0) * 0.10 +
            ($evaluation->report_presentation ?? 0) * 0.20
        );

        // Calculate total score as sum of university and company weighted scores
        $evaluation->total_score = ($evaluation->university_weighted_score ?? 0) + ($evaluation->company_weighted_score ?? 0);

        $evaluation->save();

        return redirect()->route('evaluation.advisor.index')->with('success', 'University evaluation saved successfully.');
    }

    // Student view: fill company evaluation and view combined evaluation
    public function studentIndex()
    {
        $studentId = Auth::id();
        $evaluation = Evaluation::firstOrNew(['student_id' => $studentId]);

        return view('evaluation.student_index', compact('evaluation'));
    }

    // Student store/update company evaluation
    public function studentStore(Request $request)
    {
        $request->validate([
            'enthusiasm_attitude' => 'required|integer|between:0,100',
            'work_quality' => 'required|integer|between:0,100',
            'timeliness' => 'required|integer|between:0,100',
            'company_job_knowledge' => 'required|integer|between:0,100',
            'decision_making' => 'required|integer|between:0,100',
            'reporting_communication' => 'required|integer|between:0,100',
        ]);

        $studentId = Auth::id();
        $evaluation = Evaluation::firstOrNew(['student_id' => $studentId]);

        $evaluation->enthusiasm_attitude = $request->enthusiasm_attitude;
        $evaluation->work_quality = $request->work_quality;
        $evaluation->timeliness = $request->timeliness;
        $evaluation->company_job_knowledge = $request->company_job_knowledge;
        $evaluation->decision_making = $request->decision_making;
        $evaluation->reporting_communication = $request->reporting_communication;

        // Calculate company weighted score as sum of score times weight (no extra 60% multiplication)
        $evaluation->company_weighted_score = (
            ($evaluation->enthusiasm_attitude ?? 0) * 0.10 +
            ($evaluation->work_quality ?? 0) * 0.10 +
            ($evaluation->timeliness ?? 0) * 0.10 +
            ($evaluation->company_job_knowledge ?? 0) * 0.10 +
            ($evaluation->decision_making ?? 0) * 0.10 +
            ($evaluation->reporting_communication ?? 0) * 0.10
        );

        // Calculate total score as sum of university and company weighted scores
        $evaluation->total_score = ($evaluation->university_weighted_score ?? 0) + ($evaluation->company_weighted_score ?? 0);

        $evaluation->save();

        return redirect()->route('evaluation.student.index')->with('success', 'Company evaluation saved successfully.');
    }

    // Student view: generate PDF of complete evaluation
    public function generatePdf()
    {
        $studentId = Auth::id();
        $evaluation = Evaluation::with('student', 'advisor')->where('student_id', $studentId)->firstOrFail();

        $pdf = PDF::loadView('evaluation.pdf', compact('evaluation'));

        return $pdf->download('evaluation_' . $evaluation->student->name . '.pdf');
    }
}
