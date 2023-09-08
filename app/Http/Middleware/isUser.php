<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User; // custome
use App\Models\Settings\UserAccess;
use Session; // custome
use App\Http\Traits\ResponseTrait; // custome

class isUser
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Session::has('userId') || Session::has('userId')==null || !Session::has('roleIdentity')){
            return redirect()->route('logOut');
        }else{
            $user=User::find(currentUserId());
            if(!$user){
                return redirect()->route('logOut');
            }else if(currentUser() != 'user'){
                return redirect()->back()->with($this->resMessageHtml(false,'error','Access Denied'));
            }else{
                $access=UserAccess::where('user_id',$user->id);
                return $next($request);
            }
        }
        return redirect()->route('logOut');
    }
}
