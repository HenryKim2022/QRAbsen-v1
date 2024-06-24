<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landings\LandingController;
use App\Http\Controllers\UserPanels\UserPanelController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Absens\AbsenController;
use App\Http\Controllers\Employees\EmployeeController;
use App\Http\Controllers\OfficeRoles\OfficeRoleController;
use App\Http\Controllers\UserLogins\UserLoginController;
use App\Http\Controllers\MyProfiles\MyProfileController;

use App\Http\Middleware\Authenticate;
use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;

////////////////////////////////////////////////// END: IMPORTING MODULES /////////////////////////////////////////////////////////

Route::get('/', 'App\Http\Controllers\Landings\LandingController@index')->name('landing.page');

Route::prefix('')->name('login.')->middleware('guest')->group(function () {
    Route::get('/login', 'App\Http\Controllers\Auth\AuthController@showLogin')->name('page');
    Route::post('/login', 'App\Http\Controllers\Auth\AuthController@doLogin')->name('do');
});

Route::prefix('')->name('register.')->middleware('guest')->group(function () {
    Route::get('/register', 'App\Http\Controllers\Auth\AuthController@showRegister')->name('page');
    Route::post('/register', 'App\Http\Controllers\Auth\AuthController@doRegister')->name('do');
});

Route::prefix('')->name('landing.')->group(function () {
    Route::get('/landing-page', 'App\Http\Controllers\Landings\LandingController@index')->name('page');
    Route::get('/landing-page/logout', 'App\Http\Controllers\Auth\AuthController@doLogoutULanding')->name('logout.redirect');
});

Route::prefix('')->name('userPanels.')->middleware('auth')->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\UserPanels\UserPanelController@index')->name('dashboard');
    Route::get('/dashboard/absen-in', 'App\Http\Controllers\UserPanels\UserPanelController@loadAbsenModal_In')->name('absen.load');
    Route::get('/dashboard/absen-out', 'App\Http\Controllers\UserPanels\UserPanelController@loadAbsenModal_Out')->name('absen.load');
    Route::post('/dashboard/absen/do-in', 'App\Http\Controllers\UserPanels\UserPanelController@doAbsenInViaModal')->name('absen.do.in');
    Route::post('/dashboard/absen/do-out', 'App\Http\Controllers\UserPanels\UserPanelController@doAbsenOutViaModal')->name('absen.do.out');
    Route::get('/logout', 'App\Http\Controllers\Auth\AuthController@doLogoutUPanel')->name('logout.redirect');
});

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', 'App\Http\Controllers\MyProfiles\MyProfileController@index')->name('userPanels.myprofile');
    Route::post('/my-profile', 'App\Http\Controllers\MyProfiles\MyProfileController@index')->name('userPanels.myprofile');
    Route::post('/my-profile/edit-acc-avatar', 'App\Http\Controllers\MyProfiles\MyProfileController@profile_edit_avatar')->name('userPanels.avatar.edit');
    Route::post('/my-profile/edit-biodata', 'App\Http\Controllers\MyProfiles\MyProfileController@profile_edit_biodata')->name('userPanels.biodata.edit');
    Route::post('/my-profile/edit-accdata', 'App\Http\Controllers\MyProfiles\MyProfileController@profile_edit_accdata')->name('userPanels.accdata.edit');
    Route::get('/my-profile/edit-accdata', 'App\Http\Controllers\MyProfiles\MyProfileController@profile_edit_accdata')->name('userPanels.accdata.edit');
    Route::get('/my-profile/load-biodata', 'App\Http\Controllers\MyProfiles\MyProfileController@profile_load_biodata')->name('userPanels.biodata.load');
    Route::get('/my-profile/load-accdata', 'App\Http\Controllers\MyProfiles\MyProfileController@profile_load_accdata')->name('userPanels.accdata.load');
});



Route::middleware(['auth'])->group(function () {    // Note: Separated group coz somewhat wont work if using direct controller path (only /my-profile).
    Route::get('/my-profile', [MyProfileController::class, 'index'])->name('userPanels.myprofile');
});
Route::middleware('auth')->group(function () {
    // Route::get('/my-profile', [MyProfileController::class, 'index'])->name('userPanels.myprofile');
    // Route::post('/my-profile', [MyProfileController::class, 'index'])->name('userPanels.myprofile');
    Route::post('/my-profile/edit-acc-avatar', [MyProfileController::class, 'profile_edit_avatar'])->name('userPanels.avatar.edit');
    Route::post('/my-profile/edit-biodata', [MyProfileController::class, 'profile_edit_biodata'])->name('userPanels.biodata.edit');
    Route::post('/my-profile/edit-accdata', [MyProfileController::class, 'profile_edit_accdata'])->name('userPanels.accdata.edit');
    Route::get('/my-profile/edit-accdata', [MyProfileController::class, 'profile_edit_accdata'])->name('userPanels.accdata.edit');
    Route::get('/my-profile/load-biodata', [MyProfileController::class, 'profile_load_biodata'])->name('userPanels.biodata.load');
    Route::get('/my-profile/load-accdata', [MyProfileController::class, 'profile_load_accdata'])->name('userPanels.accdata.load');
});





Route::middleware('auth')->group(function () {
    Route::get('/m-emp', [EmployeeController::class, 'index'])->name('m.emp');
    Route::post('/m-emp/add', [EmployeeController::class, 'add_emp'])->name('m.emp.add');
    Route::post('/m-emp/edit', [EmployeeController::class, 'edit_emp'])->name('m.emp.edit');
    Route::post('/m-emp/delete', [EmployeeController::class, 'delete_emp'])->name('m.emp.del');
    Route::post('/m-emp/reset', [EmployeeController::class, 'reset_emp'])->name('m.emp.reset');
    Route::post('/m-emp/load', [EmployeeController::class, 'reset_emp'])->name('m.emp.getemp');
});



Route::middleware('auth')->group(function () {
    Route::get('/m-emp/roles', [OfficeRoleController::class, 'index'])->name('m.emp.roles');
    Route::post('/m-emp/roles/add', [OfficeRoleController::class, 'add_role'])->name('m.emp.roles.add');
    Route::post('/m-emp/roles/edit', [OfficeRoleController::class, 'edit_role'])->name('m.emp.roles.edit');
    Route::post('/m-emp/roles/delete', [OfficeRoleController::class, 'delete_role'])->name('m.emp.roles.del');
    Route::post('/m-emp/roles/reset', [OfficeRoleController::class, 'reset_role'])->name('m.emp.roles.reset');
    Route::post('/m-emp/roles/role/load', [OfficeRoleController::class, 'get_role'])->name('m.emp.roles.getrole');
    Route::get('/m-emp/roles/role/load', [OfficeRoleController::class, 'get_role'])->name('m.emp.roles.getrole');
});



Route::middleware('auth')->group(function () {
    Route::get('/m-absen', [AbsenController::class, 'index'])->name('m.absen');
    Route::post('/m-absen/add', [AbsenController::class, 'add_absen'])->name('m.absen.add');
    Route::post('/m-absen/edit', [AbsenController::class, 'edit_absen'])->name('m.absen.edit');
    Route::post('/m-absen/delete', [AbsenController::class, 'delete_absen'])->name('m.absen.del');
    Route::post('/m-absen/reset', [AbsenController::class, 'reset_absen'])->name('m.absen.reset');
    Route::post('/m-absen/abs/load', [AbsenController::class, 'get_absen'])->name('m.absen.getabsen');
});


Route::middleware('auth')->group(function () {
    Route::get('/m-user', [UserLoginController::class, 'index'])->name('m.user');
    Route::post('/m-user/add', [UserLoginController::class, 'add_user'])->name('m.user.add');
    Route::post('/m-user/edit', [UserLoginController::class, 'edit_user'])->name('m.user.edit');
    Route::post('/m-user/delete', [UserLoginController::class, 'delete_user'])->name('m.user.del');
    Route::post('/m-user/reset', [UserLoginController::class, 'reset_user'])->name('m.user.reset');
    Route::post('/m-user/emp/load', [UserLoginController::class, 'get_user'])->name('m.user.getuser');
    // Route::get('/m-user/emp/load', [UserLoginController::class, 'get_user'])->name('m.user.getuser.manual');
    // Route::get('/m-user/edit', [UserLoginController::class, 'edit_user'])->name('m.user.edit.manual');
});









////////////////////////////////////////////////// END: OLD WAY (DONOT REMOVE) /////////////////////////////////////////////////////////
// Route::get('/', function () {
//     return view('landings');
// });

// Route::get('/login', 'AuthController@showLogin')->name('login.page');
// Route::get('/register', 'AuthController@showRegister')->name('register.page');

// Route::prefix('')->name('userPanels.')->group(function () {      /// BEFORE APPLY AUTH
//     Route::get('/dashboard', 'UserPanelController@index')->name('dashboard');
//     Route::get('/logout', 'AuthController@doLogoutUPanel')->name('logout.redirect');
// });


// Route::get('/my-profile', [MyProfileController::class, 'index'])->name('userPanels.myprofile');
// Route::middleware('auth')->group(function () {
//     // Route::get('/my-profile', [MyProfileController::class, 'index'])->name('userPanels.myprofile');
//     // Route::post('/my-profile', [MyProfileController::class, 'index'])->name('userPanels.myprofile');
//     Route::post('/my-profile/edit-acc-avatar', [MyProfileController::class, 'profile_edit_avatar'])->name('userPanels.avatar.edit');
//     Route::post('/my-profile/edit-biodata', [MyProfileController::class, 'profile_edit_biodata'])->name('userPanels.biodata.edit');
//     Route::post('/my-profile/edit-accdata', [MyProfileController::class, 'profile_edit_accdata'])->name('userPanels.accdata.edit');
//     Route::get('/my-profile/edit-accdata', [MyProfileController::class, 'profile_edit_accdata'])->name('userPanels.accdata.edit');
//     Route::get('/my-profile/load-biodata', [MyProfileController::class, 'profile_load_biodata'])->name('userPanels.biodata.load');
//     Route::get('/my-profile/load-accdata', [MyProfileController::class, 'profile_load_accdata'])->name('userPanels.accdata.load');
// });

