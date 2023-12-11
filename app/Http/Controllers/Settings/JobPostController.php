<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Settings\JobpostDescription;
use App\Models\Settings\JobpostDescriptionDetails;
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
        // $jobpost = JobPost::get();
        $jobpost=JobPost::findOrFail(encryptor('decrypt',$id));
        $description=JobpostDescription::where('jobpost_id',encryptor('decrypt',$id))->first();
        return view('settings.jobpost.description_create',compact('jobpost','description'));
    }
    public function jobpostDescriptionStore(Request $request, $id)
    { //dd($request->all());
        try{
            $data=JobpostDescription::where('jobpost_id',$request->jobpost_id)->firstOrNew();
            $data->jobpost_id = $request->jobpost_id;
            $data->title = $request->title;
            $data->title_bn = $request->title_bn;
            $data->department = $request->department;
            $data->department_bn = $request->department_bn;
            $data->head_title = $request->head_title;
            $data->head_title_bn = $request->head_title_bn;
            if($data->save()){
                $dl=JobpostDescriptionDetails::where('jobpost_description_id',$data->id)->delete();
                if($request->type_responsibility){
                    foreach($request->type_responsibility as $key => $value){
                        if($value){
                            $details = new JobpostDescriptionDetails;
                            $details->jobpost_description_id=$data->id;
                            $details->type=$request->type_responsibility[$key];
                            $details->description=$request->responsibility_dutie[$key];
                            $details->save();
                        }
                    }
                }
                if($request->type_skill){
                    // $dl=JobpostDescriptionDetails::where('jobpost_description_id',$data->id)->delete();
                    foreach($request->type_skill as $key => $value){
                        if($value){
                            $details = new JobpostDescriptionDetails;
                            $details->jobpost_description_id=$data->id;
                            $details->type=$request->type_skill[$key];
                            $details->description=$request->description_skill[$key];
                            $details->save();
                        }
                    }
                }
                if($request->type_personality){
                    // $dl=JobpostDescriptionDetails::where('jobpost_description_id',$data->id)->delete();
                    foreach($request->type_personality as $key => $value){
                        if($value){
                            $details = new JobpostDescriptionDetails;
                            $details->jobpost_description_id=$data->id;
                            $details->type=$request->type_personality[$key];
                            $details->description=$request->description_personality[$key];
                            $details->save();
                        }
                    }
                }
            }
            \LogActivity::addToLog('Add Jobpost Description',$request->getContent(),'JobpostDescription,JobpostDescriptionDetails');
            return redirect()->route('jobpost.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));

        } catch (Exception $e) {
            dd($e);
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
                return redirect()->route('jobpost.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
                return redirect()->route('jobpost.index')->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
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
