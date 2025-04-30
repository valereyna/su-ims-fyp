<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogbookActivity;
use Illuminate\Support\Facades\Auth;
use PDF;

class LogbookActivityController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();
        $activities = LogbookActivity::where('student_id', $studentId)
            ->orderBy('date', 'desc')
            ->get();

        return view('logbook.index', compact('activities'));
    }

    public function create()
    {
        return view('logbook.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'duration_hours' => 'required|numeric|min:0',
            'job_description' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        LogbookActivity::create([
            'student_id' => Auth::id(),
            'date' => $request->date,
            'duration_hours' => $request->duration_hours,
            'job_description' => $request->job_description,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('logbook.index')->with('success', 'Logbook activity added successfully.');
    }

    public function edit($id)
    {
        $activity = LogbookActivity::findOrFail($id);
        $this->authorize('update', $activity);

        return view('logbook.edit', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        $activity = LogbookActivity::findOrFail($id);
        $this->authorize('update', $activity);

        $request->validate([
            'date' => 'required|date',
            'duration_hours' => 'required|numeric|min:0',
            'job_description' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $activity->update([
            'date' => $request->date,
            'duration_hours' => $request->duration_hours,
            'job_description' => $request->job_description,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('logbook.index')->with('success', 'Logbook activity updated successfully.');
    }

    public function generatePdf()
    {
        $student = Auth::user();
        $activities = LogbookActivity::where('student_id', $student->id)
            ->orderBy('date')
            ->get();

        $internshipRegistration = $student->internshipRegistration()->first();

        $pdf = PDF::loadView('logbook.pdf', [
            'student' => $student,
            'activities' => $activities,
            'internshipRegistration' => $internshipRegistration,
        ]);

        return $pdf->download('logbook_'.$student->id.'.pdf');
    }
}
