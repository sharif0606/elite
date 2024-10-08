<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\InvoiceSetting;
use App\Http\Traits\ImageHandleTraits;
use Exception;
use DB;
use Toastr;
use Illuminate\Support\Carbon;

class InvoiceSettingController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoicesettings=InvoiceSetting::all();
        return view('settings.invoicesetting.index',compact('invoicesettings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $invoicesettings=InvoiceSetting::findOrFail(encryptor('decrypt',$id));
        return view('settings.invoicesetting.edit',compact('invoicesettings'));
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
        try{
            $c=InvoiceSetting::findOrFail(encryptor('decrypt',$id));
            $c->name=$request->name;
            $c->designation=$request->designation;
            $c->phone=$request->phone;
            if($request->has('signature_img')){
                $c->signature=$this->uploadImage($request->signature_img,'uploads/invoice/signatureImg/');
            }
            $c->status=1;
            if($c->save()){
                \LogActivity::addToLog('Update InvoiceSetting',$request->getContent(),'InvoiceSetting');
                return redirect()->route('invoicesetting.index')->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        }catch(Exception $e){
            //dd($e);
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
        //
    }
}
