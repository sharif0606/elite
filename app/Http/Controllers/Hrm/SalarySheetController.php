<?php

namespace App\Http\Controllers\Hrm;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Hrm\SalarySheet;
use App\Models\Crm\CustomerDuty;
use App\Http\Controllers\Controller;
use App\Models\Crm\CustomerDutyDetail;

class SalarySheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.create',compact('customer'));
    }
    public function getsalarySheetOne()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.salarysheetOne',compact('customer'));
    }
    public function getsalarySheetTwo()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.salarysheetTwo',compact('customer'));
    }
    public function salarySheetThree()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.salarysheetThree',compact('customer'));
    }
    public function salarySheetFour()
    {
        $customer=Customer::all();
        return view('hrm.salary_sheet.salarysheetFour',compact('customer'));
    }

    public function salarySheetOneStore(Request $request)
    {
        dd($request->all());
        try{
            $c=new SalarySheet;
            $c->name=$request->name;
            $c->code=$request->code;
            $c->afford_range=$request->afford_range;
            $c->high_grade_range	=$request->high_grade_range	;
            $c->inspection	=$request->inspection;
            $c->insurance	=$request->insurance;
            $c->created_by=currentUserId();
            if($c->save()){
                $this->notice::success('Data Saved!');
                return redirect()->route(currentUser().'.country.index');
            }else{
                $this->notice::error('Please try again!','Fail');
                return redirect()->back()->withInput();
            }
        }catch(Exception $e){
            dd($e);
            $this->notice::error('Please try again!','Fail');
            return redirect()->back()->withInput();
        }
    }


    public function store(Request $request)
    {
        //
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
        //
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

    public function getSalaryData(Request $request)
    {
        $query = CustomerDutyDetail::join('customer_duties', 'customer_duties.id', '=', 'customer_duty_details.customerduty_id')
        ->join('job_posts','customer_duty_details.job_post_id','=','job_posts.id')
        ->join('employees','customer_duty_details.employee_id','=','employees.id')
            ->select('customer_duties.*', 'customer_duty_details.*','job_posts.id as jobpost_id','job_posts.name as jobpost_name','employees.id as employee_id','employees.admission_id_no','employees.en_applicants_name','employees.joining_date');

        if ($request->start_date && $request->end_date) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('customer_duty_details.start_date', '>=',$startDate )
                        ->whereDate('customer_duty_details.end_date', '<=', $endDate);
                });
            });
        }
            if ($request->customer_id) {
                $customerId = $request->customer_id;
                $query->whereIn('customer_duties.customer_id', $customerId);
            }
            if ($request->CustomerIdNot) {
                $CustomerIdNot = $request->CustomerIdNot;
                $query->whereNotIn('customer_duties.customer_id', $CustomerIdNot);
            }
        $data = $query->get();

        return response()->json($data, 200);
    }
}
