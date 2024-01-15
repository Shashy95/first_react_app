<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use  App\Models\Product;
use App\Models\ProductCategory ;
use DB;
use App\Models\Package;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        
        $list = Product::where('disabled','0')->where('added_by',auth()->user()->id)->get();
        $category = ProductCategory::where('added_by',auth()->user()->id)->where('disabled','0')->get(); 
       
        

       return view('product.list',compact('category','list'));
        
      
        
        
    }
    
    
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       

        if($request->hasFile('img')){
            $filenameWithExt=$request->file('img')->getClientOriginalName();
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension=$request->file('img')->getClientOriginalExtension();
            $fileNameToStore=$filename.'_'.time().'.'.$extension;
            $path = public_path('/assets/img/products');
             $request->file('img')->move($path, $fileNameToStore);
           
        }
        
        else{
          $fileNameToStore=null;   
        }
      
        
        $data=$request->post();
        $data['img']=$fileNameToStore;
        $data['added_by'] = auth()->user()->id;
        $product = Product::create($data);

        return redirect(route('product.index'))->with(['success'=>'Created Successfully']);
    }
    
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {

    
        
         if($request->type == 'details'){
             $data=Product::find($id);
       return view('product.details',compact('id','data'));
        }
     
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    $data=Product::find($id);
    $category = ProductCategory::where('added_by',auth()->user()->id)->where('disabled','0')->get();

        return view('product.list',compact('data','id','category'));
    
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
        //
     $item=Product::find($id);
    
    
       //handle file upload
       if($request->hasFile('img')){
        $filenameWithExt=$request->file('img')->getClientOriginalName();
        $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension=$request->file('img')->getClientOriginalExtension();
        $fileNameToStore=$filename.'_'.time().'.'.$extension;
       
         $path = public_path('/assets/img/products');
         $request->file('img')->move($path, $fileNameToStore);
         
          
            
    }
    else{
        $fileNameToStore = $item->img;
}


    $data=$request->post();
     $data['img']=$fileNameToStore;
    $data['added_by']=auth()->user()->id;

    if(!empty($item->img)){
    if($request->hasFile('img')){
        unlink('assets/img/products/'.$item->img);  
       
    }
}


        $item->update($data);

                
    return redirect(route('product.index'))->with(['success'=>'Updated Successfully']);;

                    }
    
    
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        //
  $item=Product::find($id);
     $name=$item->name;
    $item->update(['disabled'=> '1']);

    return redirect(route('product.index'))->with(['success'=>'Deleted Successfully']);;
    }
    
    
  
    
    public function findItem(Request $request){
  

$loc=Product::where(DB::raw('lower(name)'), strtolower($request->id))->where('disabled','0')->where('added_by',auth()->user()->id)->first();  

    if (empty($loc)) {    
 $region='';    
}
else{
$region='error';

}
  
 return response()->json($region);
     
   }
  
   
   public function list(Request $request){
    $data = Product::where('disabled','0')->get();
    $count=count($data);
    return view('product.view',compact('data','count'));
   }
   
  
}
