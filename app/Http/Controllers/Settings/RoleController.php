<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\Role\AddNewRequest;
use App\Http\Requests\Settings\Role\UpdateRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Role::paginate(10);
        return view('settings.role.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddNewRequest $request)
    {
        try{
            $data=new Role();
            $data->name=$request->Name;
            $data->identity=$request->Identity;
            if($data->save()){
                $this->notice::success('Successfully saved');
                \LogActivity::addToLog('Add Role',$request->getContent(),'Role');
                return redirect()->route('role.index');
            }
        }catch(Exception $e){
            dd($e);
            $this->notice::error('Please try again');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role=Role::findOrFail(encryptor('decrypt',$id));
        return view('settings.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try{
            $data=Role::findOrFail(encryptor('decrypt',$id));
            $data->name=$request->Name;
            $data->identity=$request->Identity;
            if($data->save()){
                $this->notice::success('Successfully updated');
                \LogActivity::addToLog('Update Role',$request->getContent(),'Role');
                return redirect()->route('role.index');
            }
        }catch(Exception $e){
            $this->notice::error('Please try again');
            //dd($e);
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data= Role::findOrFail(encryptor('decrypt',$id));
        if($data->delete()){
            $this->notice::warning('Deleted Permanently!');
            return redirect()->back();
        }
    }
}
