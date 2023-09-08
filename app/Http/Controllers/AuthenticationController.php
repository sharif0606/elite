<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Settings\Country;
use App\Http\Traits\ResponseTrait;
use App\Http\Requests\Authentication\SignupRequest;
use App\Http\Requests\Authentication\SigninRequest;
use Illuminate\Support\Facades\Hash;
use Exception;
use DB;

class AuthenticationController extends Controller
{
    use ResponseTrait;

    public function signUpForm(){
        $countries = Country::all();
        return view('authentication.register',compact('countries'));
    }

    public function signUpStore(SignupRequest $request){
        try{
            $user=new User;
            $user->name=$request->FullName;
            $user->contact_no=$request->PhoneNumber;
            $user->email=$request->EmailAddress;
            $country_id = DB::table('countries')->where('code',$request->country_id)->first()->id;
            $user->country_id=$country_id;
            $user->password=Hash::make($request->password);
            $user->role_id=4;
            if($user->save())
            {
                $userd = new UserDetail;
				$userd->user_id = $user->id;
                $userd->save();
                return redirect('login')->with($this->resMessageHtml(true,null,'Successfully Registred'));
            }
                
            else
                return redirect('login')->with($this->resMessageHtml(false,'error','Please try again'));
        }catch(Exception $e){
            //dd($e);
            return redirect('login')->with($this->resMessageHtml(false,'error','Please try again'));
        }

    }

    public function signInForm(){
        return view('authentication.login');
    }

    public function signInCheck(SigninRequest $request){
        try{
            $user=User::where('contact_no',$request->PhoneNumber)->orWhere('email',$request->PhoneNumber)->first();
            if($user){
                if(Hash::check($request->password , $user->password)){
                    $this->setSession($user);
                    return redirect()->route('dashboard',['role' =>currentUser()])->with($this->resMessageHtml(true,null,'Successfully login'));
                }else
                    return redirect()->route('login')->with($this->resMessageHtml(false,'error','Your phone number or password is wrong!'));
            }else
                return redirect()->route('login')->with($this->resMessageHtml(false,'error','Your phone number or password is wrong!ss'));
        }catch(Exception $e){
            //dd($e);
            return redirect()->route('login')->with($this->resMessageHtml(false,'error','Your phone number or password is wrong!'));
        }
    }

    public function setSession($user){
        return request()->session()->put(
                [
                    'userId'=>encryptor('encrypt',$user->id),
                    'userName'=>encryptor('encrypt',$user->name),
                    'role'=>encryptor('encrypt',$user->role->type),
                    'roleIdentity'=>encryptor('encrypt',$user->role->identity),
                    'country_id'=>$user->country_id,
                    /*'language'=>encryptor('encrypt',$user->language),
                    'companyId'=>encryptor('encrypt',$user->company_id),*/
                    'companyAccess'=>encryptor('encrypt',$user->all_company_access),
                    'image'=>$user->image?$user->image:'no-image.png'
                ]
            );
    }

    public function singOut(){
        request()->session()->flush();
        return redirect()->route('login')->with($this->resMessageHtml(false,'error',currentUserId()));
    }
}
