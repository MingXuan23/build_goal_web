<?php

use App\Http\Controllers\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\ContentController;
=======
use App\Http\Controllers\UserManagementController;
>>>>>>> ac61ac34ab3fb8d2bb16c43bd7663dd60d5c5124
use Illuminate\Support\Facades\Route;

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

<<<<<<< HEAD


// Route::get('/admin/content', function () {
//     return view('admin.contentManagement.index');
// });


// Route::get('/admin/promote-content', function () {
//     return view('admin.contentManagement.promoteContent');
// });


Route::get('/organization/dashboard', function () {
    return view('organization.dashboard.index');
});

Route::get('/organization/promote-content', function () {
    return view('organization.contentManagement.promoteContent');
});

Route::get('/content-creator/dashboard', function () {
    return view('contentcreator.dashboard.index');
});


Route::get('/staff/dashboard', function () {
    return view('staff.dashboard.index');
});
// Route::get('/admin/test', function () {
//     return view('admin.dashboard.indexTemplate');
// }); test 




// Load the states list
$states_list = include base_path('routes/state_list.php');

Route::get('organization/promote-content', function () use ($states_list) {
    return view('organization.contentManagement.promoteContent', compact('states_list'));
});




Route::get('organization/promote-content/{id}', [ContentController::class, 'showPromoteContent'])->name('promotecontent');
=======
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> ac61ac34ab3fb8d2bb16c43bd7663dd60d5c5124
