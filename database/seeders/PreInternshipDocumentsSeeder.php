<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PreInternshipDocumentsSeeder extends Seeder
{
    public function run()
    {
        $students = User::where('role_name', 'student')->get();

        foreach ($students as $student) {
            DB::table('pre_internship_documents')->insert([
                [
                    'student_id' => $student->id,
                    'document_name' => 'Internship Guidelines',
                    'document_path' => 'documents/internship_guidelines.pdf',
                    'status' => 'approved',
                    'approved_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'student_id' => $student->id,
                    'document_name' => 'Internship Registration Form',
                    'document_path' => 'documents/registration_form.docx',
                    'status' => 'approved',
                    'approved_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'student_id' => $student->id,
                    'document_name' => 'Report Template',
                    'document_path' => 'documents/report_template.docx',
                    'status' => 'approved',
                    'approved_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'student_id' => $student->id,
                    'document_name' => 'Internship Proposal Template',
                    'document_path' => 'documents/proposal_template.docx',
                    'status' => 'approved',
                    'approved_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
