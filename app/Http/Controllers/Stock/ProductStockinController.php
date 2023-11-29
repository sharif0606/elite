<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock\Product;
use App\Models\Stock\ProductSize;
use App\Models\Stock\ProductStockin;
use App\Models\Stock\Stock;
use App\Models\Employee\Employee;
use App\Http\Traits\ImageHandleTraits;
use Exception;
use DB;
use Toastr;
use Illuminate\Support\Carbon;

class ProductStockinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockin=ProductStockin::all();
        return view('Stock.productStockin.index',compact('stockin'));
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
        return view('Stock.productStockin.create',compact('product','size','employee'));
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
            $pin=new ProductStockin;
            $pin->product_id=$request->product_id;
            $pin->employee_id=$request->employee_id;
            $pin->size_id=$request->size_id;
            $pin->entry_date=$request->entry_date;
            $pin->product_qty=$request->product_qty;
            $pin->type=$request->type;
            if($pin->save()){
                $stock=new Stock;
                $stock->product_id=$request->product_id;
                $stock->employee_id=$request->employee_id;
                $stock->size_id=$request->size_id;
                $stock->entry_date=$request->entry_date;
                $stock->product_qty=$request->product_qty;
                $stock->type=$request->type;
                $stock->status=0;
                $stock->save();
                return redirect()->route(currentUser().'.product_stockin.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        }catch(Exception $e){
            // dd($e);
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
        $size=ProductSize::all();
        $product=Product::all();
        $stockin=ProductStockin::findOrFail(encryptor('decrypt',$id));
        return view('Stock.productStockin.edit',compact('product','size','stockin'));
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
            $product=ProductStockin::findOrFail(encryptor('decrypt',$id));
            $product->product_id=$request->product_id;
            $product->size_id=$request->size_id;
            $product->entry_date=$request->entry_date;
            $product->product_qty=$request->product_qty;
            $product->type=$request->type;
            if($product->save()){
                return redirect()->route(currentUser().'.product_stockin.index')->with(Toastr::success('Data Update!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        }catch(Exception $e){
            // dd($e);
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
