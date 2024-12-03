<?php

use App\Http\Controllers\AdminRouteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContentCreatorRouteController;
use App\Http\Controllers\OrganizationRouteController;
use App\Http\Controllers\StaffRouteController;
use App\Http\Controllers\UserProfileController;
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

    Route::get('/dashboard', [AdminRouteController::class, 'showDashboard'])->name('showDashboardAdmin');
    Route::get('/user', [AdminRouteController::class, 'showUser'])->name('showUserAdmin');
    Route::get('/add-user', [AdminRouteController::class, 'showAddUser'])->name('showAddUser');
    Route::get('/view-content', [AdminRouteController::class, 'showContentAdmin'])->name('showContentAdmin');
    Route::get('/profile',  [AdminRouteController::class, 'showProfile'])->name('showProfileAdmin');

    Route::post('/approve-content/{id}', [ContentController::class, 'approveContent'])->name('approveContent');
    Route::post('/reject-content/{id}', [ContentController::class, 'rejectContent'])->name('rejectContent');
    Route::post('/update-user/{id}', [UserManagementController::class, 'updateUser'])->name('updateUser');
    Route::post('/update-role/{id}', [UserManagementController::class, 'updateRole'])->name('updateRole');
    Route::post('/update-ekyc-status/{id}', [UserManagementController::class, 'updateEkycStatus'])->name('updateEkycStatus');
    Route::post('/update-email-status/{id}', [UserManagementController::class, 'updateEmailStatus'])->name('updateEmailStatus');
    Route::post('/update-account-status/{id}', [UserManagementController::class, 'updateAccountStatus'])->name('updateAccountStatus');
    Route::post('/profile/update-personal-detail', [UserProfileController::class, 'updateProfilePersonalDetailAdmin'])->name('updateProfilePersonalDetailAdmin');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePasswordAdmin'])->name('updatePasswordAdmin');
    



    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('admin.logout');
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::prefix('staff')->middleware(['auth', 'role:2'])->group(function () {

    Route::get('/dashboard', [StaffRouteController::class, 'showDashboard'])->name('showDashboardStaff');
    Route::get('/profile',  [StaffRouteController::class, 'showProfile'])->name('showProfileStaff');

    Route::post('/profile/update-personal-detail', [UserProfileController::class, 'updateProfilePersonalDetailStaff'])->name('updateProfilePersonalDetailStaff');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePasswordStaff'])->name('updatePasswordStaff');

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('staff.logout');
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::prefix('organization')->middleware(['auth', 'role:3'])->group(function () {
    Route::get('/dashboard', [OrganizationRouteController::class, 'showDashboard'])->name('showDashboardOrganization');
    Route::get('/profile', [OrganizationRouteController::class, 'showProfile'])->name('showProfileOrganization');

    // Route::middleware(['ekycCheck'])->group(function () {
    Route::get('/content-management', [OrganizationRouteController::class, 'showContent'])->name('showContent');
    Route::get('/apply-content', [OrganizationRouteController::class, 'showAddContent'])->name('showAddContent');

    Route::post('/apply-content', [ContentController::class, 'addContent'])->name('addContent');
    Route::post('/profile/update-personal-detail', [UserProfileController::class, 'updateProfilePersonalDetailOrganization'])->name('updateProfilePersonalDetailOrganization');
    Route::post('/profile/update-organization-Detail', [UserProfileController::class, 'updateProfileOrganizationDetail'])->name('updateProfileOrganizationDetail');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePasswordOrganization'])->name('updatePasswordOrganization');
    // });

    // Route::get('/promote-content', function () use ($states_list) {
    //     return view('organization.contentManagement.promoteContent', compact('states_list'));
    // });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('organization.logout');
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::prefix('content-creator')->middleware(['auth', 'role:4'])->group(function () {
    Route::get('/dashboard', [ContentCreatorRouteController::class, 'showDashboard'])->name('showDashboardContentCreator');
    Route::get('/profile', [ContentCreatorRouteController::class, 'showProfile'])->name('showProfileContentCreator');

    Route::post('/profile/update-personal-detail', [UserProfileController::class, 'updateProfilePersonalDetailContentCreator'])->name('updateProfilePersonalDetailContentCreator');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePasswordContentCreator'])->name('updatePasswordContentCreator');

    // Route::middleware(['ekycCheck'])->group(function () {

    // });


    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('content-creator.logout');
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
