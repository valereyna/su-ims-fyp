<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // For students: Pre Internship Documents menu
        $preInternshipStudentMenuId = DB::table('menus')->insertGetId([
            'title' => 'Pre Internship Documents',
            'icon'  => 'fas fa-file-download',
            'route' => 'preinternship.student',
            'active_routes' => json_encode(['pre-internship-documents/student']),
            'pattern'   => null,
            'parent_id' => null,
            'order'     => 10,
            'is_active' => true,
        ]);

        // For coordinators: Upload Documents menu
        $uploadDocumentsMenuId = DB::table('menus')->insertGetId([
            'title' => 'Upload Documents',
            'icon'  => 'fas fa-upload',
            'route' => 'preinternship.index',
            'active_routes' => json_encode(['pre-internship-documents']),
            'pattern'   => null,
            'parent_id' => null,
            'order'     => 11,
            'is_active' => true,
        ]);
    }
}
