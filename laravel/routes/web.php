<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {

    return view('welcome');
});

Route::get('/login', [AuthController::class,'viewLogin'])->name('viewLogin');
Route::get('/register',[AuthController::class,'viewRegister'])->name('viewRegister');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/register',[AuthController::class,'register'])->name('register');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard.index');
});

Route::get('/admin/user', function () {
    return view('admin.userManagement.index');
});

Route::get('/admin/add-user', function () {
    return view('admin.userManagement.addUser');
});

Route::get('/admin/profile', function () {
    return view('admin.profile.index');
});



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