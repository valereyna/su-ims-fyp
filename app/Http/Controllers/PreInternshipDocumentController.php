<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PreInternshipDocument;

class PreInternshipDocumentController extends Controller
{
    // Student view documents
    public function studentView()
    {
        $documents = PreInternshipDocument::all();
        return view('student.pre_internship_documents_student', compact('documents'));
    }

    // Coordinator view documents and upload form
    public function index()
    {
        $documents = PreInternshipDocument::all();
        return view('student.pre_internship_documents_coordinator', compact('documents'));
    }

    // Coordinator upload document
    public function upload(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $path = $request->file('file')->store('pre_internship_documents');

        PreInternshipDocument::create([
            'document_name' => $request->document_name,
            'document_path' => $path,
        ]);

        return redirect()->route('preinternship.index')->with('success', 'Document uploaded successfully.');
    }

    // Download document
    public function download($id)
    {
        $document = PreInternshipDocument::findOrFail($id);
        $filePath = public_path($document->document_path);
            
        if (file_exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $fileName = pathinfo($document->document_name, PATHINFO_FILENAME) . '.' . $extension;
            $mimeType = mime_content_type($filePath);
            return response()->download($filePath, $fileName, [
                'Content-Type' => $mimeType,
            ]);
        } else {
            abort(404, 'File not found.');
        }
    }    
}

