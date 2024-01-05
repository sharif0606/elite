<?php

namespace App\Http\Controllers\Vouchers;

use App\Http\Controllers\Controller;

use App\Models\Vouchers\MemberVoucher;
use App\Models\Vouchers\MemberVoucherBkdn;
use App\Models\Vouchers\GeneralLedger;
use App\Models\OurMember;
use App\Models\MembershipType;
use Illuminate\Http\Request;
use App\Models\Accounts\Sub_head;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;

use DB;
use Session;
use Exception;
use Toastr;

class MemberVoucherController extends VoucherController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberVoucher= MemberVoucher::paginate(10);
        return view('voucher.memberVoucher.index',compact('memberVoucher'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paymethod=$this->incomeHead();
        $membertype= MembershipType::get();
        return view('voucher.memberVoucher.create',compact('paymethod','membertype'));
    }
    public function incomeHead(){
        $paymethod=array();
        $account_data=Sub_head::where('head_code',4100)->first();
        
        if($account_data){
            $childonehead=Child_one::where('sub_head_id',$account_data->id);
            if($childonehead->count() > 0){
                $childonehead=$childonehead->get();
                foreach($childonehead as $coh){
                    $childtwohead=Child_two::where('child_one_id',$coh->id);
                    if($childtwohead->count() > 0){
                        $childtwohead=$childtwohead->get();
                        foreach($childtwohead as $sh){
                            $paymethod[]=array(
                                            'id'=>$sh->id,
                                            'head_code'=>$sh->head_code,
                                            'head_name'=>$sh->head_name,
                                            'table_name'=>'child_twos'
                                        );
                        }
                    }else{
                        $paymethod[]=array(
                            'id'=>$coh->id,
                            'head_code'=>$coh->head_code,
                            'head_name'=>$coh->head_name,
                            'table_name'=>'child_twos'
                        );
                    }
                }
            }else{
                $paymethod[]=array(
                    'id'=>$account_data->id,
                    'head_code'=>$account_data->head_code,
                    'head_name'=>$account_data->head_name,
                    'table_name'=>'child_ones'
                );
            }
                
            
        }

        return $paymethod;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try {
            DB::beginTransaction();
            
            if($request->member_type)
                $member=OurMember::where('status',2)->where('membership_applied',$request->member_type)->pluck('id');
            else
                $member=OurMember::where('status',2)->pluck('id');

            if($member){
                $voucher_no = $this->create_voucher_no();
                if(!empty($voucher_no)){
                    $jv=new MemberVoucher;
                    $jv->voucher_no=$voucher_no;
                    $jv->member_id=$request->member_type;
                    $jv->current_date=$request->current_date;
                    $jv->eyear=$request->year;
                    $jv->emonth=$request->month;
                    $jv->pay_name=$request->pay_name;
                    $jv->purpose=$request->purpose;
                    $jv->credit_sum=$request->debit_sum*count($member);
                    $jv->debit_sum=$request->debit_sum*count($member);
                    $jv->created_by=currentUserId();
                    if($jv->save()){
                        $account_codes=$request->account_code;
                        $credit=$request->credit;
                        $debit=$request->debit;

                        
                        foreach($member as $mem){
                            $headdata=Child_two::where('head_code',"1130".$mem)->first();
                            // echo $mem;
                            //  print_r($headdata);
                            // // print_r($member);
                            //  die();
                            $jvb=new MemberVoucherBkdn;
                            $jvb->member_id=$mem;
                            $jvb->eyear=$request->year;
                            $jvb->emonth=$request->month;
                            $jvb->member_voucher_id=$jv->id;
                            $jvb->particulars="Due";
                            $jvb->account_code=$headdata->head_code.'-'.$headdata->head_name;
                            $jvb->table_name="child_twos";
                            $jvb->table_id=$headdata->id;
                            $jvb->debit=$request->debit_sum;
                            if($jvb->save()){
                                $gl=new GeneralLedger;
                                $gl->member_voucher_id=$jv->id;
                                $gl->journal_title=$jvb->account_code;
                                $gl->purpose=$request->purpose;
                                $gl->rec_date=$request->current_date;
                                $gl->jv_id=$voucher_no;
                                $gl->member_voucher_bkdn_id=$jvb->id;
                                $gl->created_by=currentUserId();
                                $gl->dr=$request->debit_sum;
                                $gl->child_two_id=$jvb->table_id;
                                $gl->save();
                            }
                        }
                        if(sizeof($account_codes)>0){
                            foreach($account_codes as $i=>$acccode){
                                $acccode=explode('~',$acccode);
                                $jvb=new MemberVoucherBkdn;
                                $jvb->member_voucher_id=$jv->id;
                                $jvb->eyear=$request->year;
                                $jvb->emonth=$request->month;
                                $jvb->particulars=!empty($request->remarks[$i])?$request->remarks[$i]:"";
                                $jvb->account_code=$acccode[2];
                                $jvb->table_name=$acccode[0];
                                $jvb->table_id=$acccode[1];
                                $jvb->credit=!empty($request->debit[$i])?($request->debit[$i]*count($member)):0;
                                if($jvb->save()){
                                    $table_name=$acccode[0];
                                    if($table_name=="master_accounts"){$field_name="master_account_id";}
                                    else if($table_name=="sub_heads"){$field_name="sub_head_id";}
                                    else if($table_name=="child_ones"){$field_name="child_one_id";}
                                    else if($table_name=="child_twos"){$field_name="child_two_id";}
                                    $gl=new GeneralLedger;
                                    $gl->member_voucher_id=$jv->id;
                                    $gl->journal_title=$jvb->account_code;
                                    $gl->purpose=$request->purpose;
                                    $gl->rec_date=$request->current_date;
                                    $gl->jv_id=$voucher_no;
                                    $gl->member_voucher_bkdn_id=$jvb->id;
                                    $gl->created_by=currentUserId();
                                    $gl->cr=$jvb->credit;
                                    $gl->{$field_name}=!empty($request->table_id[$i])?$request->table_id[$i]:"";
                                    $gl->save();
                                }
                            }
                        }
                        DB::commit();
                    }
                    
                    \Toastr::success('Successfully created');
                    return redirect()->route('member_voucher.index');
                }
            }else{
                \Toastr::error('No memver found');
                return redirect()->back()->withInput();
            }
		}catch (Exception $e) {
			dd($e);
			\Toastr::error('Please try again');
			DB::rollBack();
			return redirect()->back()->withInput();
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemberVoucher  $creditVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(MemberVoucher $creditVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberVoucher  $creditVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $membertype= MembershipType::get();
        $memberVoucher=MemberVoucher::findOrFail(encryptor('decrypt',$id));
		$membervoucherbkdn=MemberVoucherBkdn::where('member_voucher_id',encryptor('decrypt',$id))->get();
		return view('voucher.memberVoucher.edit',compact('memberVoucher','membervoucherbkdn','membertype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberVoucher  $creditVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $id=encryptor('decrypt',$id);
            if(!empty($id)){
                $jv= MemberVoucher::findOrFail($id);
                $jv->current_date = $request->current_date;
                $jv->pay_name = $request->pay_name;
                $jv->purpose = $request->purpose;
                
                if($jv->save()){
                    $gldata=array('purpose'=>$request->purpose,'rec_date'=>$request->current_date);
                    GeneralLedger::where('member_voucher_id',$id)->update($gldata);
                    DB::commit();
                }
				\Toastr::success('Successfully Updated');
                return redirect()->route('member_voucher.index');
			}
		}catch (Exception $e) {
			\Toastr::error('Please try again');
			DB::rollBack();
			return redirect()->back()->withInput();
		}
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberVoucher  $creditVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberVoucher $creditVoucher)
    {
        //
    }
}