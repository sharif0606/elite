<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock\Product;
use App\Models\Stock\ProductSize;
use App\Models\Stock\ProductDamage;
use App\Models\Employee\Employee;
use App\Models\Stock\Stock;
use App\Http\Traits\ImageHandleTraits;
use App\Models\User;
use Exception;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class ProductDamageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product=Product::select('id','product_name')->get();
        $damage=ProductDamage::orderBy('id', 'DESC');
        if($request->product_id)
        $damage=$damage->where('product_id','like','%'.$request->product_id.'%');
        $damage=$damage->paginate(12);
        return view('Stock.damage.index',compact('damage','product'));
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
        return view('Stock.damage.create',compact('product','size','employee'));
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
            $damage=new ProductDamage;
            $damage->product_id=$request->product_id;
            // $damage->employee_id=$request->employee_id;
            $damage->size_id=$request->size_id;
            $damage->entry_date=$request->entry_date;
            $damage->product_qty=$request->product_qty;
            $damage->type=$request->type;
            if($damage->save()){
                $stock=new Stock;
                $stock->product_id=$request->product_id;
                $stock->product_condem_id=$damage->id;
                $stock->employee_id=$request->employee_id;
                $stock->size_id=$request->size_id;
                $stock->entry_date=$request->entry_date;
                $stock->product_qty='-'.$request->product_qty;
                $stock->type=$request->type;
                $stock->status=2;
                $stock->save();
                \LogActivity::addToLog('Add Damage',$request->getContent(),'ProductDamage,Stock');
                return redirect()->route('productdamage.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $data= ProductDamage::findOrFail(encryptor('decrypt',$id));
    //     $tl=Stock::where('product_condem_id',$data->id)->delete();
    //     $data->delete();
    //     Toastr::error('Opps!! You Delete Permanently!!');
    //     return redirect()->back();
    // }
    public function damageProductDelete(Request $request)
    {
        $user= User::where('id',currentUserId())->first();
        if($user){
            if(!Hash::check($request->password, $user->password)){
                Toastr::error('Opps!! Your provided password not matched!');
                return redirect()->back();
            }else{
                $data= ProductDamage::where('id',$request->product_id)->first();
                Stock::where('product_condem_id',$data->id)->delete();
                $data->delete();
                Toastr::success('You Delete Permanently!!');
                return redirect()->back();
            }
        }
    }
}
