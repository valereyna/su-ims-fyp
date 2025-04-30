<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ReportSubmissionController extends Controller
{
    // Show upload form and list of uploaded documents for student
    public function index()
    {
        $studentId = Auth::id();
        $submission = ReportSubmission::where('student_id', $studentId)->first();

        return view('report_submission.index', compact('submission'));
    }

    // Handle upload of documents
    public function store(Request $request)
    {
        $request->validate([
            'internship_report' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'internship_ppt' => 'nullable|file|mimes:ppt,pptx,pdf|max:10240',
        ]);

        $studentId = Auth::id();
        $submission = ReportSubmission::firstOrNew(['student_id' => $studentId]);

        if ($request->hasFile('internship_report')) {
            if ($submission->internship_report) {
                Storage::disk('public')->delete($submission->internship_report);
            }
            $path = $request->file('internship_report')->store('reports', 'public');
            $submission->internship_report = $path;
        }

        if ($request->hasFile('internship_ppt')) {
            if ($submission->internship_ppt) {
                Storage::disk('public')->delete($submission->internship_ppt);
            }
            $path = $request->file('internship_ppt')->store('reports', 'public');
            $submission->internship_ppt = $path;
        }

        $submission->save();

        return redirect()->route('report_submission.index')->with('success', 'Documents uploaded successfully.');
    }

    // Advisor view all submissions
    public function advisorIndex()
    {
        $submissions = ReportSubmission::with('student')->get();

        return view('report_submission.advisor_index', compact('submissions'));
    }

    // Download document (forces download)
    public function download($id, $type)
    {
        $submission = ReportSubmission::findOrFail($id);

        if (!in_array($type, ['internship_report', 'internship_ppt'])) {
            abort(404);
        }

        $filePath = $submission->$type;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('public')->download($filePath);
    }

    // View document inline (for iframe or browser view)
    public function viewFile($id, $type)
    {
        $submission = ReportSubmission::findOrFail($id);

        if (!in_array($type, ['internship_report', 'internship_ppt'])) {
            abort(404);
        }

        $filePath = $submission->$type;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        $fileContent = Storage::disk('public')->get($filePath);
        $mimeType = Storage::disk('public')->mimeType($filePath);

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . basename($filePath) . '"');
    }
}
