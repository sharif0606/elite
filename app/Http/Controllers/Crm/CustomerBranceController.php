<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CustomerBrance;
use App\Models\Customer;
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
        // dd($request->all());
        $cbrance=CustomerBrance::where('customer_id',encryptor('decrypt',$request->customer_id));
        $customer_id=$request->customer_id;
        $cbrance=$cbrance->orderBy('id')->get();
        return view('customers.brance_index',compact('cbrance','customer_id'));
    }

    public function createScreen(Request $request){
        $cbran=Customer::findOrFail(encryptor('decrypt',$request->customer_id));

        return view('customers.brance_create',compact('cbran'));
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
            $data->received_by_city = $request->received_by_city;
            $data->zone = $request->zone;
            $data->status = 1;
            if ($data->save()){
                return redirect(currentUser()."/customerbrance?customer_id=".encryptor('encrypt',$request->customer_id))->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
