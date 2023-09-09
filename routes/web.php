<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController as auth;
use App\Http\Controllers\DashboardController as dash;

use App\Http\Controllers\Settings\Location\CountryController as country;
use App\Http\Controllers\Settings\Location\DivisionController as division;
use App\Http\Controllers\Settings\Location\DistrictController as district;
use App\Http\Controllers\Settings\Location\UpazilaController as upazila;
use App\Http\Controllers\Settings\Location\ThanaController as thana;
use App\Http\Controllers\Settings\Location\UnionController as union;
use App\Http\Controllers\Settings\Location\WardController as ward;
use App\Http\Controllers\Settings\JobPostController as jobpost;



use App\Http\Controllers\Settings\AdminUserController as admin;
use App\Http\Controllers\Settings\UserProfileController as userprofile;


use App\Http\Controllers\Employee\EmployeeController as employee;

/*crm*/
use App\Http\Controllers\CustomerController as customer;


/* Middleware */
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isSuperadmin;
use App\Http\Middleware\isSalesexecutive;
use App\Http\Middleware\isUser;


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
/*Test controler */


Route::group(['middleware' => 'unknownUser'], function () {
    Route::get('/register', [auth::class,'signUpForm'])->name('register');
    Route::post('/register', [auth::class,'signUpStore'])->name('register.store');
    Route::get('/signin', [auth::class,'signInForm'])->name('signIn');
    Route::get('/', [auth::class,'signInForm'])->name('login');
    Route::post('/login', [auth::class,'signInCheck'])->name('login.check');
});

Route::get('/logout', [auth::class,'singOut'])->name('logOut');


//Route::middleware('checkRole')->group(function () {

Route::group(['middleware'=>isSuperadmin::class],function(){
    Route::prefix('superadmin')->group(function(){
        //Route::prefix('{role}')->group(function () {

        Route::resource('country',country::class,['as'=>'superadmin']);
        Route::resource('division',division::class,['as'=>'superadmin']);
        Route::resource('district',district::class,['as'=>'superadmin']);
        Route::resource('upazila',upazila::class,['as'=>'superadmin']);
        Route::resource('thana',thana::class,['as'=>'superadmin']);
        Route::resource('union',union::class,['as'=>'superadmin']);
        Route::resource('ward',ward::class,['as'=>'superadmin']);
        Route::resource('jobpost',jobpost::class,['as'=>'superadmin']);

        Route::get('/dashboard', [dash::class,'superadminDashboard'])->name('dashboard');

        Route::get('/profile', [userprofile::class,'profile'])->name('profile');
        Route::post('/profile', [userprofile::class,'store'])->name('profile.store');
        Route::get('/change_password', [userprofile::class,'change_password'])->name('change_password');
        Route::post('/change_password', [userprofile::class,'change_password_store'])->name('change_password.store');


        Route::resource('employee', employee::class);
        Route::get('/prior-introduction-security-guards/{id}', [employee::class,'securityGuards'])->name('securityGuards');
        Route::post('/prior-introduction-security-guards', [employee::class,'securityGuardsStore'])->name('security.store');
        Route::get('employee/{id}', [employee::class,'show'])->name('employee.show');

        Route::resource('customer', customer::class);
    });
});

Route::group(['middleware'=>isAdmin::class],function(){
    Route::prefix('admin')->group(function(){
        Route::get('/dashboard', [dash::class,'adminDashboard'])->name('admin.dashboard');
        /* settings */

    });
});




