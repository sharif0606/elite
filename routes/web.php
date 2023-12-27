<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController as auth;
use App\Http\Controllers\DashboardController as dashboard;
use App\Http\Controllers\Settings\UserController as user;
use App\Http\Controllers\Settings\RoleController as role;
use App\Http\Controllers\Settings\PermissionController as permission;

use App\Http\Controllers\Settings\Location\CountryController as country;
use App\Http\Controllers\Settings\Location\DivisionController as division;
use App\Http\Controllers\Settings\Location\DistrictController as district;
use App\Http\Controllers\Settings\Location\UpazilaController as upazila;
use App\Http\Controllers\Settings\Location\ThanaController as thana;
use App\Http\Controllers\Settings\Location\UnionController as union;
use App\Http\Controllers\Settings\Location\WardController as ward;
use App\Http\Controllers\Settings\JobPostController as jobpost;
use App\Http\Controllers\Settings\ZoneController as zone;
use App\Http\Controllers\Settings\InvoiceSettingController as invoicesetting;


use App\Http\Controllers\Crm\EmployeeAttendanceController as empatten;
use App\Http\Controllers\Crm\EmployeeAssignController as empasign;
use App\Http\Controllers\Crm\CustomerDutyController as customerduty;
use App\Http\Controllers\Crm\InvoiceGenerateController as invoiceGenerate;
use App\Http\Controllers\Crm\EmployeeRateController as employeeRate;



use App\Http\Controllers\Settings\AdminUserController as admin;
use App\Http\Controllers\Settings\UserProfileController as userprofile;

/* HRM */
use App\Http\Controllers\Employee\EmployeeController as employee;
use App\Http\Controllers\Hrm\SalarySheetController as salarySheet;

/*crm*/
use App\Http\Controllers\CustomerController as customer;
use App\Http\Controllers\Crm\CustomerBranceController as customerbrance;
use App\Http\Controllers\Crm\CustomerRateController as customerRate;
use App\Http\Controllers\Crm\WasaEmployeeAssignController as wasaEmployeeAsign;

/* Stock */
use App\Http\Controllers\Stock\CategoryController as category;
use App\Http\Controllers\Stock\ProductSizeController as size;
use App\Http\Controllers\Stock\ProductController as product;
use App\Http\Controllers\Stock\ProductStockinController as product_stockin;
use App\Http\Controllers\Stock\ProductRequisitionController as requisition;
use App\Http\Controllers\Stock\StockController as stock;
use App\Http\Controllers\Stock\ProductDamageController as productdamage;



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

Route::middleware(['checkrole'])->prefix('admin')->group(function(){

        Route::resource('country',country::class);
        Route::resource('division',division::class);
        Route::resource('district',district::class);
        Route::resource('upazila',upazila::class);
        Route::resource('thana',thana::class);
        Route::resource('union',union::class);
        Route::resource('ward',ward::class);
        Route::resource('jobpost',jobpost::class);
        Route::resource('zone',zone::class);
        Route::resource('invoicesetting',invoicesetting::class);
        Route::get('/jobpost_description/{id}', [jobpost::class,'jobpostDescription'])->name('jobpost.description');
        Route::post('/jobpost_description/{id}', [jobpost::class,'jobpostDescriptionStore'])->name('jobpost_descriptionstor');
        Route::resource('user', user::class);
        Route::resource('role', role::class);
        Route::get('permission/{role}', [permission::class,'index'])->name('permission.list');
        Route::post('permission/{role}', [permission::class,'save'])->name('permission.save');

        /*stock */
        Route::resource('category',category::class);
        Route::resource('size',size::class);
        Route::resource('product',product::class);
        Route::resource('product_stockin',product_stockin::class);
        Route::resource('product_issue',requisition::class);
        Route::resource('stock',stock::class);
        Route::resource('productdamage',productdamage::class);
        Route::get('/stock-employee-list',[stock::class,'EmployeeList'])->name('stock.employeeList');
        Route::get('/stock-employee-individual/{id}',[stock::class,'employeeIndividual'])->name('stock.employeeIndividual');

        /* CRM */
        Route::resource('empatten',empatten::class);
        Route::resource('employee_assign',empasign::class);
        Route::resource('employeeRate',employeeRate::class);
        Route::resource('customerduty',customerduty::class);
        Route::resource('invoiceGenerate',invoiceGenerate::class);
        Route::get('/get-employee-duty-ot-rate', [customerduty::class, 'getEmployeeDuty'])->name('get_employeedata');
        Route::resource('customer', customer::class);
        Route::resource('customerbrance', customerbrance::class);
        Route::resource('customerRate', customerRate::class);
        Route::resource('wasaEmployeeAsign', wasaEmployeeAsign::class);
        Route::get('createInvoice', [wasaEmployeeAsign::class,'createInvoice'])->name('wasaEmployeeAsign.createInvoice');
        Route::get('createOnetrip', [wasaEmployeeAsign::class,'createOneTrip'])->name('wasaEmployeeAsign.oneTrip');
        Route::get('/customer_createscreen', [customerbrance::class,'createScreen'])->name('customer.createScreen');
        Route::get('/customer_ratescreen', [customerRate::class,'rateCreateScreen'])->name('customer.rateCreateScreen');

        /* HRM */
        Route::resource('employee', employee::class);
        Route::resource('salarySheet', salarySheet::class);
        Route::get('employee/{id}', [employee::class,'show'])->name('employee.show');
        Route::get('/employee_documents', [employee::class,'employeeDocument'])->name('superadmin.employeeDocument');

    });

    Route::middleware(['checkauth'])->prefix('admin')->group(function(){
        Route::get('dashboard', [dashboard::class,'index'])->name('dashboard');
        /* get AjaX Data */
        Route::get('get-invoice-data',[invoiceGenerate::class,'getInvoiceData'])->name('get_invoice_data');
        // Route::get('/branch/ajax/{customerId}', [empasign::class, 'loadBranchAjax'])->name('loadbranch.ajax');
        // Route::get('/branch/ajax/{customerId}', [empasign::class, 'loadBranchAjax'])->name('loadbranch.ajax');
        Route::get('get-branch-ajax',[empasign::class,'loadBranchAjax'])->name('get_ajax_branch');
        Route::get('get-atm-ajax',[empasign::class,'loadAtmAjax'])->name('get_ajax_atm');
        Route::get('get-rate-ajax',[empasign::class,'loadRateAjax'])->name('get_ajax_rate');

        Route::get('/profile', [userprofile::class,'profile'])->name('profile');
        Route::post('/profile', [userprofile::class,'store'])->name('profile.store');
        Route::get('/change_password', [userprofile::class,'change_password'])->name('change_password');
        Route::post('/change_password', [userprofile::class,'change_password_store'])->name('change_password.store');

        /*Crm */
        Route::get('/get-employee', [empatten::class, 'getEmployee'])->name('empatt.getEmployee');
        Route::get('/wasa-get-employee', [wasaEmployeeAsign::class, 'wasaGetEmployee'])->name('wasaGetEmployee');

        /* employee security */
        Route::get('/prior-introduction-security-guards/{id}', [employee::class,'securityGuards'])->name('securityGuards');
        Route::post('/prior-introduction-security-guards/{id}', [employee::class,'securityGuardsStore'])->name('security.store');

        /* invoce */
        Route::get('/single-invoice-show1/{id}', [invoiceGenerate::class, 'getSingleInvoice1'])->name('invoiceShow1');
        Route::get('/single-invoice-show2/{id}', [invoiceGenerate::class, 'getSingleInvoice2'])->name('invoiceShow2');
        Route::get('/single-invoice-show3/{id}', [invoiceGenerate::class, 'getSingleInvoice3'])->name('invoiceShow3');
        Route::get('/single-invoice-show4/{id}', [invoiceGenerate::class, 'getSingleInvoice4'])->name('invoiceShow4');
        Route::get('/single-invoice-show5/{id}', [invoiceGenerate::class, 'getSingleInvoice5'])->name('invoiceShow5');
        Route::get('/single-invoice-show6/{id}', [invoiceGenerate::class, 'getSingleInvoice6'])->name('invoiceShow6');
        Route::get('wasastoreInvoice', [wasaEmployeeAsign::class,'storeWasaInvoice'])->name('WasaInviceStore');

        /* stock */
        Route::get('/stock-report-individual/{id}',[stock::class,'stockindividual'])->name('stock.individual');

    });



