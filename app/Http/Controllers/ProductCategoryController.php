<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ProductCategory;
use PDF;


use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $category=ProductCategory::where('added_by',auth()->user()->id)->where('disabled','0')->get();
       return view('product.category',compact('category'));
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
        
        $data['name']=$request->name;
        $data['description']=$request->description;
          
        $data['added_by']= auth()->user()->id;

        $invoice = ProductCategory::create($data);
   
        return redirect(route('product_category.index'))->with(['success'=>'Created Successfully']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $data=ProductCategory::find($id);
       return view('product.category',compact('data','id'));
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
        $invoice=ProductCategory::find($id);
        
       $data['name']=$request->name;
        $data['description']=$request->description;
          

            $invoice->update($data);
        



        return redirect(route('product_category.index'))->with(['success'=>'Updated Successfully']);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        $item = ProductCategory::find($id);

        $item->update(['disabled'=> '1']);
        
         return redirect(route('product_category.index'))->with(['success'=>'Deleted Successfully']);

    }

  

}
