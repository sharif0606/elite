<?php

namespace App\Http\Controllers\Vouchers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnlinePayment;

class OnlinePaymentController extends Controller
{
    
    public function index(){
        $data=OnlinePayment::where('status',1)->latest()->get();
        return view("voucher.onlinepayment.index",compact('data'));
    }
    public function accepted(){
        $data=OnlinePayment::where('status',3)->latest()->get();
        return view("voucher.onlinepayment.accepted",compact('data'));
    }

    public function update_status($id,$status){
        try {
            $data=OnlinePayment::find(encryptor('decrypt',$id));
            $data->status=$status;
            if($data->save()){
                \Toastr::success('Successfully Updated');
                return redirect()->back();
            }
        }catch (Exception $e) {
            // dd($e);
            \Toastr::error('Please try again');
            return redirect()->back();
        }
    }
}
