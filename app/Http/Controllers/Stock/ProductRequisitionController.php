<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock\ProductRequisition;
use App\Models\Stock\Product;
use App\Models\Stock\ProductSize;
use App\Models\Employee\Employee;
use App\Http\Traits\ImageHandleTraits;
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
    public function index()
    {
        $requisition=ProductRequisition::all();
        return view('Stock.productrequisition.index',compact('requisition'));
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
        $employee=Employee::select('id','bn_applicants_name','admission_id_no')->get();
        return view('Stock.productrequisition.create',compact('product','size','employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $product=new ProductRequisition;
            $product->product_id=$request->product_id;
            $product->size_id=$request->size_id;
            $product->employee_id=$request->employee_id;
            $product->issue_date=$request->issue_date;
            $product->product_qty=$request->product_qty;
            $product->type=$request->type;
            $product->note=$request->note;
            if($product->save()){
                return redirect()->route(currentUser().'.requisition.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        }catch(Exception $e){
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
