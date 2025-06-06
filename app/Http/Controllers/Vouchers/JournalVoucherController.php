<?php

namespace App\Http\Controllers\Vouchers;

use App\Models\Vouchers\JournalVoucher;
use App\Models\Vouchers\JournalVoucherBkdn;
use App\Models\Vouchers\GeneralLedger;
use Illuminate\Http\Request;
use DB;
use Session;
use Exception;
use Toastr;
class JournalVoucherController extends VoucherController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journalVoucher=JournalVoucher::latest()->paginate(10);
        return view('voucher.journalVoucher.index',compact('journalVoucher'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('voucher.journalVoucher.create');
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
            $voucher_no = $this->create_voucher_no();
            if(!empty($voucher_no)){
                $jv=new JournalVoucher;
                $jv->voucher_no=$voucher_no;
                $jv->current_date=$request->current_date;
                $jv->pay_name=$request->pay_name;
                $jv->purpose=$request->purpose;
                $jv->credit_sum=$request->debit_sum;
                $jv->vou_no=$request->vou_no;
                $jv->vehicle_no=$request->vehicle_no;
                $jv->debit_sum=$request->debit_sum;
                $jv->cheque_no=$request->cheque_no;
                $jv->bank=$request->bank;
                $jv->cheque_dt=$request->cheque_dt;
                $jv->created_by=currentUserId();
				if($request->has('slip')){
					$imageName= rand(111,999).time().'.'.$request->slip->extension();
					$request->slip->move(public_path('uploads/slip'), $imageName);
					$jv->slip=$imageName;
				}
                if($jv->save()){
                    $account_codes=$request->account_code;
                    $table_id=$request->table_id;
                    $credit=$request->credit;
                    $debit=$request->debit;
					if(sizeof($account_codes)>0){
                        foreach($account_codes as $i=>$acccode){
                            $jvb=new JournalVoucherBkdn;
                            $jvb->journal_voucher_id=$jv->id;
                            $jvb->particulars=!empty($request->remarks[$i])?$request->remarks[$i]:"";
                            $jvb->account_code=!empty($acccode)?$acccode:"";
                            $jvb->table_name=!empty($request->table_name[$i])?$request->table_name[$i]:"";
                            $jvb->table_id=!empty($request->table_id[$i])?$request->table_id[$i]:"";
                            $jvb->debit=!empty($request->debit[$i])?$request->debit[$i]:0;
                            $jvb->credit=!empty($request->credit[$i])?$request->credit[$i]:0;
                            if($jvb->save()){
                                $table_name=$request->table_name[$i];
                                if($table_name=="master_accounts"){$field_name="master_account_id";}
    							else if($table_name=="sub_heads"){$field_name="sub_head_id";}
    							else if($table_name=="child_ones"){$field_name="child_one_id";}
    							else if($table_name=="child_twos"){$field_name="child_two_id";}
    							$gl=new Generalledger;
                                $gl->journal_voucher_id=$jv->id;
                                $gl->journal_title=!empty($acccode)?$acccode:"";
                                $gl->purpose=$request->purpose;
                                $gl->rec_date=$request->current_date;
                                $gl->jv_id=$voucher_no;
                                $gl->journal_voucher_bkdn_id=$jvb->id;
                                $gl->vou_no=$jv->vou_no;
                                $gl->vehicle_no=$jv->vehicle_no;
                                $gl->created_by=currentUserId();
                                $gl->dr=!empty($request->debit[$i])?$request->debit[$i]:0;
                                $gl->cr=!empty($request->credit[$i])?$request->credit[$i]:0;
                                $gl->{$field_name}=!empty($request->table_id[$i])?$request->table_id[$i]:"";
                                $gl->save();
                            }
                        }
                    }
                }
                DB::commit();
                \Toastr::success('Successfully created');
				//return redirect()->route('journal_voucher.index');
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
     * @param  \App\Models\Voucher\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(JournalVoucher $journalVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $journalVoucher=JournalVoucher::findOrFail(encryptor('decrypt',$id));
        //dd($journalVoucher);
		$jvbkdn=JournalVoucherBkdn::where('journal_voucher_id',encryptor('decrypt',$id))->get();
		return view('voucher.journalVoucher.edit',compact('journalVoucher','jvbkdn'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voucher\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $journalVoucher= JournalVoucher::findOrFail(encryptor('decrypt',$id));
            $journalVoucher->current_date = $request->current_date;
            $journalVoucher->pay_name = $request->pay_name;
            $journalVoucher->purpose = $request->purpose;
            $journalVoucher->cheque_no = $request->cheque_no;
            $journalVoucher->cheque_dt = $request->cheque_dt;
            $journalVoucher->bank = $request->bank;
            $journalVoucher->vou_no=$request->vou_no;
            $journalVoucher->vehicle_no=$request->vehicle_no;
            if($request->has('slip')){
                $imageName= rand(111,999).time().'.'.$request->slip->extension();
                $request->slip->move(public_path('uploads/slip'), $imageName);
                $journalVoucher->slip=$imageName;
            }
            if($journalVoucher->save()){
                $gldata=array('purpose'=>$request->purpose,'rec_date'=>$request->current_date,'vou_no'=>$request->vou_no,'vehicle_no'=>$request->vehicle_no);
                GeneralLedger::where('journal_voucher_id',$journalVoucher->id)->update($gldata);

			    \Toastr::success('Successfully Updated');
                return redirect()->route('journal_voucher.index');
            }

        }catch (Exception $e) {
            //dd($e);
            \Toastr::error('Please try again');
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
			$cvid=encryptor('decrypt',$id);
			$cv= JournalVoucher::find($cvid);
			if($cv->delete()){
				if(JournalVoucherBkdn::where('journal_voucher_id',$cvid)->delete()){
					if(GeneralLedger::where('journal_voucher_id',$cvid)->delete()){
						DB::commit();
						return redirect()->back()->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
					}else{
						return redirect()->back()->withInput()->with(Toastr::error('Plesae Try Again', 'Success', ["positionClass" => "toast-top-right"]));
					}
				}else{
					return redirect()->back()->withInput()->with(Toastr::error('Plesae Try Again', 'Success', ["positionClass" => "toast-top-right"]));
				}
			}else{
				return redirect()->back()->withInput()->with(Toastr::error('Plesae Try Again', 'Success', ["positionClass" => "toast-top-right"]));
			}
		}catch (Exception $e) {
			// dd($e);
			DB::rollBack();
			return redirect()->back()->withInput()->with(Toastr::error('Plesae Try Again', 'Success', ["positionClass" => "toast-top-right"]));
		}
    }
}
