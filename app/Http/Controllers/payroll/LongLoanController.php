<?php

namespace App\Http\Controllers\payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\payroll\LongLoan;
use App\Models\Employee\Employee;
use Toastr;
use Carbon\Carbon;
use DB;
use File;
use App\Http\Traits\ImageHandleTraits;
use Exception;

class LongLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $longloan=LongLoan::all();
        return view('pay_roll.longloan.index',compact('longloan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees=Employee::select('id','admission_id_no','bn_applicants_name')->get();
        return view('pay_roll.longloan.create',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        try {
            $data = new LongLoan();
            $data->employee_id = $request->employee_id;
            $data->loan_amount = $request->loan_amount;
            $data->loan_balance = $request->loan_amount;
            $data->purchase_date = $request->purchase_date;
            $data->installment_date = date('Y-m-d', strtotime($request->start_date));
            $data->number_of_installment = $request->number_of_installment;
            $data->perinstallment_amount = $request->per_installment;
            $data->end_date = $request->end_date;
            $data->status = 0;
            $data->save();
                \LogActivity::addToLog('Add Long Loan',$request->getContent(),'LongLoan');
                return redirect()->route('long_loan.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees=Employee::all();
        $loan = LongLoan::findOrFail(encryptor('decrypt',$id));
        return view('pay_roll.longloan.edit',compact('loan','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
