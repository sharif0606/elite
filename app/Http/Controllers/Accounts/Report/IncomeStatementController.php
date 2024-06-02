<?php

namespace App\Http\Controllers\Accounts\Report;

use App\Http\Controllers\Controller;

use App\Models\Vouchers\GeneralLedger;
use App\Models\Accounts\Master_account;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use Exception;
use DB;

class IncomeStatementController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        $month=$r->imonth ?: \Carbon\Carbon::now()->format('m');
        $year=$r->iyear ?: \Carbon\Carbon::now()->format('Y');
        $acc_head=Master_account::all();
        /* operating income */
        $incomeheadop=array();
        $incomeheadopone=array();
        $incomeheadoptwo=array();
        /* nonoperating income */
        $incomeheadnop=array();
        $incomeheadnopone=array();
        $incomeheadnoptwo=array();

        /* operating expense */
        $expenseheadop=array();
        $expenseheadopone=array();
        $expenseheadoptwo=array();
        /* nonoperating expense */
        $expenseheadnop=array();
        $expenseheadnopone=array();
        $expenseheadnoptwo=array();
        $tax_data=array();

        foreach($acc_head as $ah){
            if($ah->head_code=="4000"){
                if($ah->sub_head){
                    foreach($ah->sub_head as $sub_head){
                        if($sub_head->head_code=="4100"){/* operating income */
                            if($sub_head->child_one->count() > 0){
                                foreach($sub_head->child_one as $child_one){
                                    if($child_one->child_two->count() > 0){
                                        foreach($child_one->child_two as $child_two){
                                            $incomeheadoptwo[]=$child_two->id;
                                        }
                                    }else{
                                        $incomeheadopone[]=$child_one->id;
                                    }
                                }
                            }else{
                                $incomeheadop[]=$sub_head->id;
                            }
                        }else if ($sub_head->head_code=="4200"){ /* nonoperating income */
                            if($sub_head->child_one->count() > 0){
                                foreach($sub_head->child_one as $child_one){
                                    if($child_one->child_two->count() > 0){
                                        foreach($child_one->child_two as $child_two){
                                            $incomeheadnoptwo[]=$child_two->id;
                                        }
                                    }else{
                                        $incomeheadnopone[]=$child_one->id;
                                    }
                                }
                            }else{
                                $incomeheadnop[]=$sub_head->id;
                            }
                        }
                    }
                }
            }else if($ah->head_code=="5000"){
                if($ah->sub_head){
                    foreach($ah->sub_head as $sub_head){
                        if($sub_head->head_code=="5100"){/* operating expense */
                            if($sub_head->child_one->count() > 0){
                                foreach($sub_head->child_one as $child_one){
                                    if($child_one->child_two->count() > 0){
                                        foreach($child_one->child_two as $child_two){
                                            $expenseheadoptwo[]=$child_two->id;
                                        }
                                    }else{
                                        $expenseheadopone[]=$child_one->id;
                                    }
                                }
                            }else{
                                $expenseheadop[]=$sub_head->id;
                            }
                        }else if ($sub_head->head_code=="5200"){ /* nonoperating expense */
                            if($sub_head->child_one->count() > 0){
                                foreach($sub_head->child_one as $child_one){
                                    if($child_one->child_two->count() > 0){
                                        foreach($child_one->child_two as $child_two){
                                            $expenseheadnoptwo[]=$child_two->id;
                                        }
                                    }else{
                                        if($child_one->head_code!="53001")
                                            $expenseheadnopone[]=$child_one->id;
                                        else
                                            $tax_data[]=$child_one->id;
                                    }
                                }
                            }else{
                                $expenseheadnop[]=$sub_head->id;
                            }
                        }
                    }
                }
            }
        }

        if($month){
            $datas=$year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-01";
            $datae=$year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-31";
        }else{
            $datas=$year."-01-01";
            $datae=$year."-12-31";
        }

        //\DB::connection()->enableQueryLog();
        /* operating income */
        $opincome=GeneralLedger::select([DB::raw("SUM(cr) as cr"), DB::raw("SUM(dr) as dr"),DB::raw("journal_title")])->whereBetween('rec_date',[$datas,$datae])
        ->where(function($query) use ($incomeheadop,$incomeheadopone,$incomeheadoptwo){
            $query->orWhere(function($query) use ($incomeheadop){
                    $query->whereIn('sub_head_id',$incomeheadop);
            });
            $query->orWhere(function($query) use ($incomeheadopone){
                    $query->whereIn('child_one_id',$incomeheadopone);
            });
            $query->orWhere(function($query) use ($incomeheadoptwo){
                    $query->whereIn('child_two_id',$incomeheadoptwo);
            });
        })
        ->groupBy('sub_head_id','child_one_id','child_two_id')
        ->get();

        //$queries = \DB::getQueryLog();
        //dd($queries);
        /* nonoperating income */
        $nonopincome=GeneralLedger::select([DB::raw("SUM(cr) as cr"), DB::raw("SUM(dr) as dr"),DB::raw("journal_title")])->whereBetween('rec_date',[$datas,$datae])
        ->where(function($query) use ($incomeheadnop,$incomeheadnopone,$incomeheadnoptwo){
            if($incomeheadnop){
                $query->orWhere(function($query) use ($incomeheadnop){
                        $query->whereIn('sub_head_id',$incomeheadnop);
                });
            }
            if($incomeheadnopone){
                $query->orWhere(function($query) use ($incomeheadnopone){
                        $query->whereIn('child_one_id',$incomeheadnopone);
                });
            }
            if($incomeheadnoptwo){
                $query->orWhere(function($query) use ($incomeheadnoptwo){
                        $query->whereIn('child_two_id',$incomeheadnoptwo);
                });
            }
        })
        ->groupBy('sub_head_id','child_one_id','child_two_id')
        ->get();

        /* operating expense */
        $opexpense=GeneralLedger::select([DB::raw("SUM(cr) as cr"), DB::raw("SUM(dr) as dr"),DB::raw("journal_title")])->whereBetween('rec_date',[$datas,$datae])
        ->where(function($query) use ($expenseheadop,$expenseheadopone,$expenseheadoptwo){
            if($expenseheadop){
                $query->orWhere(function($query) use ($expenseheadop){
                        $query->whereIn('sub_head_id',$expenseheadop);
                });
            }
            if($expenseheadopone){
                $query->orWhere(function($query) use ($expenseheadopone){
                        $query->whereIn('child_one_id',$expenseheadopone);
                });
            }
            if($expenseheadoptwo){
                $query->orWhere(function($query) use ($expenseheadoptwo){
                        $query->whereIn('child_two_id',$expenseheadoptwo);
                });
            }
        })
        ->groupBy('sub_head_id','child_one_id','child_two_id')
        ->get();
        /* nonoperating expense */
        $nonopexpense=GeneralLedger::select([DB::raw("SUM(cr) as cr"), DB::raw("SUM(dr) as dr"),DB::raw("journal_title")])->whereBetween('rec_date',[$datas,$datae])
        ->where(function($query) use ($expenseheadnop,$expenseheadnopone,$expenseheadnoptwo){
            $query->orWhere(function($query) use ($expenseheadnop){
                    $query->whereIn('sub_head_id',$expenseheadnop);
            });
            $query->orWhere(function($query) use ($expenseheadnopone){
                    $query->whereIn('child_one_id',$expenseheadnopone);
            });
            $query->orWhere(function($query) use ($expenseheadnoptwo){
                    $query->whereIn('child_two_id',$expenseheadnoptwo);
            });
        })
        ->groupBy('sub_head_id','child_one_id','child_two_id')
        ->get();
        /* tax expense */
        $taxamount=GeneralLedger::select([DB::raw("SUM(cr) as cr"), DB::raw("SUM(dr) as dr"),DB::raw("journal_title")])->whereBetween('rec_date',[$datas,$datae])
        ->where(function($query) use ($tax_data){
            $query->orWhere(function($query) use ($tax_data){
                    $query->whereIn('child_one_id',$tax_data);
            });
        })
        ->groupBy('sub_head_id','child_one_id','child_two_id')
        ->get();

        $res=array(
            "opincome"=>$opincome,
            "nonopincome"=>$nonopincome,
            "opexpense"=>$opexpense,
            "nonopexpense"=>$nonopexpense,
            "taxamount"=>$taxamount
        );
        return view('accounts.incomeStatement.index',compact("opincome","nonopincome","opexpense","nonopexpense","taxamount"));
    }

}
