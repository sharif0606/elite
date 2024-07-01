<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CustomerBrance;
use App\Models\Customer;
use App\Models\Settings\Zone;
use App\Models\Crm\Atm;
use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;

class CustomerBranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->all());
        $zone=Zone::all();
        $cbrance=CustomerBrance::where('customer_id',encryptor('decrypt',$request->customer_id));
        $customerName=Customer::where('id',encryptor('decrypt',$request->customer_id))->first();
        $customer_id=$request->customer_id;
        $cbrance=$cbrance->orderBy('id')->get();
        return view('customers.brance_index',compact('cbrance','customer_id','customerName','zone'));
    }

    public function createScreen(Request $request){
        $cbran=Customer::findOrFail(encryptor('decrypt',$request->customer_id));
        $zone=Zone::all();

        return view('customers.brance_create',compact('cbran','zone'));
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
        // dd($request->all());
        try {
            $data = new CustomerBrance();
            $data->customer_id = $request->customer_id;
            $data->brance_name = $request->brance_name;
            $data->contact_person = $request->contact_person;
            $data->contact_number = $request->contact_number;
            $data->billing_address = $request->billing_address;
            $data->billing_person = $request->billing_person;
            $data->agreement_date = $request->agreement_date;
            $data->renew_date = $request->renew_date;
            $data->validity_date = $request->validity_date;
            $data->vat = $request->vat;
            $data->take_home = $request->take_home;
            $data->royal_tea = $request->royal_tea;
            $data->ait = $request->ait;
            $data->attention = $request->attention;
            $data->attention_details = $request->attention_details;
            $data->received_by_city = $request->received_by_city;
            $data->zone_id = $request->zone_id;
            // $data->atm = $request->atm;
            $data->status = 1;
            if ($data->save()){
                if($request->atm){
                    foreach($request->atm as $key => $value){
                        if($value){
                            $at = new Atm;
                            $at->branch_id=$data->id;
                            $at->atm=$request->atm[$key];
                            $at->status=0;
                            $at->save();
                        }
                    }
                }
                \LogActivity::addToLog('Add Branch',$request->getContent(),'CustomerBrance,Atm');
                return redirect()->route('customerbrance.index',['customer_id='.encryptor('encrypt',$request->customer_id)])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
        $zone=Zone::all();
        $cdetails=CustomerBrance::findOrFail(encryptor('decrypt',$id));
        $customer=Customer::findOrFail($cdetails->customer_id);
        return view('customers.brance_edit',compact('customer','cdetails','zone'));
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
        try {
            $data = CustomerBrance::findOrFail(encryptor('decrypt',$id));
            $data->customer_id = $request->customer_id;
            $data->brance_name = $request->brance_name;
            $data->contact_person = $request->contact_person;
            $data->contact_number = $request->contact_number;
            $data->billing_address = $request->billing_address;
            $data->billing_person = $request->billing_person;
            $data->agreement_date = $request->agreement_date;
            $data->renew_date = $request->renew_date;
            $data->validity_date = $request->validity_date;
            $data->vat = $request->vat;
            $data->take_home = $request->take_home;
            $data->royal_tea = $request->royal_tea;
            $data->ait = $request->ait;
            $data->attention = $request->attention;
            $data->attention_details = $request->attention_details;
            $data->received_by_city = $request->received_by_city;
            $data->zone_id = $request->zone_id;
            // $data->atm = $request->atm;
            $data->status = 1;
            if ($data->save()){
                if($request->atm){
                    $dl=Atm::where('branch_id',$data->id)->delete();
                    foreach($request->atm as $key => $value){
                        if($value){
                            $at = new Atm;
                            $at->branch_id=$data->id;
                            $at->atm=$request->atm[$key];
                            $at->status=0;
                            $at->save();
                        }
                    }
                }
                \LogActivity::addToLog('Update Branch',$request->getContent(),'CustomerBrance,Atm');
                return redirect("admin/customerbrance?customer_id=".encryptor('encrypt',$request->customer_id))->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }

        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cbrance=CustomerBrance::findOrFail(encryptor('decrypt',$id));
        $cbrance->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
}
