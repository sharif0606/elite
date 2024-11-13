<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\CustomerBrance;
use App\Models\Crm\SouthBanglaAssign;
use App\Models\Crm\SouthBanglaAssignDetails;
use App\Models\Customer;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Toastr;
use Carbon\Carbon;
use DB;
use Exception;

class SouthBanglaAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::select('id','name')->get();
        $empasin=SouthBanglaAssign::orderBy('id','DESC');
        if ($request->customer_id){
            $empasin->where('customer_id', $request->customer_id);
        }
        if ($request->branch_id){
            $empasin->where('branch_id', $request->branch_id);
        }
        $empasin = $empasin->paginate(15);
        
        return view('southBangla.index',compact('empasin','customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobpost=JobPost::all();
        $customer=Customer::all();
        return view('southBangla.create',compact('customer','jobpost'));
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
        try{
            $data=new SouthBanglaAssign;
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->status = 0;
            if($data->save()){
                if($request->job_post_id){
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new SouthBanglaAssignDetails;
                            $details->south_bangla_assigns_id=$data->id;
                            $details->customer_id = $request->customer_id;
                            $details->branch_id = $request->branch_id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->service_rate=$request->service_rate[$key];
                            $details->save();
                        }
                    }
                }
            }
            DB::commit();
            if ($data->save()) {
                \LogActivity::addToLog('South Bangla Assign',$request->getContent(),'SouthBanglaAssign,SouthBanglaAssignDetails');
                return redirect()->route('southBanglaAssaign.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Crm\SouthBanglaAssign  $southBanglaAssign
     * @return \Illuminate\Http\Response
     */
    public function show(SouthBanglaAssign $southBanglaAssign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crm\SouthBanglaAssign  $southBanglaAssign
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jobpost=JobPost::all();
        $empasin = SouthBanglaAssign::findOrFail(encryptor('decrypt',$id));
        $customer=Customer::all();
        $branch = CustomerBrance::where('customer_id',$empasin->customer_id)->get();
        return view('southBangla.edit',compact('customer','jobpost','branch','empasin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crm\SouthBanglaAssign  $southBanglaAssign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $data= SouthBanglaAssign::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            $data->branch_id = $request->branch_id;
            $data->status = 0;
            if($data->save()){
                if($request->job_post_id){
                    SouthBanglaAssignDetails::where('south_bangla_assigns_id',$data->id)->delete();
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new SouthBanglaAssignDetails;
                            $details->south_bangla_assigns_id=$data->id;
                            $details->customer_id = $request->customer_id;
                            $details->branch_id = $request->branch_id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->duty_rate=$request->duty_rate[$key];
                            $details->service_rate=$request->service_rate[$key];
                            $details->save();
                        }
                    }
                }
            }
            DB::commit();
            if ($data->save()) {
                \LogActivity::addToLog('South Bangla Assign',$request->getContent(),'SouthBanglaAssign,SouthBanglaAssignDetails');
                return redirect()->route('southBanglaAssaign.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Crm\SouthBanglaAssign  $southBanglaAssign
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c=SouthBanglaAssign::findOrFail(encryptor('decrypt',$id));
        $dl=SouthBanglaAssignDetails::where('south_bangla_assigns_id',$c->id)->delete();
        $c->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
}
