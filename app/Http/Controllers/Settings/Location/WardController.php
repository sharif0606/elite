<?php

namespace App\Http\Controllers\Settings\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\Location\Ward;
use App\Http\Traits\ResponseTrait;
use Exception;

class WardController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ward=Ward::paginate(50);
        return view('settings.location.ward.index',compact('ward'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.location.ward.create');
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
            $ward=new Ward;
            // $ward->upazila_id=$request->upazila_id;
            $ward->name=$request->wardName;
            $ward->name_bn=$request->wardBn;
            if($ward->save())
                return redirect()->route(currentUser().'.ward.index')->with($this->resMessageHtml(true,null,'Successfully created'));
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
        $ward= Ward::findOrFail(encryptor('decrypt',$id));
        return view('settings.location.ward.edit',compact('ward'));
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
            $ward= Ward::findOrFail(encryptor('decrypt',$id));
            // $ward->upazila_id=$request->upazila_id;
            $ward->name=$request->wardName;
            $ward->name_bn=$request->wardBn;
            if($ward->save())
                return redirect()->route(currentUser().'.ward.index')->with($this->resMessageHtml(true,null,'Successfully update'));
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
