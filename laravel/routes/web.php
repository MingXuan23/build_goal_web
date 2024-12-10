<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MicrolearningController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/', function () {

    return view('welcome');
});

Route::get('/login', [AuthController::class, 'viewLogin'])->name('viewLogin');
Route::get('/verify-code', [AuthController::class, 'viewVerify'])->name('viewVerify');
Route::get('/resend-code', [AuthController::class, 'resendVerify'])->name('resendVerify');
Route::get('/organization-register', [AuthController::class, 'viewOrganizationRegister'])->name('viewOrganizationRegister');
Route::get('/content-creator-register', [AuthController::class, 'viewContentCreatorRegister'])->name('viewContentCreatorRegister');
Route::get('/reset-password', [AuthController::class, 'viewResetPassword'])->name('viewResetPassword');



Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/organization-register', [AuthController::class, 'createOrganizationRegister'])->name('createOrganizationRegister');
Route::post('/content-creator-register', [AuthController::class, 'createContentCreatorRegister'])->name('createContentCreatorRegister');
Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verifyCode');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::get('/resend-email-reset-password', [AuthController::class, 'resendResetPassword'])->name('resendResetPassword');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::prefix('admin')->middleware(['auth', 'role:1'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    });

    Route::get('/user', [UserManagementController::class, 'index'])->name('viewUser');
    Route::get('/add-user', [UserManagementController::class, 'viewAddUser'])->name('viewAddUser');
    Route::post('/update-user/{id}', [UserManagementController::class, 'updateUser'])->name('updateUser');
    Route::post('/update-role/{id}', [UserManagementController::class, 'updateRole'])->name('updateRole');
    Route::post('/update-ekyc-status/{id}', [UserManagementController::class, 'updateEkycStatus'])->name('updateEkycStatus');
    Route::post('/update-email-status/{id}', [UserManagementController::class, 'updateEmailStatus'])->name('updateEmailStatus');
    Route::post('/update-account-status/{id}', [UserManagementController::class, 'updateAccountStatus'])->name('updateAccountStatus');


    Route::get('/profile', function () {
        return view('admin.profile.index');
    });

    // Route::get('/content', function () {
    //     return view('admin.contentManagement.index');
    // });


    // Route::get('/promote-content', function () {
    //     return view('admin.contentManagement.promoteContent');
    // });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('admin.logout');
});

//Route::prefix('microlearning')->group(function () {
//    Route::get('/', [MicrolearningController::class, 'index'])->name('microlearning.index'); // List lessons
//    Route::get('/lesson/{id}', [MicrolearningController::class, 'lesson'])->name('microlearning.lesson'); // Show single lesson
//    Route::get('/quiz', [MicrolearningController::class, 'quiz'])->name('microlearning.quiz'); // Quiz page
//});



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::prefix('staff')->middleware(['auth', 'role:2'])->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard.index');
    });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('staff.logout');
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::prefix('content-creator')->middleware(['auth', 'role:4'])->group(function () {
    Route::get('/dashboard', function () {
        return view('contentcreator.dashboard.index');
    });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('content-creator.logout');
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::prefix('organization')->middleware(['auth', 'role:3'])->group(function () {
    Route::get('/dashboard', function () {
        return view('organization.dashboard.index');
    });

    // Load the states list
    $states_list = include base_path('routes/state_list.php');

    Route::get('organization/promote-content', function () use ($states_list) {
        return view('organization.contentManagement.promoteContent', compact('states_list'));
    });
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('organization.logout');
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/microlearning/upload', [MicrolearningController::class, 'upload']);
Route::get('/microlearning', [MicrolearningController::class, 'index']);
Route::get('/content/{id}', [MicrolearningController::class, 'show']);





