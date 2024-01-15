<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Orders\Order;
use App\Models\Orders\OrderItems;
use App\Models\Orders\OrderPayment;
use App\Models\Payment_methodes;

use PDF;

use App\Models\User;
// use App\Models\System;
use DateTime;
use Carbon\Carbon;
use DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showChangePswd(){
        return view('auth.change_password');
    }

    public function changePswd(Request $request){
        if(!Hash::check($request->get('current-password'), Auth::user()->password)){
            //check if password matches

            return back()->with('error', 'Curent Password does not match with Old Password');
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
                //current password and new password are the same
                return back()->with('error', 'New password can not be the same as your old password change to new one');
        }

        $this->validate($request, [
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed'
        ]);

        // update password

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->get('new-password'))
        ]);

        return back()->with('success', 'Password changed successfully');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user_id=auth()->user()->id;

        if(auth()->user()->id == '1'){
    $pos_invoice= Order::sum(\DB::raw('invoice_amount +invoice_tax'));
    $pos_due= Order::sum(\DB::raw('due_amount')); 

    $total= Order::count();
    $unpaid= Order::where('status','0')->count();
    $part= Order::where('status','2')->count();
    $paid= Order::where('status','1')->count();
}

else{
    $pos_invoice= Order::where('user_id',$user_id)->sum(\DB::raw('invoice_amount +invoice_tax'));
    $pos_due= Order::where('user_id',$user_id)->sum(\DB::raw('due_amount')); 

    $total= Order::where('user_id',$user_id)->count();
    $unpaid= Order::where('user_id',$user_id)->where('status','0')->count();
    $part= Order::where('user_id',$user_id)->where('status','2')->count();
    $paid= Order::where('user_id',$user_id)->where('status','1')->count();

 
    }

    return view('agrihub.dashboard',compact('pos_invoice','pos_due','total','unpaid','part','paid'));

}


}