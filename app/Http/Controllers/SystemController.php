<?php

namespace App\Http\Controllers;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\System;
use App\Models\Currency;
use App\Models\SystemDetails;
use App\Models\SystemConfig;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;

class SystemController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $data = System::where('added_by',auth()->user()->added_by)->first();
        
        $currency= Currency::all();

       if(!empty($data)){
       $id=$data->id;
        $item=SystemDetails::where('system_id',$data->id)->get();
       $sett=SystemConfig::where('system_id',$data->id)->first();
      }
       else{
        $id='';
      $item='';
     $sett='';
      }    
        
        return view('system.data', compact('data','item','sett','id','currency'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
      
        return view('account_codes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
 if ($request->hasFile('picture')) {
					$photo=$request->file('picture');
					$fileType=$photo->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$logo=$fileName;
					$photo->move('assets/img/logo', $fileName );
					 $data['picture'] = $logo;
					
            	}

        $data['name']=$request->name;
        $data['address']=$request->address;
        $data['phone']=$request->phone;
        $data['email']=$request->email;
        $data['tin']=$request->tin;
        $data['vat']=$request->vat;
        $data['added_by']= auth()->user()->added_by;

        $system = System::create($data);


        $nameArr =$request->account_name ;
        $numberArr = $request->account_number;
        $bankArr = $request->bank_name ;;
       $branchArr = $request->branch_name ;;
        $swiftArr = $request->swift_code ;
       $exchangeArr = $request->exchange_code ;

        
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'account_name' => $nameArr[$i],
                        'account_number' => $numberArr[$i],
                        'bank_name' =>  $bankArr [$i],
                         'branch_name' => $branchArr[$i],
                           'swift_code' =>  $swiftArr[$i],
                        'exchange_code' =>  $exchangeArr[$i],
                           'added_by' => auth()->user()->added_by,
                        'system_id' =>$system->id);
                       
                       SystemDetails::create($items);  ;
    
    
                }
            }
          
        }    



           return redirect(route('system.index'))->with(['success'=>'Settings Created.']);
        }
   

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
       $data= System::find($id);
         
        return View::make('system.data', compact('data','id'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
             $system= System::find($id);
         
      
               if ($request->hasFile('picture')) {
					$photo=$request->file('picture');
					$fileType=$photo->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$logo=$fileName;
					$photo->move('assets/img/logo', $fileName );
					 $data['picture'] = $logo;
					
            	}

        $data['name']=$request->name;
        $data['address']=$request->address;
        $data['phone']=$request->phone;
        $data['email']=$request->email;
        $data['tin']=$request->tin;
        $data['vat']=$request->vat;
        $data['added_by']= auth()->user()->added_by;


   if($request->hasFile('picture')){
       if(!empty($system->picture)){
              unlink('assets/img/logo/'. $system->picture);             
            }
   } 

         $system->update($data);


        $nameArr =$request->account_name ;
        $numberArr = $request->account_number;
        $bankArr = $request->bank_name ;;
       $branchArr = $request->branch_name ;;
        $swiftArr = $request->swift_code ;
       $exchangeArr = $request->exchange_code ;
        $remArr = $request->removed_id ;
        $expArr = $request->items_id ;


           
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                   SystemDetails::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
        
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'account_name' => $nameArr[$i],
                        'account_number' => $numberArr[$i],
                        'bank_name' =>  $bankArr [$i],
                         'branch_name' => $branchArr[$i],
                           'swift_code' =>  $swiftArr[$i],
                        'exchange_code' =>  $exchangeArr[$i],
                           'added_by' => auth()->user()->added_by,
                        'system_id' =>$system->id);

                    
                            if(!empty($expArr[$i])){
                                SystemDetails::where('id',$expArr[$i])->update($items);  
          
          }
          else{
             SystemDetails::create($items);   
          }
               
                       
                      
    
    
                }
            }
          
        }    


     
        
             return redirect(route('system.index'))->with(['success'=>'Settings Updated']);
  

        
            
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        System::destroy($id);
        //Flash::success(trans('general.successfully_deleted'));
           return redirect('system');
    }
}
