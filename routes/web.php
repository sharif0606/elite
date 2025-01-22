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
use App\Http\Controllers\HourController as hour;


use App\Http\Controllers\Crm\EmployeeAttendanceController as empatten;
use App\Http\Controllers\Crm\EmployeeAssignController as empasign;
use App\Http\Controllers\Crm\PortlinkAssignController as portlinkAssaign;
use App\Http\Controllers\Crm\SouthBanglaAssignController as southBanglaAssaign;
use App\Http\Controllers\Crm\SouthBanglaInvoiceController as southBanglaInvoice;
use App\Http\Controllers\Crm\CustomerDutyController as customerduty;
use App\Http\Controllers\Crm\InvoiceGenerateController as invoiceGenerate;
use App\Http\Controllers\Crm\PortlinkInvoiceController as portlinkInvoice;
use App\Http\Controllers\Crm\EmployeeRateController as employeeRate;



use App\Http\Controllers\Settings\AdminUserController as admin;
use App\Http\Controllers\Settings\UserProfileController as userprofile;

/* HRM */
use App\Http\Controllers\Employee\EmployeeController as employee;
use App\Http\Controllers\Release\ReleaseEmployeeController as relEmployee;
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
use App\Http\Controllers\Accounts\Report\HeadReportController as headreport;
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
        Route::resource('hour',hour::class);
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
        Route::get('product-issue-after/create',[requisition::class, 'product_issue_create'])->name('product_issue.product_issue_create');
        Route::resource('stock',stock::class);
        Route::resource('productdamage',productdamage::class);
        Route::get('/stock-employee-list',[stock::class,'EmployeeList'])->name('stock.employeeList');
        Route::get('/stock-employee-individual/{id}',[stock::class,'employeeIndividual'])->name('stock.employeeIndividual');

        Route::post('/stockin-product/delete', [product_stockin::class, 'productDelete'])->name('product_stockin.stock_in_product.delete');
        Route::post('/stockin-issue-product/delete', [requisition::class, 'issueProductDelete'])->name('product_issue.delete');
        Route::post('/stockin-damage-product/delete', [productdamage::class, 'damageProductDelete'])->name('productdamage.damage_product.delete');

        /* CRM */
        Route::resource('empatten',empatten::class);
        Route::resource('employee_assign',empasign::class);
        Route::resource('portlinkAssaign',portlinkAssaign::class);
        Route::resource('southBanglaAssaign',southBanglaAssaign::class);
        Route::resource('southBanglaInvoice',southBanglaInvoice::class);
        Route::resource('employeeRate',employeeRate::class);
        Route::resource('customerduty',customerduty::class);
        Route::resource('invoiceGenerate',invoiceGenerate::class);
        Route::resource('portlinkInvoice',portlinkInvoice::class);
        Route::resource('customer', customer::class);
        Route::resource('customerbrance', customerbrance::class);
        Route::resource('customerRate', customerRate::class);
        Route::resource('wasaEmployeeAsign', wasaEmployeeAsign::class);
        Route::resource('oneTripInvoice', oneTripInvoice::class);

        /* HRM */
        Route::resource('employee', employee::class);
        Route::get('export-to-word/{id}',[employee::class,'exportToWord'])->name('employee.exportToWord');
        Route::resource('relEmployee', relEmployee::class);
        Route::get('employee-release', [relEmployee::class,'startRelease'])->name('employee.release');
        Route::get('employee/{id}', [employee::class,'show'])->name('employee.show');
        Route::get('/employee-documents', [employee::class,'employeeDocument'])->name('employee.employeeDocument');
        Route::get('employee-certificate/{id}', [employee::class,'certificate'])->name('employee.certificate');
        Route::get('additional-file', [employee::class,'additionalFile'])->name('employee.additionalFile');

        /* Salary Sheet */
        Route::resource('salarySheet', salarySheet::class);
         // salary 1
        Route::get('salary-sheet-one-index', [salarySheet::class,'getsalarySheetOneIndex'])->name('salarysheet.salarySheetOneIndex');
        Route::get('screen-salary-sheet-one', [salarySheet::class,'getsalarySheetOne'])->name('salarysheet.salarySheetOne');
        Route::post('/salary-one-store', [salarySheet::class,'salarySheetOneStore'])->name('salarysheet.salarySheetOneStore');
        Route::get('screen-salary-sheet-one-edit/{id}', [salarySheet::class,'editSalaryOne'])->name('salarySheetOneEdit');
        Route::post('/salary-one-update/{id}', [salarySheet::class,'salarySheetOneUpdate'])->name('salarysheet.salarySheetOneUpdate');
        Route::get('salary-sheet-one-show/{id}', [salarySheet::class,'getsalarySheetOneShow'])->name('salarysheet.salarySheetOneShow');
         // salary 2
        Route::get('salary-sheet-two-index', [salarySheet::class,'getsalarySheetTwoIndex'])->name('salarysheet.salarySheetTwoIndex');
        Route::get('screen-salary-sheet-two', [salarySheet::class,'getsalarySheetTwo'])->name('salarysheet.salarySheetTwo');
        Route::post('/salary-two-store', [salarySheet::class,'salarySheetTwoStore'])->name('salarysheet.salarySheetTwoStore');
        Route::get('screen-salary-sheet-two-edit/{id}', [salarySheet::class,'editSalaryTwo'])->name('salarySheetTwoEdit');
        Route::post('/salary-two-update/{id}', [salarySheet::class,'salarySheetTwoUpdate'])->name('salarysheet.salarySheetTwoUpdate');
        Route::get('salary-sheet-two-show/{id}', [salarySheet::class,'getsalarySheetTwoShow'])->name('salarysheet.salarySheetTwoShow');
        // salary 3
        Route::get('salary-sheet-three-index', [salarySheet::class,'getsalarySheetThreeIndex'])->name('salarysheet.salarySheetThreeIndex');
        Route::get('screen-salary-sheet-three', [salarySheet::class,'salarySheetThree'])->name('salarysheet.salarySheetThree');
        Route::post('/salary-three-store', [salarySheet::class,'salarySheetThreeStore'])->name('salarysheet.salarySheetThreeStore');
        Route::get('screen-salary-sheet-three-edit/{id}', [salarySheet::class,'editSalaryThree'])->name('salarysheet.salarySheetThreeEdit');
        Route::post('/salary-three-update/{id}', [salarySheet::class,'salarySheetThreeUpdate'])->name('salarysheet.salarySheetThreeUpdate');
        Route::get('salary-sheet-three-show/{id}', [salarySheet::class,'salarySheetThreeShow'])->name('salarysheet.salarySheetThreeShow');
        // salary 4 office staff
        Route::get('salary-sheet-four-index', [salarySheet::class,'getsalarySheetFourIndex'])->name('salarysheet.salarySheetFourIndex');
        Route::get('screen-salary-sheet-four', [salarySheet::class,'salarySheetFour'])->name('salarysheet.salarySheetFour');
        Route::post('/salary-four-store', [salarySheet::class,'salarySheetFourStore'])->name('salarysheet.salarySheetFourStore');
        Route::get('salary-sheet-four-edit/{id}', [salarySheet::class,'editSalaryFour'])->name('salarysheet.editSalaryFour');
        Route::post('/salary-four-update/{id}', [salarySheet::class,'salarySheetFourUpdate'])->name('salarysheet.salarySheetFourUpdate');
        Route::get('salary-sheet-four-show/{id}', [salarySheet::class,'salarySheetFourShow'])->name('salarysheet.salarySheetFourShow');
        // salary 5
        Route::get('get-salary-branch-ajax',[salarySheet::class,'getSalaryBranch'])->name('get_ajax_salary_branch');
        Route::get('salary-sheet-five-index', [salarySheet::class,'getsalarySheetFiveIndex'])->name('salarysheet.salarySheetFiveIndex');
        /* Salary sheet Five Index */
        Route::get('salary-sheet-print-zone-wise', [salarySheet::class,'printZoneWise'])->name('salarysheet.printZoneWise');

        Route::get('screen-salary-sheet-five', [salarySheet::class,'salarySheetFive'])->name('salarysheet.salarySheetFive');
        Route::post('/salary-five-store', [salarySheet::class,'salarySheetFiveStore'])->name('salarysheet.salarySheetFiveStore');
        Route::get('screen-salary-sheet-five-edit/{id}', [salarySheet::class,'editSalaryFive'])->name('salarySheetFiveEdit');
        Route::post('/salary-five-update/{id}', [salarySheet::class,'salarySheetFiveUpdate'])->name('salarysheet.salarySheetFiveUpdate');
        Route::get('salary-sheet-five-show/{id}', [salarySheet::class,'getsalarySheetFiveShow'])->name('salarysheet.salarySheetFiveShow');

        Route::resource('deduction_asign', deductionAsign::class);
        Route::resource('long_loan', long_loan::class);
        Route::get('deduction-create/{deduction_id}', [deductionAsign::class,'createDeduction'])->name('deduction_asign.deductionCreate');
        Route::get('get-old-deduction-data', [deductionAsign::class,'getOldDeduction'])->name('deduction_asign.get_old_deduction');
        Route::get('salary-stop-index', [deductionAsign::class,'salaryStopIndex'])->name('deduction_asign.salaryStopIndex');
        Route::get('salary-stop', [deductionAsign::class,'salary_stop'])->name('deduction_asign.salaryStopCreate');
        Route::get('deduction-fine-index', [deductionAsign::class,'fineIndex'])->name('deduction_asign.fineIndex');
        Route::get('deduction-mobilebill-index', [deductionAsign::class,'mobileBillIndex'])->name('deduction_asign.mobileBillIndex');
        Route::get('deduction-loan-index', [deductionAsign::class,'loanIndex'])->name('deduction_asign.loanIndex');
        Route::get('deduction-cloth-index', [deductionAsign::class,'clothIndex'])->name('deduction_asign.clothIndex');
        Route::get('deduction-jacket-index', [deductionAsign::class,'JacketIndex'])->name('deduction_asign.JacketIndex');
        Route::get('deduction-hr-index', [deductionAsign::class,'HrIndex'])->name('deduction_asign.HrIndex');
        Route::get('deduction-cf-index', [deductionAsign::class,'CfIndex'])->name('deduction_asign.CfIndex');
        Route::get('deduction-medical-index', [deductionAsign::class,'medicalIndex'])->name('deduction_asign.medicalIndex');
        Route::get('deduction-MatterssPillowIndex-index', [deductionAsign::class,'MatterssPillowIndex'])->name('deduction_asign.MatterssPillowIndex');
        Route::get('deduction-tonicsim-index', [deductionAsign::class,'tonicSimIndex'])->name('deduction_asign.tonicSimIndex');
        Route::get('deduction-overpayment-index', [deductionAsign::class,'overPaymentIndex'])->name('deduction_asign.overPaymentIndex');
        Route::get('deduction-bank-index', [deductionAsign::class,'bankChargeIndex'])->name('deduction_asign.bankChargeIndex');
        Route::get('deduction-dress-index', [deductionAsign::class,'DressIndex'])->name('deduction_asign.DressIndex');
        Route::get('deduction-stmp-index', [deductionAsign::class,'stmpIndex'])->name('deduction_asign.stmpIndex');
        Route::get('deduction-mobile-excess-index', [deductionAsign::class,'mobileExcessIndex'])->name('deduction_asign.mobileExcessIndex');
        Route::get('deduction-mess-index', [deductionAsign::class,'messIndex'])->name('deduction_asign.messIndex');
        Route::get('deduction-absent-index', [deductionAsign::class,'absentIndex'])->name('deduction_asign.absentIndex');
        Route::get('deduction-vacant-index', [deductionAsign::class,'vacantIndex'])->name('deduction_asign.vacantIndex');
        Route::get('allownce-fuel-index', [deductionAsign::class,'fuelIndex'])->name('deduction_asign.fuelBillIndex');
        Route::get('allownce-post-allowance-index', [deductionAsign::class,'postAllowanceIndex'])->name('deduction_asign.postAllowanceIndex');
        Route::get('allowance-index', [deductionAsign::class,'allowanceIndex'])->name('deduction_asign.allowanceIndex');
        Route::get('leave-index', [deductionAsign::class,'leaveIndex'])->name('deduction_asign.leaveIndex');
        Route::get('arrear-index', [deductionAsign::class,'arrearIndex'])->name('deduction_asign.arrearIndex');
        Route::get('deduction-adv-index', [deductionAsign::class,'advIndex'])->name('deduction_asign.advIndex');

        //Accounts
        Route::resource('master',master::class);
        Route::resource('sub_head',sub_head::class);
        Route::resource('child_one',child_one::class);
        Route::resource('child_two',child_two::class);
        Route::resource('navigate',navigate::class);
        Route::get('incomeStatement',[statement::class,'index'])->name('incomeStatement.list');
        Route::get('incomeStatement_details',[statement::class,'details'])->name('incomeStatement.details');
        Route::get('/headreport', [headreport::class, 'index'])->name('headreport');
        
        //Voucher
        Route::resource('credit_voucher',credit::class);
        Route::resource('debit_voucher',debit::class);
        Route::resource('journal_voucher',journal::class);

        //report
        Route::get('inv-pay-report',[reports::class,'invoicePayment'])->name('report.inv_payment');
        Route::get('inv-due-report',[reports::class,'invoiceDue'])->name('report.inv_due');
        Route::get('payment-receive-report',[reports::class,'paymentReceive'])->name('report.payment_receive');
        Route::get('payment-receive-detail/{id}',[reports::class,'paymentReceiveDetails'])->name('report.payment_receive_detail');
        Route::get('salary-report',[reports::class,'salaryReport'])->name('report.salary_report');
        Route::get('salary-report-details',[reports::class,'salaryReportDetil'])->name('report.salary_report_details');
        Route::get('customer-duty-filter',[reports::class,'customer_duty_filter'])->name('report.customer_duty_filter');

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
        Route::get('get-portlink-invoice-data',[portlinkInvoice::class,'getPortInvoiceData'])->name('get_port_invoice_data');
        Route::get('get-south-bangla-invoice-data',[southBanglaInvoice::class,'getEmployeeRate'])->name('get_south_bangla_invoice_data');
        Route::get('get-south-bangla-invoice-designation',[southBanglaInvoice::class,'getEmployeeDesignation'])->name('get_south_bangla_designation');
        Route::get('get-customer-header-footer',[invoiceGenerate::class,'getHeaderFooterNote'])->name('get_customer_header_footer');
        Route::get('/get-employee', [empatten::class, 'getEmployee'])->name('empatt.getEmployee');
        /* ==  Customer Wise Job Post Data == */
        Route::get('/get-job-post', [empasign::class, 'getJobPost'])->name('empasign.getJobPost');
         /* ==  Customer Wise Employee Salary Designation== */
         Route::get('/get-employee-salary-post', [employeeRate::class, 'getEmployeeRate'])->name('emp.getEmployeeRate');
        Route::get('/wasa-get-employee', [wasaEmployeeAsign::class, 'wasaGetEmployee'])->name('wasaGetEmployee');
        Route::get('/get-employee-duty-ot-rate', [customerduty::class, 'getEmployeeDuty'])->name('get_employeedata');
        Route::get('/get-employee-hourewise-duty-ot-rate', [customerduty::class, 'getDutyOtRateHourWise'])->name('get_employeedata_hourewise');
        Route::get('/checking-others-duty', [customerduty::class, 'checkOthersCustomerDuty'])->name('get_employee_others_duty');
        
        Route::get('/customer_createscreen', [customerbrance::class,'createScreen'])->name('customer.createScreen');
        Route::get('/customer_ratescreen', [customerRate::class,'rateCreateScreen'])->name('customer.rateCreateScreen');
        Route::resource('invoice-payment',invPayment::class);
        /*== Invoice Report Client Wise ==*/
        Route::get('client-wise-invoice-details', [Reports::class, 'client_wise_detail_invoice_report'])->name('invoice-payment.client_wise_detail_invoice_report');

        Route::get('/checking-po-number', [invPayment::class, 'checkPoNumber'])->name('checking_duplicate_po');
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
        Route::get('/single-invoice-show9/{id}', [invoiceGenerate::class, 'getSingleInvoice9'])->name('invoiceShow9');
        Route::get('/less-paid-invoice/{customer}/{startDate}/{invoice}/{branch?}', [invoiceGenerate::class, 'lessPaidInvoiceGenerate'])->name('less_paid_invoice');
        Route::get('createInvoice', [wasaEmployeeAsign::class,'createInvoice'])->name('wasaEmployeeAsign.createInvoice');
        Route::post('wasastoreInvoice', [wasaEmployeeAsign::class,'storeWasaInvoice'])->name('WasaInviceStore');
        Route::get('edit-Invoice/{id}', [wasaEmployeeAsign::class,'wasaInvoiceEdit'])->name('wasaEmployeeAsign.editInvoice');
        Route::post('wasa-Invoice-update/{id}', [wasaEmployeeAsign::class,'wasaInvoiceUpdate'])->name('WasaInviceUpdate');

        /* stock */
        Route::get('/stock-report-individual/{id}',[stock::class,'stockindividual'])->name('stock.individual');

        /* accounts */
        Route::get('get_head', [vouchers::class, 'get_head'])->name('get_head');
    });



