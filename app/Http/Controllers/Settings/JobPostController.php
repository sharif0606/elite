<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Settings\JobpostDescription;
use Exception;
use DB;
use Toastr;

class JobPostController extends Controller
{

    public function index()
    {
        $jobpost = JobPost::paginate(20);
        return view('settings.jobpost.index',compact('jobpost'));
    }

    public function create()
    {
        return view('settings.jobpost.create');
    }
    public function jobpostDescription($id)
    {
        $jobpost = JobPost::get();
        $jobpost=JobPost::findOrFail(encryptor('decrypt',$id));
        return view('settings.jobpost.description_create',compact('jobpost'));
    }
    public function jobpostDescriptionStore(Request $request, $id)
    {
        try{
            $c=new JobpostDescription;
            $c->name=$request->jobpostName;
            $c->name_bn=$request->name_bn;
            $c->bill_able=$request->bill_able;
            $c->status=1;
            if($c->save()){
                return redirect()->route(currentUser().'.jobpost.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        }catch(Exception $e){
            // dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    public function store(Request $request)
    {
        try{
            $c=new JobPost;
            $c->name=$request->jobpostName;
            $c->name_bn=$request->name_bn;
            $c->bill_able=$request->bill_able;
            $c->status=1;
            if($c->save()){
                return redirect()->route(currentUser().'.jobpost.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        }catch(Exception $e){
            // dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $jobpost=JobPost::findOrFail(encryptor('decrypt',$id));
        return view('settings.jobpost.edit',compact('jobpost'));
    }


    public function update(Request $request, $id)
    {
        try{
            $c=JobPost::findOrFail(encryptor('decrypt',$id));
            $c->name=$request->jobpostName;
            $c->name_bn=$request->name_bn;
            $c->bill_able=$request->bill_able;
            $c->status=1;
            if($c->save()){
                return redirect()->route(currentUser().'.jobpost.index')->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        }catch(Exception $e){
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }


    public function destroy($id)
    {
        //
    }
}
