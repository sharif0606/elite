<?php

namespace App\Http\Controllers\Settings\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\Location\Upazila;
use App\Models\Settings\Location\Union;
use App\Http\Traits\ResponseTrait;
use Exception;

class UnionController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unions=Union::paginate(50);
        return view('settings.location.union.index',compact('unions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $upazilas=Upazila::all();
        return view('settings.location.union.create',compact('upazilas'));
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
            $union=new Union;
            $union->upazila_id=$request->upazila_id;
            $union->name=$request->unionName;
            $union->name_bn=$request->unionBn;
            if($union->save())
                return redirect()->route('union.index')->with($this->resMessageHtml(true,null,'Successfully created'));
            else
                return redirect()->back()->withInput()->with($this->resMessageHtml(false,'error','please try again'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->withInput()->with($this->resMessageHtml(false,'error','Please try again'));
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
        $upazilas=Upazila::all();
        $union= Union::findOrFail(encryptor('decrypt',$id));
        return view('settings.location.union.edit',compact('union','upazilas'));
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
            $union= Union::findOrFail(encryptor('decrypt',$id));
            $union->upazila_id=$request->upazila_id;
            $union->name=$request->unionName;
            $union->name_bn=$request->unionBn;
            if($union->save())
                return redirect()->route('union.index')->with($this->resMessageHtml(true,null,'Successfully update'));
                else
                return redirect()->back()->withInput()->with($this->resMessageHtml(false,'error','Please try again'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->withInput()->with($this->resMessageHtml(false,'error','Please try again'));
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
