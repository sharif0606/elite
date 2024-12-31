<?php

namespace App\Http\Controllers;

use App\Models\Customer;

use App\Models\Settings\Zone;

use Illuminate\Http\Request;
use App\Http\Requests\Crm\CustomerRequest;

use Toastr;
use Exception;
use App\Http\Traits\ImageHandleTraits;

class CustomerController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::select('id','name')->get();
        $data = Customer::with('zone');
        if ($request->customer_id){
            $data->where('id', $request->customer_id);
        }
        $data = $data->paginate(20);
        return view('customers.index',compact('data','customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones = Zone::all();
        return view('customers.create',compact('zones'));
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
            $data->contact = $request->contact;
            $data->address = $request->address;
            $data->bin = $request->bin;
            $data->invoice_number = $request->invoice_number;
            $data->file_upload_name = $request->file_upload_name;
            $data->zone_id = $request->zone_id;
            $data->received_by_city = $request->received_by_city;
            $data->customer_type = $request->customer_type;
            $data->inv_vat_note = $request->inv_vat_note;
            $data->contact_person = $request->contact_person;
            $data->billing_person = $request->billing_person;
            $data->agreement_date = $request->agreement_date;
            $data->renew_date = $request->renew_date;
            $data->validity_date = $request->validity_date;
            $data->vat = $request->vat;
            $data->take_home = $request->take_home;
            $data->royal_tea = $request->royal_tea;
            $data->ait = $request->ait;
            $data->received_by_city = $request->received_by_city;
            $data->attention = $request->attention;
            $data->attention_details = $request->attention_details;
            $data->header_note = $request->header_note;
            $data->footer_note = $request->footer_note;
            $data->status = 1;

            if($request->has('file_upload'))
            $data->file_upload=$this->uploadImage($request->file_upload,'uploads/customer/file_upload/');
            if($request->has('logo'))
            $data->logo=$this->uploadImage($request->logo,'uploads/logo/');

            if ($data->save()) {
                \LogActivity::addToLog('Add Customer',$request->getContent(),'Customer');
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
        
        $zones = Zone::all();
        $customer = Customer::findOrFail(encryptor('decrypt',$id));
        return view('customers.edit',compact('zones','customer'));
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
            $data->bin = $request->bin;
            $data->invoice_number = $request->invoice_number;
            $data->file_upload_name = $request->file_upload_name;
            $data->zone_id = $request->zone_id;
            $data->received_by_city = $request->received_by_city;
            $data->customer_type = $request->customer_type;
            $data->inv_vat_note = $request->inv_vat_note;
            $data->contact_person = $request->contact_person;
            $data->billing_person = $request->billing_person;
            $data->agreement_date = $request->agreement_date;
            $data->renew_date = $request->renew_date;
            $data->validity_date = $request->validity_date;
            $data->vat = $request->vat;
            $data->take_home = $request->take_home;
            $data->royal_tea = $request->royal_tea;
            $data->ait = $request->ait;
            $data->received_by_city = $request->received_by_city;
            $data->attention = $request->attention;
            $data->attention_details = $request->attention_details;
            $data->header_note = $request->header_note;
            $data->footer_note = $request->footer_note;
            $data->status = 1;

            if($request->has('file_upload'))
            $data->file_upload=$this->uploadImage($request->file_upload,'uploads/customer/file_upload/');
            if($request->has('logo'))
                $data->logo=$this->uploadImage($request->logo,'uploads/logo/');

            if ($data->save()) {
                \LogActivity::addToLog('Update Customer',$request->getContent(),'Customer');
                // Get the page number dynamically
                $page = $request->input('page', 1);
                return redirect()->route('customer.index', ['page' => $page])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
