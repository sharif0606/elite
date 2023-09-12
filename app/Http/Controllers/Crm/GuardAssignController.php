<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Customer;
use App\Models\Crm\GuardAssign;
use App\Models\Crm\GuardAssignDetails;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;

class GuardAssignController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guards=GuardAssign::all();
        return view('guards_assign.index',compact('guards'));
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
        return view('guards_assign.create',compact('customer','jobpost'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data=new GuardAssign;
            $data->customer_id = $request->customer_id;
            $data->status = 0;
            if($data->save()){
                if($request->job_post_id){
                    foreach($request->job_post_id as $key => $value){
                        if($value){
                            $details = new GuardAssignDetails;
                            $details->guard_id=$data->id;
                            $details->job_post_id=$request->job_post_id[$key];
                            $details->qty=$request->qty[$key];
                            $details->rate=$request->rate[$key];
                            $details->start_date=$request->start_date[$key];
                            $details->end_date=$request->end_date[$key];
                            $details->status=1;
                            $details->save();
                            }
                        }
                    }
                }
                if ($data->save()) {
                    return redirect()->route('guard.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
                } else {
                    return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
                }

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
}
