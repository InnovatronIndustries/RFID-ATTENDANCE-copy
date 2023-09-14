<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UIDController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('index');
});

Route::get('/admin',function(){
    return view('home');
});
// Route for verifying UID
Route::post('/check-uid', [UIDController::class, 'checkUID']);

// Route for login 
Route::post('/login', [LogInController::class, 'login'])->name('login');

// Route to get the login time
Route::get('/get-login-time', [LogInController::class, 'getLoginTime']);

// Route for logout
Route::get('/logout', [LogOutController::class, 'logout'])->name('logout');

// Route to get the logout time
Route::get('/get-logout-time', [LogInController::class, 'getLogOutTime']);

// Route to check logout condition
Route::get('/check-logout-condition', [LogOutController::class, 'checkLogoutCondition']);

Route::post('/logout', 'App\Http\Controllers\LogOutController@logout');

// Route for Sms
Route::get('/send-sms', [SmsController::class, 'sendSms']);

// Route for adding employee 
Route::post('/add-employee',[AdminController::class,'addEmployee']);

//Route for getting employee data
Route::get('/get-members',[AdminController::class,'getMembers']);

//Route for removing employee
Route::get('/remove-employee',[AdminController::class,'removeEmployee']);

//Route for removing students
Route::get('/remove-student',[AdminController::class,'removeStudent']);

Route::group(['middleware' => ['web']], function () {
    // Your routes here
});
