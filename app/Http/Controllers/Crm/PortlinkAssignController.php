<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\PortlinkAssign;
use App\Models\Crm\PortlinkAssignDetails;
use App\Models\Customer;
use App\Models\Hour;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Toastr;
use Carbon\Carbon;
use DB;
use Exception;

class PortlinkAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::select('id','name')->get();
        $empasin=PortlinkAssign::orderBy('id','DESC');
        if ($request->customer_id){
            $empasin->where('customer_id', $request->customer_id);
        }
        if ($request->branch_id){
            $empasin->where('branch_id', $request->branch_id);
        }
        $empasin = $empasin->paginate(15);
        
        return view('portlinkAssign.index',compact('empasin','customer'));
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
        $hours = Hour::get();
        return view('portlinkAssign.create',compact('customer','jobpost','hours'));
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
            $data=new PortlinkAssign;
            $data->customer_id = $request->customer_id;
            $data->status = 0;
            if($data->save()){
                if($request->job_post_id){
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new PortlinkAssignDetails;
                            $details->portlink_assign_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->qty=$request->qty[$key];
                            $details->rate=$request->rate[$key];
                            $details->commission=$request->commission[$key];
                            $details->start_date=$request->start_date[$key];
                            $details->end_date=$request->end_date[$key];
                            $details->hours=$request->hours[$key];
                            $details->status=1;
                            $details->save();
                        }
                    }
                }
            }
            DB::commit();
            if ($data->save()) {
                \LogActivity::addToLog('Portlink Assign',$request->getContent(),'PortlinkAssign,PortlinkAssignDetails');
                return redirect()->route('portlinkAssaign.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Crm\PortlinkAssign  $portlinkAssign
     * @return \Illuminate\Http\Response
     */
    public function show(PortlinkAssign $portlinkAssign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crm\PortlinkAssign  $portlinkAssign
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jobpost=JobPost::all();
        $empasin = PortlinkAssign::findOrFail(encryptor('decrypt',$id));
        $customer=Customer::where('id',$empasin->customer_id)->first();
        $hours = Hour::get();
        return view('portlinkAssign.edit',compact('jobpost','customer','empasin','hours'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crm\PortlinkAssign  $portlinkAssign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $data= PortlinkAssign::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            $data->status = 0;
            if($data->save()){
                if($request->job_post_id){
                    PortlinkAssignDetails::where('portlink_assign_id',$data->id)->delete();
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new PortlinkAssignDetails;
                            $details->portlink_assign_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->qty=$request->qty[$key];
                            $details->rate=$request->rate[$key];
                            $details->commission=$request->commission[$key];
                            $details->start_date=$request->start_date[$key];
                            $details->end_date=$request->end_date[$key];
                            $details->hours=$request->hours[$key];
                            $details->status=1;
                            $details->save();
                        }
                    }
                }
            }
            DB::commit();
            if ($data->save()) {
                \LogActivity::addToLog('Portlink Assign',$request->getContent(),'PortlinkAssign,PortlinkAssignDetails');
                return redirect()->route('portlinkAssaign.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Crm\PortlinkAssign  $portlinkAssign
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c=PortlinkAssign::findOrFail(encryptor('decrypt',$id));
        $dl=PortlinkAssignDetails::where('portlink_assign_id',$c->id)->delete();
        $c->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
}