<?php

namespace App\Http\Controllers\Release;

use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Release\ReleaseEmployee;
use App\Models\Release\ReleaseEmployeeDetail;
use App\Models\Stock\Stock;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Traits\ImageHandleTraits;

class ReleaseEmployeeController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ReleaseEmployee::all();
        return view('release.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = Employee::select('id','admission_id_no','bn_applicants_name')->where('status',1)->get();
        return view('release.create',compact('employee'));
    }
    public function startRelease(Request $request){
        $checkRelease = ReleaseEmployee::where('employee_id',$request->employee_id)->first();
        if(!$checkRelease){
            $emp = Employee::select('id','admission_id_no','bn_applicants_name','joining_date','bn_jobpost_id','bn_parm_village_name')->where('id',$request->employee_id)->where('status',1)->first();
            // $data= Stock::where('employee_id',$request->employee_id)->where('status',1)->groupBy('product_id')->get();
            $data = Stock::selectRaw('product_id, SUM(product_qty) as product_qty')
                    ->where('employee_id', $request->employee_id)
                    ->where('status', 1)
                    ->groupBy('product_id')
                    ->get();

            //dd($data->toSql()); // This will show the raw SQL query
            return view('release.releaseForm',compact('emp','data'));
        }else{
            return redirect()->back()->withInput()->with(Toastr::error('This Employee Already has been released!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = new ReleaseEmployee;
            $data->employee_id = $request->employee_id;
            $data->resign_date = $request->resign_date;
            $data->others_note = $request->others_note;
            $data->issue_submiter_mobile = $request->issue_submiter_mobile;
            $data->appoint_customer_name = $request->appoint_customer_name;
            if($request->has('issue_submiter_sign'))
                $data->issue_submiter_sign=$this->uploadImage($request->issue_submiter_sign,'uploads/release/submiter/');
            if($request->has('issue_receiver_sign'))
                $data->issue_receiver_sign=$this->uploadImage($request->issue_receiver_sign,'uploads/release/receiver/');

            $data->cus_authority_comment = $request->cus_authority_comment;
            $data->zone_commander_comment = $request->zone_commander_comment;
            $data->amount_deducted = $request->amount_deducted;
            $data->due_salary = $request->due_salary;
            $data->due_salary_amount = $request->due_salary_amount;
            $data->due_salary_comment = $request->due_salary_comment;
            $data->pf_a = $request->pf_a;
            $data->pf_a_amount = $request->pf_a_amount;
            $data->pf_a_comment = $request->pf_a_comment;
            $data->pf_b = $request->pf_b;
            $data->pf_b_amount = $request->pf_b_amount;
            $data->pf_b_comment = $request->pf_b_comment;
            $data->pf_c = $request->pf_c;
            $data->pf_c_amount = $request->pf_c_amount;
            $data->pf_c_comment = $request->pf_c_comment;
            $data->leave = $request->leave;
            $data->leave_amount = $request->leave_amount;
            $data->leave_comment = $request->leave_comment;
            $data->addmission = $request->addmission;
            $data->addmission_amount = $request->addmission_amount;
            $data->addmission_comment = $request->addmission_comment;
            $data->others = $request->others;
            $data->others_amount = $request->others_amount;
            $data->others_comment = $request->others_comment;
            $data->subtotal = $request->subtotal;
            $data->final_deducted = $request->final_deducted;
            $data->final_deducted_note = $request->final_deducted_note;
            $data->final_total = $request->final_total;
            $data->wash_cost = $request->wash_cost;
            $data->wash_cost_amount = $request->wash_cost_amount;
            $data->others_issue = $request->others_issue;
            $data->others_issue_amount = $request->others_issue_amount;
            if ($data->save()){
                if($request->issue_item_id){
                    foreach($request->issue_item_id as $key => $value){
                        if($value){
                            $red = new ReleaseEmployeeDetail;
                            $red->release_employee_id=$data->id;
                            $red->issue_item_id=$request->issue_item_id[$key];
                            $red->issue_qty=$request->issue_qty[$key];
                            $red->receive_qty=$request->receive_qty[$key];
                            $red->not_receive_qty=$request->not_receive_qty[$key];
                            $red->not_receive_qty_amount=$request->not_receive_qty_amount[$key];
                            $red->comment=$request->comment[$key];
                            $red->save();
                        }
                    }
                    foreach($request->issue_item_id as $key => $value){
                        if($request->receive_qty[$key] > 0){
                            $stock=new Stock;
                            $stock->product_id=$request->issue_item_id[$key];
                            $stock->release_employee_id=$data->id;
                            $stock->employee_id=$request->employee_id;
                            $stock->entry_date= now();
                            $stock->product_qty=$request->receive_qty[$key];
                            $stock->type=2;
                            $stock->status=0;
                            $stock->save();
                        }
                    }
                }
                DB::commit();

                \LogActivity::addToLog('Add Release',$request->getContent(),'ReleaseEmployee,ReleaseEmployeeDetail');
                return redirect()->route('relEmployee.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Release\ReleaseEmployee  $releaseEmployee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emRel = ReleaseEmployee::findOrFail(encryptor('decrypt',$id));
        $relDetail= ReleaseEmployeeDetail::where('release_employee_id',$emRel->id)->get();
        return view('release.show',compact('emRel','relDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Release\ReleaseEmployee  $releaseEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emRel = ReleaseEmployee::findOrFail(encryptor('decrypt',$id));
        $relDetail= ReleaseEmployeeDetail::where('release_employee_id',$emRel->id)->get();
        return view('release.releaseFormEdit',compact('emRel','relDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Release\ReleaseEmployee  $releaseEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = ReleaseEmployee::findOrFail(encryptor('decrypt',$id));
            $data->employee_id = $request->employee_id;
            $data->resign_date = $request->resign_date;
            $data->others_note = $request->others_note;
            $data->issue_submiter_mobile = $request->issue_submiter_mobile;
            $data->appoint_customer_name = $request->appoint_customer_name;
            if($request->has('issue_submiter_sign')){
                if($data->issue_submiter_sign){
                    if($this->deleteImage($data->issue_submiter_sign,'uploads/release/submiter/')){
                        $data->issue_submiter_sign=$this->uploadImage($request->issue_submiter_sign,'uploads/release/submiter/');
                    }
                }else{
                    $data->issue_submiter_sign=$this->uploadImage($request->issue_submiter_sign,'uploads/release/submiter/');
                }
            }
            if($request->has('issue_receiver_sign')){
                if($data->issue_receiver_sign){
                    if($this->deleteImage($data->issue_receiver_sign,'uploads/release/receiver/')){
                        $data->issue_receiver_sign=$this->uploadImage($request->issue_receiver_sign,'uploads/release/receiver/');
                    }
                }else{
                    $data->issue_receiver_sign=$this->uploadImage($request->issue_receiver_sign,'uploads/release/receiver/');
                }
            }
            $data->cus_authority_comment = $request->cus_authority_comment;
            $data->zone_commander_comment = $request->zone_commander_comment;
            $data->amount_deducted = $request->amount_deducted;
            $data->due_salary = $request->due_salary;
            $data->due_salary_amount = $request->due_salary_amount;
            $data->due_salary_comment = $request->due_salary_comment;
            $data->pf_a = $request->pf_a;
            $data->pf_a_amount = $request->pf_a_amount;
            $data->pf_a_comment = $request->pf_a_comment;
            $data->pf_b = $request->pf_b;
            $data->pf_b_amount = $request->pf_b_amount;
            $data->pf_b_comment = $request->pf_b_comment;
            $data->pf_c = $request->pf_c;
            $data->pf_c_amount = $request->pf_c_amount;
            $data->pf_c_comment = $request->pf_c_comment;
            $data->leave = $request->leave;
            $data->leave_amount = $request->leave_amount;
            $data->leave_comment = $request->leave_comment;
            $data->addmission = $request->addmission;
            $data->addmission_amount = $request->addmission_amount;
            $data->addmission_comment = $request->addmission_comment;
            $data->others = $request->others;
            $data->others_amount = $request->others_amount;
            $data->others_comment = $request->others_comment;
            $data->subtotal = $request->subtotal;
            $data->final_deducted = $request->final_deducted;
            $data->final_deducted_note = $request->final_deducted_note;
            $data->final_total = $request->final_total;
            $data->wash_cost = $request->wash_cost;
            $data->wash_cost_amount = $request->wash_cost_amount;
            $data->others_issue = $request->others_issue;
            $data->others_issue_amount = $request->others_issue_amount;
            if ($data->save()){
                if($request->issue_item_id){
                    ReleaseEmployeeDetail::where('release_employee_id',$data->id)->delete();
                    Stock::where('release_employee_id',$data->id)->delete();
                    foreach($request->issue_item_id as $key => $value){
                        if($value){
                            $red = new ReleaseEmployeeDetail;
                            $red->release_employee_id=$data->id;
                            $red->issue_item_id=$request->issue_item_id[$key];
                            $red->issue_qty=$request->issue_qty[$key];
                            $red->receive_qty=$request->receive_qty[$key];
                            $red->not_receive_qty=$request->not_receive_qty[$key];
                            $red->not_receive_qty_amount=$request->not_receive_qty_amount[$key];
                            $red->comment=$request->comment[$key];
                            $red->save();
                        }
                    }
                    foreach($request->issue_item_id as $key => $value){
                        if($request->receive_qty[$key] > 0){
                            $stock=new Stock;
                            $stock->product_id=$request->issue_item_id[$key];
                            $stock->release_employee_id=$data->id;
                            $stock->employee_id=$request->employee_id;
                            $stock->entry_date= now();
                            $stock->product_qty=$request->receive_qty[$key];
                            $stock->type=2;
                            $stock->status=0;
                            $stock->save();
                        }
                    }
                }
                DB::commit();
                \LogActivity::addToLog('Add Release',$request->getContent(),'ReleaseEmployee,ReleaseEmployeeDetail');
                return redirect()->route('relEmployee.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Release\ReleaseEmployee  $releaseEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data= ReleaseEmployee::findOrFail(encryptor('decrypt',$id));
        ReleaseEmployeeDetail::where('release_employee_id',$data->id)->delete();
        Stock::where('release_employee_id',$data->id)->delete();
        $data->delete();
        Toastr::error('Opps!! You Delete Permanently!!');
        return redirect()->back();
    }
}
