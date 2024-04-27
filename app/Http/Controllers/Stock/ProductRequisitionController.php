<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock\ProductRequisition;
use App\Models\Stock\Product;
use App\Models\Stock\ProductSize;
use App\Models\Employee\Employee;
use App\Models\Stock\ProductRequisitionDetails;
use App\Models\Stock\ProductStockin;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Stock\Stock;
use App\Http\Requests\Stock\ProductIssue\AddProductIssue;
use Exception;
use DB;
use Toastr;
use Illuminate\Support\Carbon;

class ProductRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employee=Employee::select('id','bn_applicants_name','admission_id_no')->get();
        $requisition=ProductRequisition::orderBy('id', 'DESC');
        if($request->employee_id)
        $requisition=$requisition->where('employee_id','like','%'.$request->employee_id.'%');
        $requisition=$requisition->paginate(12);
        return view('Stock.productrequisition.index',compact('requisition','employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $size=ProductSize::all();
        $product=Product::all();
        $product_issue=Product::where('is_issue','1')->get();
        $employee=Employee::select('id','bn_applicants_name','admission_id_no')->get();
        return view('Stock.productrequisition.create',compact('product','size','employee','product_issue'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProductIssue $request)
    {
        //dd($request->all());
        try{
            $data=new ProductRequisition;
            if($request->employee_id){
                $data->employee_id=$request->employee_id;
            }else{
                $employee= new Employee;
                $employee->admission_id_no=$request->manual_employee_id;
                $employee->bn_applicants_name=$request->bn_applicants_name;
                $employee->save();
                $data->employee_id=$employee->id;
            }
            // $data->issue_date=$request->issue_date;
            $originalDate = $request->issue_date;
            $formattedDate = Carbon::createFromFormat('d/m/Y', $originalDate)->format('Y-m-d');
            $data->issue_date = $formattedDate;
            $data->note=$request->note;
            if($data->save()){
                if($request->product_id){
                    foreach($request->product_id as $key => $value){
                        if($value){
                            $details = new ProductRequisitionDetails;
                            $details->product_requisition_id=$data->id;
                            $details->product_id=$request->product_id[$key];
                            $details->size_id=$request->size_id[$key];
                            $details->product_qty=$request->product_qty[$key];
                            $details->type=$request->type[$key];
                            if($details->save()){
                                $stock=new Stock;
                                $stock->employee_id=$request->employee_id;
                                $stock->product_requisition_id=$data->id;
                                $stock->product_issue_id=$details->id;
                                $stock->entry_date=$formattedDate;
                                $stock->note=$request->note;
                                $stock->product_id=$request->product_id[$key];
                                $stock->size_id=$request->size_id[$key];
                                $stock->product_qty='-'.$request->product_qty[$key];
                                $stock->type=$request->type[$key];
                                $stock->status=1;
                                $stock->save();
                            }
                        }
                    }
                }
                \LogActivity::addToLog('Add Issue',$request->getContent(),'ProductRequisition,ProductRequisitionDetails,Stock');
                return redirect()->route('product_issue.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
        $requisition = ProductRequisition::findOrFail(encryptor('decrypt',$id));
        return view('Stock.productrequisition.show',compact('requisition'));
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
        $data= ProductRequisition::findOrFail(encryptor('decrypt',$id));
        $tdl=ProductRequisitionDetails::where('product_requisition_id',$data->id)->delete();
        $tl=Stock::where('product_requisition_id',$data->id)->delete();
        $data->delete();
        Toastr::error('Opps!! You Delete Permanently!!');
        return redirect()->back();
    }
}
