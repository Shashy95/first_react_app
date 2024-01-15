<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\User_Roles;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\POS\Activity;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
          if(is_numeric($request->get('email'))){
            return ['phone'=>$request->get('email'),'password'=>$request->get('password')];
          }
          elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password'=>$request->get('password')];
          }
          
          elseif( is_string($request->get('email'))){
               return ['email'=>$request->get('email'),'password'=>$request->get('password')];
              
          }
          
          
    }
        
        
        
        
    protected function validateLogin(Request $request)

    {

        $this->validate($request, [

            'email' => 'required',

            'password' => 'required',

            // new rules here

        ],
        
        [
            'email.required'=> 'Your Email or Phone Number is Required', 
            'password.required'=> 'Password is Required' 
        ]
        );
        
        
    
        if (!Auth::attempt([
            'email' => $request['email'], 
            'password' => $request['password']
            
            ])) { 
            return redirect()->back()->with(['fail' => 'invalid Email/Phone Number or password']);      
        }
        
       
        
         

    }
}
