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
use App\Http\Controllers\payroll\ControllerDeduction as deductionAsign;
use App\Http\Controllers\payroll\LongLoanController as long_loan;

/*crm*/
use App\Http\Controllers\CustomerController as customer;
use App\Http\Controllers\Crm\CustomerBranceController as customerbrance;
use App\Http\Controllers\Crm\CustomerRateController as customerRate;
use App\Http\Controllers\Crm\WasaEmployeeAssignController as wasaEmployeeAsign;
use App\Http\Controllers\Crm\OnetripInvoiceController as oneTripInvoice;
use App\Http\Controllers\Crm\InvoicePaymentController as invPayment;

/* Stock */
use App\Http\Controllers\Stock\CategoryController as category;
use App\Http\Controllers\Stock\ProductSizeController as size;
use App\Http\Controllers\Stock\ProductController as product;
use App\Http\Controllers\Stock\ProductStockinController as product_stockin;
use App\Http\Controllers\Stock\ProductRequisitionController as requisition;
use App\Http\Controllers\Stock\StockController as stock;
use App\Http\Controllers\Stock\ProductDamageController as productdamage;

/* Accounts*/
use App\Http\Controllers\Accounts\MasterAccountController as master;
use App\Http\Controllers\Accounts\SubHeadController as sub_head;
use App\Http\Controllers\Accounts\ChildOneController as child_one;
use App\Http\Controllers\Accounts\ChildTwoController as child_two;
use App\Http\Controllers\Accounts\NavigationHeadViewController as navigate;
use App\Http\Controllers\Accounts\Report\IncomeStatementController as statement;
/*Vouchers */
use App\Http\Controllers\Vouchers\VoucherController as vouchers;
use App\Http\Controllers\Vouchers\CreditVoucherController as credit;
use App\Http\Controllers\Vouchers\DebitVoucherController as debit;
use App\Http\Controllers\Vouchers\JournalVoucherController as journal;

/* report */
use App\Http\Controllers\Report\ReportController as reports;

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

        Route::post('/stockin-product/delete', [product_stockin::class, 'productDelete'])->name('stock_in_product.delete');
        Route::post('/stockin-issue-product/delete', [requisition::class, 'issueProductDelete'])->name('issue_product.delete');
        Route::post('/stockin-damage-product/delete', [productdamage::class, 'damageProductDelete'])->name('damage_product.delete');

        /* CRM */
        Route::resource('empatten',empatten::class);
        Route::resource('employee_assign',empasign::class);
        Route::resource('employeeRate',employeeRate::class);
        Route::resource('customerduty',customerduty::class);
        Route::resource('invoiceGenerate',invoiceGenerate::class);
        Route::resource('customer', customer::class);
        Route::resource('customerbrance', customerbrance::class);
        Route::resource('customerRate', customerRate::class);
        Route::resource('wasaEmployeeAsign', wasaEmployeeAsign::class);
        Route::resource('oneTripInvoice', oneTripInvoice::class);

        /* HRM */
        Route::resource('employee', employee::class);
        Route::get('employee/{id}', [employee::class,'show'])->name('employee.show');
        Route::get('/employee_documents', [employee::class,'employeeDocument'])->name('superadmin.employeeDocument');

        /* Salary Sheet */
        Route::resource('salarySheet', salarySheet::class);
        Route::get('screen-salary-sheet-one', [salarySheet::class,'getsalarySheetOne'])->name('salarySheetOne');
        Route::get('salary-sheet-one-index', [salarySheet::class,'getsalarySheetOneIndex'])->name('salarysheet.salarySheetOneIndex');
        Route::get('salary-sheet-two-index', [salarySheet::class,'getsalarySheetTwoIndex'])->name('salarysheet.salarySheetTwoIndex');
        Route::get('salary-sheet-three-index', [salarySheet::class,'getsalarySheetThreeIndex'])->name('salarysheet.salarySheetThreeIndex');
        Route::get('salary-sheet-four-index', [salarySheet::class,'getsalarySheetFourIndex'])->name('salarysheet.salarySheetFourIndex');
        Route::get('salary-sheet-five-index', [salarySheet::class,'getsalarySheetFiveIndex'])->name('salarysheet.salarySheetFiveIndex');
        Route::get('salary-sheet-one-show/{id}', [salarySheet::class,'getsalarySheetOneShow'])->name('salarysheet.salarySheetOneShow');
        Route::get('salary-sheet-two-show/{id}', [salarySheet::class,'getsalarySheetTwoShow'])->name('salarysheet.salarySheetTwoShow');
        Route::get('salary-sheet-three-show/{id}', [salarySheet::class,'salarySheetThreeShow'])->name('salarysheet.salarySheetThreeShow');
        Route::get('salary-sheet-four-show/{id}', [salarySheet::class,'salarySheetFourShow'])->name('salarysheet.salarySheetFourShow');
        Route::get('salary-sheet-five-show/{id}', [salarySheet::class,'getsalarySheetFiveShow'])->name('salarysheet.salarySheetFiveShow');
        Route::get('screen-salary-sheet-two', [salarySheet::class,'getsalarySheetTwo'])->name('salarySheetTwo');
        Route::get('screen-salary-sheet-three', [salarySheet::class,'salarySheetThree'])->name('salarySheetThree');
        Route::get('screen-salary-sheet-four', [salarySheet::class,'salarySheetFour'])->name('salarySheetFour');
        Route::get('screen-salary-sheet-five', [salarySheet::class,'salarySheetFive'])->name('salarySheetFive');
        Route::post('/salary-one-store', [salarySheet::class,'salarySheetOneStore'])->name('salarysheet.salarySheetOneStore');
        Route::post('/salary-two-store', [salarySheet::class,'salarySheetTwoStore'])->name('salarysheet.salarySheetTwoStore');
        Route::post('/salary-three-store', [salarySheet::class,'salarySheetThreeStore'])->name('salarysheet.salarySheetThreeStore');
        Route::post('/salary-four-store', [salarySheet::class,'salarySheetFourStore'])->name('salarysheet.salarySheetFourStore');
        Route::post('/salary-five-store', [salarySheet::class,'salarySheetFiveStore'])->name('salarysheet.salarySheetFiveStore');
        Route::resource('deduction_asign', deductionAsign::class);
        Route::resource('long_loan', long_loan::class);
        Route::get('deduction-fine-index', [deductionAsign::class,'fineIndex'])->name('fineIndex');
        Route::get('deduction-mobilebill-index', [deductionAsign::class,'mobileBillIndex'])->name('mobileBillIndex');
        Route::get('deduction-loan-index', [deductionAsign::class,'loanIndex'])->name('loanIndex');
        Route::get('deduction-cloth-index', [deductionAsign::class,'clothIndex'])->name('clothIndex');
        Route::get('deduction-jacket-index', [deductionAsign::class,'JacketIndex'])->name('JacketIndex');
        Route::get('deduction-hr-index', [deductionAsign::class,'HrIndex'])->name('HrIndex');
        Route::get('deduction-cf-index', [deductionAsign::class,'CfIndex'])->name('CfIndex');
        Route::get('deduction-medical-index', [deductionAsign::class,'medicalIndex'])->name('medicalIndex');
        Route::get('deduction-MatterssPillowIndex-index', [deductionAsign::class,'MatterssPillowIndex'])->name('MatterssPillowIndex');
        Route::get('deduction-tonicsim-index', [deductionAsign::class,'tonicSimIndex'])->name('tonicSimIndex');
        Route::get('deduction-overpayment-index', [deductionAsign::class,'overPaymentIndex'])->name('overPaymentIndex');
        Route::get('deduction-bank-index', [deductionAsign::class,'bankChargeIndex'])->name('bankChargeIndex');
        Route::get('deduction-dress-index', [deductionAsign::class,'DressIndex'])->name('DressIndex');

        //Accounts
        Route::resource('master',master::class);
        Route::resource('sub_head',sub_head::class);
        Route::resource('child_one',child_one::class);
        Route::resource('child_two',child_two::class);
        Route::resource('navigate',navigate::class);
        Route::get('incomeStatement',[statement::class,'index'])->name('incomeStatement.list');
        Route::get('incomeStatement_details',[statement::class,'details'])->name('incomeStatement.details');

        //Voucher
        Route::resource('credit_voucher',credit::class);
        Route::resource('debit_voucher',debit::class);
        Route::resource('journal_voucher',journal::class);

        //report
        Route::get('inv-pay-report',[reports::class,'invoicePayment'])->name('report.inv_payment');
        Route::get('inv-due-report',[reports::class,'invoiceDue'])->name('report.inv_due');

    });

    Route::middleware(['checkauth'])->prefix('admin')->group(function(){
        Route::get('dashboard', [dashboard::class,'index'])->name('dashboard');
        /* get AjaX Data */
        // Route::get('/branch/ajax/{customerId}', [empasign::class, 'loadBranchAjax'])->name('loadbranch.ajax');
        // Route::get('/branch/ajax/{customerId}', [empasign::class, 'loadBranchAjax'])->name('loadbranch.ajax');
        Route::get('get-branch-ajax',[empasign::class,'loadBranchAjax'])->name('get_ajax_branch');
        Route::get('get-atm-ajax',[empasign::class,'loadAtmAjax'])->name('get_ajax_atm');
        Route::get('get-rate-ajax',[empasign::class,'loadRateAjax'])->name('get_ajax_rate');

        Route::get('/profile', [userprofile::class,'profile'])->name('profile');
        Route::post('/profile', [userprofile::class,'store'])->name('profile.store');
        Route::get('/change_password', [userprofile::class,'change_password'])->name('change_password');
        Route::post('/change_password', [userprofile::class,'change_password_store'])->name('change_password.store');

        /* Hrm */
        Route::get('get-salary-data',[salarySheet::class,'getSalaryData'])->name('get_salary_data');
        Route::get('get-salary-four-data',[salarySheet::class,'getSalaryFourData'])->name('get_salary_four_data');

        /*Crm */
        Route::get('get-invoice-data',[invoiceGenerate::class,'getInvoiceData'])->name('get_invoice_data');
        Route::get('/get-employee', [empatten::class, 'getEmployee'])->name('empatt.getEmployee');
        Route::get('/wasa-get-employee', [wasaEmployeeAsign::class, 'wasaGetEmployee'])->name('wasaGetEmployee');
        Route::get('/get-employee-duty-ot-rate', [customerduty::class, 'getEmployeeDuty'])->name('get_employeedata');
        Route::get('/get-employee-hourewise-duty-ot-rate', [customerduty::class, 'getDutyOtRateHourWise'])->name('get_employeedata_hourewise');
        Route::get('/checking-others-duty', [customerduty::class, 'checkOthersCustomerDuty'])->name('get_employee_others_duty');
        Route::get('createInvoice', [wasaEmployeeAsign::class,'createInvoice'])->name('wasaEmployeeAsign.createInvoice');
        Route::get('/customer_createscreen', [customerbrance::class,'createScreen'])->name('customer.createScreen');
        Route::get('/customer_ratescreen', [customerRate::class,'rateCreateScreen'])->name('customer.rateCreateScreen');
        Route::resource('invoice-payment',invPayment::class);
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
        Route::get('/single-invoice-show7/{id}', [invoiceGenerate::class, 'getSingleInvoice7'])->name('invoiceShow7');
        Route::get('/single-invoice-show8/{id}', [invoiceGenerate::class, 'getSingleInvoice8'])->name('invoiceShow8');
        Route::post('wasastoreInvoice', [wasaEmployeeAsign::class,'storeWasaInvoice'])->name('WasaInviceStore');

        /* stock */
        Route::get('/stock-report-individual/{id}',[stock::class,'stockindividual'])->name('stock.individual');

        /* accounts */
        Route::get('get_head', [vouchers::class, 'get_head'])->name('get_head');

    });



