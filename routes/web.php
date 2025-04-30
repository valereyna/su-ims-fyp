<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogbookActivityController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ReportSubmissionController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function()
{
    Route::get('/home', function () {
        $role = strtolower(session('role_name') ?? auth()->user()->role_name ?? '');

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            case 'advisor':
                return redirect()->route('advisor.dashboard');
            case 'coordinator':
                return redirect()->route('coordinator.dashboard');
            default:
                abort(403, 'Unauthorized');
        }
    })->name('home');

    Route::get('admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('student/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard');
    Route::get('advisor/dashboard', [DashboardController::class, 'advisorDashboard'])->name('advisor.dashboard');
    Route::get('coordinator/dashboard', [DashboardController::class, 'coordinatorDashboard'])->name('coordinator.dashboard');

    // Student view documents and download
    Route::get('/pre-internship-documents/student', [App\Http\Controllers\PreInternshipDocumentController::class, 'studentView'])->name('preinternship.student');
    Route::get('/pre-internship-documents/download/{id}', [App\Http\Controllers\PreInternshipDocumentController::class, 'download'])->name('preinternship.download');

    // Coordinator upload documents and list
    Route::get('/pre-internship-documents', [App\Http\Controllers\PreInternshipDocumentController::class, 'index'])->name('preinternship.index');
    Route::post('/pre-internship-documents/upload', [App\Http\Controllers\PreInternshipDocumentController::class, 'upload'])->name('preinternship.upload');

    // Change Avatar
    Route::post('/profile/update-avatar', [App\Http\Controllers\UserManagementController::class, 'updateAvatar'])->name('profile.update_avatar')->middleware('auth');
    
    // Edit information (profile page)
    Route::put('/profile/update', [App\Http\Controllers\UserManagementController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

    // Change Password
    Route::post('change/password', [App\Http\Controllers\ChangePasswordController::class, 'changePassword'])->name('change.password');

    // Student routes
    Route::get('/internship-registration', [App\Http\Controllers\InternshipRegistrationController::class, 'create'])->name('internship.registration.create');
    Route::post('/internship-registration', [App\Http\Controllers\InternshipRegistrationController::class, 'store'])->name('internship.registration.store');

    // Advisor routes
    Route::get('/advisor/internship-registrations', [App\Http\Controllers\InternshipRegistrationController::class, 'index'])->name('advisor.internship.registrations');
    Route::post('/advisor/internship-registrations/{id}/approve', [App\Http\Controllers\InternshipRegistrationController::class, 'approve'])->name('advisor.internship.registration.approve');

    // PDF generation for both student and advisor
    Route::get('/internship-registration/{id}/pdf', [App\Http\Controllers\InternshipRegistrationController::class, 'generatePdf'])->name('internship.registration.pdf');

    // Report Submission routes for students
    Route::get('/report-submission', [ReportSubmissionController::class, 'index'])->name('report_submission.index');
    Route::post('/report-submission', [ReportSubmissionController::class, 'store'])->name('report_submission.store');
    Route::get('/report-submission/download/{id}/{type}', [ReportSubmissionController::class, 'download'])->name('report_submission.download');
    Route::get('/report-submission/view/{id}/{type}', [ReportSubmissionController::class, 'viewFile'])->name('report_submission.view');

    // Report Submission routes for advisors
    Route::get('/advisor/report-submissions', [ReportSubmissionController::class, 'advisorIndex'])->name('report_submission.advisor.index');
    Route::get('/advisor/report-submissions/download/{id}/{type}', [ReportSubmissionController::class, 'download'])->name('report_submission.advisor.download');
    Route::get('/advisor/report-submissions/view/{id}/{type}', [ReportSubmissionController::class, 'viewFile'])->name('report_submission.advisor.view');

    // Evaluation routes
    Route::group(['middleware' => ['auth']], function () {
        // Advisor routes
        Route::get('/advisor/evaluation', [App\Http\Controllers\EvaluationController::class, 'advisorIndex'])->name('evaluation.advisor.index');
        Route::post('/advisor/evaluation', [App\Http\Controllers\EvaluationController::class, 'advisorStore'])->name('evaluation.advisor.store');

        // Student routes
        Route::get('/student/evaluation', [App\Http\Controllers\EvaluationController::class, 'studentIndex'])->name('evaluation.student.index');
        Route::post('/student/evaluation', [App\Http\Controllers\EvaluationController::class, 'studentStore'])->name('evaluation.student.store');
        Route::get('/student/evaluation/pdf', [App\Http\Controllers\EvaluationController::class, 'generatePdf'])->name('evaluation.student.pdf');
    });
});

Auth::routes();
Route::group(['namespace' => 'App\Http\Controllers\Auth'],function()
{
    // ----------------------------login ------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        //Route::post('change/password', 'changePassword')->name('change.password');
        //Route::post('change/password', 'changePassword')->name('change/password');
    });

    // ----------------------------- register -------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register','storeUser')->name('register');    
    });
});

Route::group(['namespace' => 'App\Http\Controllers'],function()
{
    // -------------------------- main dashboard ----------------------//
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->middleware('auth')->name('home');
        Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
        Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
        Route::get('student/dashboard', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');
    });

    /*----------------------------- user controller ---------------------
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('list/users', 'index')->middleware('auth')->name('list/users');
        Route::post('change/password', 'changePassword')->name('change/password');
        Route::get('view/user/edit/{id}', 'userView')->middleware('auth');
        Route::post('user/update', 'userUpdate')->name('user/update');
        Route::post('user/delete', 'userDelete')->name('user/delete');
        Route::get('get-users-data', 'getUsersData')->name('get-users-data'); 

    }); */

    // User Management Routes - Admin Only
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::controller(UserManagementController::class)->group(function () {
            Route::get('list/users', 'index')->name('list/users');
            Route::get('user/create/page', 'createUser')->name('user/create/page');
            Route::post('user/create/save', 'saveUser')->name('user/create/save');
            Route::get('view/user/edit/{id}', 'userView');
            Route::post('user/update', 'userUpdate')->name('user/update');
            Route::post('user/delete', 'userDelete')->name('user/delete');
            Route::get('get-users-data', 'getUsersData')->name('get-users-data');
        });
    });

    
    Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/logbook', [LogbookActivityController::class, 'index'])->name('logbook.index');
        Route::get('/logbook/create', [LogbookActivityController::class, 'create'])->name('logbook.create');
        Route::post('/logbook', [LogbookActivityController::class, 'store'])->name('logbook.store');
        Route::get('/logbook/{id}/edit', [LogbookActivityController::class, 'edit'])->name('logbook.edit');
        Route::put('/logbook/{id}', [LogbookActivityController::class, 'update'])->name('logbook.update');
        Route::get('/logbook/pdf', [LogbookActivityController::class, 'generatePdf'])->name('logbook.pdf');
        Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
        Route::get('/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
        Route::post('/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
        Route::get('/consultations/{id}/edit', [ConsultationController::class, 'edit'])->name('consultations.edit');
        Route::put('/consultations/{id}', [ConsultationController::class, 'update'])->name('consultations.update');
        Route::get('/consultations/{id}/pdf', [ConsultationController::class, 'generatePdf'])->name('consultations.pdf');
        Route::get('/consultations/pdf/all', [ConsultationController::class, 'generateAllPdf'])->name('consultations.generateAllPdf');
});

    // Advisor consultation routes
    Route::middleware(['auth', 'role:advisor'])->group(function () {
        Route::get('/advisor/consultations', [ConsultationController::class, 'advisorIndex'])->name('advisor.consultations.index');
        Route::post('/advisor/consultations/{id}/approve', [ConsultationController::class, 'approve'])->name('advisor.consultations.approve');
    });

    // Pre Internship Document Routes (Student)
    //Route::middleware(['auth'])->group(function () {
        //Route::controller(PreInternshipDocumentController::class)->group(function () {
        //    Route::get('/pre-internship-documents/student', 'studentView')->name('preinternship.student');
        //    Route::post('/pre-internship-documents/request', 'requestDocument')->name('preinternship.request');

        //});
    //});

    // Pre Internship Document Routes (Admin)
    //Route::middleware(['admin'])->group(function () {
      //  Route::controller(PreInternshipDocumentController::class)->group(function () {
        //    Route::get('/pre-internship-documents', 'index')->name('preinternship.index');
          //  Route::post('/pre-internship-documents/approve/{id}', 'approveUpload')->name('preinternship.approve');
        //});
    //});

    // ------------------------ setting -------------------------------//
    Route::controller(Setting::class)->group(function () {
        Route::get('setting/page', 'index')->middleware('auth')->name('setting/page');
    });

    // ------------------------ student -------------------------------//
    Route::controller(StudentController::class)->group(function () {
        Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
        Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid'); // grid student
        Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
        Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
        Route::get('student/edit/{id}', 'studentEdit'); // view for edit
        Route::post('student/update', 'studentUpdate')->name('student/update'); // update record student
        Route::post('student/delete', 'studentDelete')->name('student/delete'); // delete record student
        Route::get('student/profile/{id}', 'studentProfile')->middleware('auth'); // profile student
    });

    // ------------------------ teacher -------------------------------//
    Route::controller(TeacherController::class)->group(function () {
        Route::get('teacher/add/page', 'teacherAdd')->middleware('auth')->name('teacher/add/page'); // page teacher
        Route::get('teacher/list/page', 'teacherList')->middleware('auth')->name('teacher/list/page'); // page teacher
        Route::get('teacher/grid/page', 'teacherGrid')->middleware('auth')->name('teacher/grid/page'); // page grid teacher
        Route::post('teacher/save', 'saveRecord')->middleware('auth')->name('teacher/save'); // save record
        Route::get('teacher/edit/{user_id}', 'editRecord'); // view teacher record
        Route::post('teacher/update', 'updateRecordTeacher')->middleware('auth')->name('teacher/update'); // update record
        Route::post('teacher/delete', 'teacherDelete')->name('teacher/delete'); // delete record teacher
    });

    // ----------------------- department -----------------------------//
    Route::controller(DepartmentController::class)->group(function () {
        Route::get('department/list/page', 'departmentList')->middleware('auth')->name('department/list/page'); // department/list/page
        Route::get('department/add/page', 'indexDepartment')->middleware('auth')->name('department/add/page'); // page add department
        Route::get('department/edit/{department_id}', 'editDepartment'); // page add department
        Route::post('department/save', 'saveRecord')->middleware('auth')->name('department/save'); // department/save
        Route::post('department/update', 'updateRecord')->middleware('auth')->name('department/update'); // department/update
        Route::post('department/delete', 'deleteRecord')->middleware('auth')->name('department/delete'); // department/delete
        Route::get('get-data-list', 'getDataList')->name('get-data-list'); // get data list

    });

    // ----------------------- subject -----------------------------//
    Route::controller(SubjectController::class)->group(function () {
        Route::get('subject/list/page', 'subjectList')->middleware('auth')->name('subject/list/page'); // subject/list/page
        Route::get('subject/add/page', 'subjectAdd')->middleware('auth')->name('subject/add/page'); // subject/add/page
        Route::post('subject/save', 'saveRecord')->name('subject/save'); // subject/save
        Route::post('subject/update', 'updateRecord')->name('subject/update'); // subject/update
        Route::post('subject/delete', 'deleteRecord')->name('subject/delete'); // subject/delete
        Route::get('subject/edit/{subject_id}', 'subjectEdit'); // subject/edit/page
    });

    // ----------------------- invoice -----------------------------//
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('invoice/list/page', 'invoiceList')->middleware('auth')->name('invoice/list/page'); // subjeinvoicect/list/page
        Route::get('invoice/paid/page', 'invoicePaid')->middleware('auth')->name('invoice/paid/page'); // invoice/paid/page
        Route::get('invoice/overdue/page', 'invoiceOverdue')->middleware('auth')->name('invoice/overdue/page'); // invoice/overdue/page
        Route::get('invoice/draft/page', 'invoiceDraft')->middleware('auth')->name('invoice/draft/page'); // invoice/draft/page
        Route::get('invoice/recurring/page', 'invoiceRecurring')->middleware('auth')->name('invoice/recurring/page'); // invoice/recurring/page
        Route::get('invoice/cancelled/page', 'invoiceCancelled')->middleware('auth')->name('invoice/cancelled/page'); // invoice/cancelled/page
        Route::get('invoice/grid/page', 'invoiceGrid')->middleware('auth')->name('invoice/grid/page'); // invoice/grid/page
        Route::get('invoice/add/page', 'invoiceAdd')->middleware('auth')->name('invoice/add/page'); // invoice/add/page
        Route::post('invoice/add/save', 'saveRecord')->name('invoice/add/save'); // invoice/add/save
        Route::post('invoice/update/save', 'updateRecord')->name('invoice/update/save'); // invoice/update/save
        Route::post('invoice/delete', 'deleteRecord')->name('invoice/delete'); // invoice/delete
        Route::get('invoice/edit/{invoice_id}', 'invoiceEdit')->middleware('auth')->name('invoice/edit/page'); // invoice/edit/page
        Route::get('invoice/view/{invoice_id}', 'invoiceView')->middleware('auth')->name('invoice/view/page'); // invoice/view/page
        Route::get('invoice/settings/page', 'invoiceSettings')->middleware('auth')->name('invoice/settings/page'); // invoice/settings/page
        Route::get('invoice/settings/tax/page', 'invoiceSettingsTax')->middleware('auth')->name('invoice/settings/tax/page'); // invoice/settings/tax/page
        Route::get('invoice/settings/bank/page', 'invoiceSettingsBank')->middleware('auth')->name('invoice/settings/bank/page'); // invoice/settings/bank/page
    });

    // ----------------------- accounts ----------------------------//
    Route::controller(AccountsController::class)->group(function () {
        Route::get('account/fees/collections/page', 'index')->middleware('auth')->name('account/fees/collections/page'); // account/fees/collections/page
        Route::get('add/fees/collection/page', 'addFeesCollection')->middleware('auth')->name('add/fees/collection/page'); // add/fees/collection
        Route::post('fees/collection/save', 'saveRecord')->middleware('auth')->name('fees/collection/save'); // fees/collection/save
    }); 
});