<?php

namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;

use App\Models\Settings\Country;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Http\Traits\ImageHandleTraits;
use Toastr;
use Exception;

class CountryController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if($search != ''){
            $countries = Country::where('name','like', '%' .$search. '%')->paginate(25);
            $countries->appends(array('search'=> $search,));
            if(count($countries )>0){
            return view('settings.country.index',['countries'=>$countries]);
            }
            return back()->with('error','No results Found');
        }
        $countries=Country::latest()->paginate(15);
        return view('settings.country.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.location.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCountryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $c=new Country;
            $c->name=$request->name;
            $c->code=$request->code;
            $c->afford_range=$request->afford_range;
            $c->high_grade_range	=$request->high_grade_range	;
            $c->inspection	=$request->inspection;
            $c->insurance	=$request->insurance;
            $c->created_by=currentUserId();
            if($request->has('image')) $b->image = $this->uploadImage($request->file('image'), 'uploads/brands');
            if($c->save()){
                $this->notice::success('Data Saved!');
                return redirect()->route(currentUser().'.country.index');
            }else{
                $this->notice::error('Please try again!','Fail');
                return redirect()->back()->withInput();
            }
        }catch(Exception $e){
            //dd($e);
            $this->notice::error('Please try again!','Fail');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $c=Country::findOrFail(encryptor('decrypt',$id));
        return view('settings.country.edit',compact('c'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCountryRequest  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $c=Country::findOrFail(encryptor('decrypt',$id));
            $c->name=$request->name;
            $c->code=$request->code;
            $c->afford_range=$request->afford_range;
            $c->high_grade_range=$request->high_grade_range	;
            $c->inspection=$request->inspection;
            $c->insurance=$request->insurance;
            $c->updated_by=currentUserId();
            if($request->has('image')) $c->image = $this->uploadImage($request->file('image'), 'uploads/country');
            if($c->save()){
                $this->notice::success('Data Update!');
                return redirect()->route('country.index');
            }else{
                $this->notice::error('Please try again!','Fail');
                return redirect()->back()->withInput();
            }
        }catch(Exception $e){
            //dd($e);
            $this->notice::error('Please try again!','Fail');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }
}
