<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CustomerRate;
use App\Models\Customer;
use App\Models\JobPost;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Exception;

class CustomerRateController extends Controller
{

    public function index(Request $request)
    {
        $crate=CustomerRate::where('customer_id',encryptor('decrypt',$request->customer_id));
        $customerName=Customer::where('id',encryptor('decrypt',$request->customer_id))->first();
        $customer_id=$request->customer_id;
        $crate=$crate->orderBy('id')->get();
        return view('customers.rate_crud.index',compact('crate','customer_id','customerName'));
    }

    public function rateCreateScreen(Request $request){
        $jobpost=JobPost::all();
        $cbran=Customer::findOrFail(encryptor('decrypt',$request->customer_id));
        return view('customers.rate_crud.create',compact('cbran','jobpost'));
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = new CustomerRate();
            $data->customer_id = $request->customer_id;
            $data->job_post_id = $request->job_post_id;
            $data->rate = $request->rate;
            $data->ot_rate = $request->ot_rate;
            $data->status = 1;
            if ($data->save()){
                return redirect(currentUser()."/customerRate?customer_id=".encryptor('encrypt',$request->customer_id))->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
