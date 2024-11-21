<?php

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

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
   
    return view('auth.register');
});

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
    return view('organization.content.promoteContent');
});

// Route::get('/admin/test', function () {
//     return view('admin.dashboard.indexTemplate');
// });