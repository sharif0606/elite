<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock\Stock;
use App\Models\Stock\Product;
use DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product = Product::all();
        $where = '';
        if ($request->fdate) {
            $tdate = $request->tdate ? $request->tdate : $request->fdate;
            $where = " AND date(stocks.`created_at`) BETWEEN '" . $request->fdate . "' AND '" . $tdate . "'";
        }

        if ($request->product) {
            $where .= " AND products.id = '" . $request->product . "'";
        }

        $stock=DB::select("SELECT products.product_name,stocks.product_id,sum(stocks.product_qty) as qty,product_sizes.name FROM `stocks` join products on products.id=stocks.product_id join product_sizes on product_sizes.id=stocks.size_id " . $where . " group by stocks.product_id,stocks.size_id order by stocks.product_id,product_sizes.name");
        return view('Stock.stock.list',compact('stock','product'));
    }

    public function stockindividual(Request $request,$id)
    {
        //$company = company()['company_id'];
        $stock = Stock::where('product_id',(encryptor('decrypt',$id)));
        if ($request->fdate) {
            $tdate = $request->tdate ? $request->tdate : $request->fdate;
            $stock =$stock->whereBetween('entry_date',[$request->fdate, $tdate]);
        }
        $stock = $stock->get();
        $product = Product::where('id',(encryptor('decrypt',$id)))->first();

        return view('Stock.stock.stockReportIndividual', compact('stock','product'));
    }
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
