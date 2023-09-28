<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    RfidController,
    SubdomainTestController,
    UIDController,
    LogInController,
    LogOutController,
    SmsController,
    AdminController
};

use App\Http\Controllers\CMS\{
    DashboardController,
    StudentMasterlistController,
    UploadStudentListController,
    UploadEmployeeListController,
    UploadAvatarImagesController,
    SchoolController,
    ReportOverviewController,
    Reports\AttendanceReportController
};

use App\Http\Controllers\Api\{
    Integrations\SmsIntegrationController
};

use App\Http\Controllers\DataTables\{
    UserDataTableController,
    StudentMasterlistDataTableController
};

Route::get('/', RfidController::class);

Route::get('/admin',function(){
    return view('home');
});
// Route for verifying UID
Route::post('/check-uid', [UIDController::class, 'checkUID']);

// Route for login
Route::post('/rfid-login', [LogInController::class, 'login'])->name('rfid.login');

// Route to get the login time
Route::get('/get-login-time/{uid}', [LogInController::class, 'getLoginTime']);

// Route to get the logout time
Route::get('/get-logout-time/{uid}', [LogOutController::class, 'getLogOutTime']);

// Route to check logout condition
Route::get('/check-logout-condition', [LogOutController::class, 'checkLogoutCondition']);

Route::get('/should-log-out', [LogOutController::class, 'shouldLogout']);

Route::post('/rfid-logout', 'App\Http\Controllers\LogOutController@logout')->name('rfid.logout');

// Route for Sms
Route::get('/send-sms', [SmsController::class, 'sendSms']);

// Route for adding employee 
Route::post('/add-employee',[AdminController::class,'addEmployee']);

//Route for getting employee and student data
Route::get('/get-members',[AdminController::class,'getMembers']);

//Route for removing employee
Route::post('/remove-employee',[AdminController::class,'removeEmployee']);

//Route for removing students
Route::post('/remove-student',[AdminController::class,'removeStudent']);

Route::post('/update-employee',[AdminController::class,'updateEmployee']);

Route::post('/update-student',[AdminController::class,'updateStudent']);

Route::group(['middleware' => ['web']], function () {
    // Your routes here
});

Auth::routes();

// check if subdomain is working - for testing purposes.
Route::domain('{school_name}.rfid-attendance.test')->group(function () {
    Route::resource('subdomain-test', SubdomainTestController::class)->only(['index']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('student-masterlist', StudentMasterlistController::class)->except(['show']);

    // file uploads
    Route::prefix('file-uploads')->group(function () {
        Route::resource('uploadStudentList', UploadStudentListController::class)->only(['index', 'store']);
        Route::resource('uploadEmployeeList', UploadEmployeeListController::class)->only(['index', 'store']);
        Route::resource('uploadAvatarImages', UploadAvatarImagesController::class)->only(['index', 'store']);
    });

    Route::resource('manage-schools', SchoolController::class)->except(['show']);
    
    // datatables
    Route::resource('user-dt', UserDataTableController::class)->only(['index']);
    Route::resource('student-masterlist-dt', StudentMasterlistDataTableController::class)->only(['index']);

    // reports
    Route::resource('reports-overview', ReportOverviewController::class)->only(['index']);

    Route::prefix('reports-overview')->group(function () {
        Route::resource('attendance-report', AttendanceReportController::class)->only(['index', 'show']);
    });
});

// webhooks
Route::get('sms-callback', [SmsIntegrationController::class, 'sendCallback']);