<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Settings\Location\District;
use App\Models\Settings\Location\Upazila;
use App\Models\Settings\Location\Union;
use App\Models\Settings\Location\Ward;

use Illuminate\Http\Request;
use App\Http\Requests\Crm\CustomerRequest;

use Toastr;
use Carbon\Carbon;
use DB;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate(20);
        return view('customers.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = District::all();
        $upazila = Upazila::all();
        $union = Union::all();
        $ward = Ward::all();
        return view('customers.create',compact('districts','upazila','union','ward'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        try {
            $data = new Customer();
            $data->name = $request->name;
            // $data->brance_name = $request->brance_name;
            $data->contact = $request->contact;
            $data->address = $request->address;
            $data->file_upload_name = $request->file_upload_name;
            // $data->contact_person = $request->contact_person;
            // $data->contact_number = $request->contact_number;
            // $data->billing_address = $request->billing_address;
            // $data->billing_person = $request->billing_person;
            // $data->agreement_date = $request->agreement_date;
            // $data->renew_date = $request->renew_date;
            // $data->validity_date = $request->validity_date;
            $data->status = 1;


            if($request->has('file_upload'))
            $data->file_upload=$this->uploadImage($request->file_upload,'uploads/customer/file_upload/');
            if($request->has('logo'))
            $data->logo=$this->uploadImage($request->logo,'uploads/logo/');

            if ($data->save()) {
                return redirect()->route('customer.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail(encryptor('decrypt',$id));
        return view('customers.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $districts = District::all();
        $upazila = Upazila::all();
        $union = Union::all();
        $ward = Ward::all();
        $customer = Customer::findOrFail(encryptor('decrypt',$id));
        return view('customers.edit',compact('districts','upazila','union','ward','customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Customer::findOrFail(encryptor('decrypt',$id));
            $data->name = $request->name;
            // $data->brance_name = $request->brance_name;
            $data->contact = $request->contact;
            $data->address = $request->address;
            $data->file_upload_name = $request->file_upload_name;
            // $data->contact_person = $request->contact_person;
            // $data->contact_number = $request->contact_number;
            // $data->billing_address = $request->billing_address;
            // $data->billing_person = $request->billing_person;
            // $data->agreement_date = $request->agreement_date;
            // $data->renew_date = $request->renew_date;
            // $data->validity_date = $request->validity_date;
            $data->status = 1;

            if($request->has('file_upload'))
            $data->file_upload=$this->uploadImage($request->file_upload,'uploads/customer/file_upload/');
            if($request->has('logo'))
                $data->logo=$this->uploadImage($request->logo,'uploads/logo/');

            if ($data->save()) {
                return redirect()->route('customer.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }

        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c=Customer::findOrFail(encryptor('decrypt',$id));
        $c->delete();
        return redirect()->back()->with(Toastr::error('Data Deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
}
