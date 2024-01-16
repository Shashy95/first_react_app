<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Orders\Order;
use App\Models\Orders\OrderItems;
use App\Models\Orders\OrderPayment;
use App\Models\Payments;
use  App\Models\Product;
use PDF;
use DB;
use Omnipay\Omnipay;
use Session;

class OrdersController extends Controller
{
    private $gateway;

    public function __construct()
    {
       
        $this->gateway=Omnipay::create('PayPal_Rest');
        $this->gateway->SetClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->SetSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->SetTestMode(true);
    }
    public function index()
    {
        $user_id=auth()->user()->id;
  
        if(auth()->user()->id == '1'){
            $orders=Order::orderBy('id','desc')->get(); 
        }
        else{
            $orders=Order::where('user_id',$user_id)->orderBy('id','desc')->get(); 
        
        }
         
         //dd($items);
       
        
       return view('orders.orders_list',compact('orders'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *dashboard/
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $trans_id= $request->trans_id;

  if(!empty($trans_id)){

    $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(5/strlen($x)) )),1,5);
    $count=Order::count();
    $pro=$count+1;
    $amountArr = str_replace(",","",$request->amount);
    
    $data['reference_no']= "SGC".$random.$pro;
    $data['user_id']=$request->user_id;
    $data['invoice_date']=date('Y-m-d');
    $data['address']='dar';
    $data['invoice_amount']=$amountArr;
    $data['due_amount']=$amountArr;
    $data['invoice_tax']='0';
    $data['status']='0';
    $data['added_by']= auth()->user()->id;

    $invoice = Order::create($data);

    for($i = 0; $i < count($trans_id); $i++){
   if(!empty($trans_id[$i])){


           $a=Product::find($trans_id[$i]);

        $items = array(
            'item_name' => $trans_id[$i],
            'quantity' =>   '1',
             'price' =>  $a->price,
            'total_cost' =>  $a->price,
             'order_no' => $i,
             'added_by' => auth()->user()->id,
            'order_id' =>$invoice->id);
           
            OrderItems::create($items);  ;

   }
}

try{
   
   

    $response=$this->gateway->purchase(array(
      'amount'=>str_replace(",","",$request->amount),
      'currency'=>env('PAYPAL_CURRENCY'),
       'returnUrl'=>url('orders/payment_success'),
       'cancelUrl'=>url('orders/payment_error'),
       'order_id'=>$invoice->id,
      
    ))->send();

    //dd($response);

  //pass order id of the table 
$order_id=Session::put('order_id',$invoice->id);

    if($response->isRedirect()){
        $response->redirect();
    }
   else{
    return $response->getMessage();
   }


}catch(\Throwable $th){
 return $th->getMessage();
}



//return redirect(route('orders.get_payment',$invoice->id));
}

else{
    return redirect(route('product.list'))->error('No product chosen');   
}


    } 
    
    
    public function success(Request $request)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
          
            if ($response->isSuccessful())
            {
                //get order id of the table
                $order_id = Session::get('order_id');
               

                // The customer has successfully paid.
                $arr_body = $response->getData();
          
                // Insert transaction data into the database
                $payment = new Payments;
                $payment->payment_id = $arr_body['id'];
                $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr_body['state'];
                $payment->save();

                

                $sales =Order::find($order_id);
                     $count=OrderPayment::count();
                    $pro=$count+1;
        
                        $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(5/strlen($x)) )),1,5);
                        $receipt['trans_id'] = "SGCP".$random.$pro;
                        $receipt['order_id'] = $sales->id;
                        $receipt['paypal_id'] = $payment->id;
                      $receipt['amount'] = $sales->due_amount;
                        $receipt['date'] = $sales->invoice_date;
                         $receipt['payment_method'] = 'PayPal';
                        $receipt['added_by'] = $sales->user_id;;
                        
                        //update due amount from invoice table
                        $b['due_amount'] =  0;
                       $b['status'] = 1;
                      
                        $sales->update($b);
                         
                        $payment = OrderPayment::create($receipt);
                        

            return redirect(route('orders.show',$order_id))->with(['success'=>"Payment is successful. Your transaction id is: ". $arr_body['id']]);
          
            } else {
                return $response->getMessage();
            }
        } else {
            return redirect(route('orders.index'))->with(['error'=>"Transaction is declined"]);
            
        }
    }
  
    /**
     * Error Handling.
     */
    public function error()
    {
        return redirect(route('orders.index'))->with(['error'=>"User cancelled the payment."]);
        
    }

    
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $invoices = Order::find($id);
        $invoice_items=OrderItems::where('order_id',$id)->get();
        $payments=OrderPayment::where('order_id',$id)->get();
        
        return view('orders.orders_details',compact('invoices','invoice_items','payments'));
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
        
    }
    
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$product,$purchase)
    {
       
     
    }

     public function get_payment($id)
    {
        $data=Order::find($id);

        try{
   
            $response=$this->gateway->purchase(array(
              'amount'=>$data->due_amount,
              'currency'=>env('PAYPAL_CURRENCY'),
               'returnUrl'=>url('orders/payment_success'),
               'cancelUrl'=>url('orders/payment_error'),
               'order_id'=>$id,
              
            ))->send();
        
            //dd($response);
        
           
        $order_id=Session::put('order_id',$id);
        
            if($response->isRedirect()){
                $response->redirect();
            }
           else{
            return $response->getMessage();
           }
        
        
        }catch(\Throwable $th){
         return $th->getMessage();
        }
        


      
     
    }


    public function cancel($id)
    {
       $invoices = Order::find($id);
        $data['status']='2';
        $invoices->update($data);

        return redirect(route('orders.index'))->with(['success'=>"Cancelled Successfully"]);
        
    }


    public function invoice_pdfview(Request $request)
    {
        //
        $invoices = Order::find($request->id);
        $invoice_items=OrderItems::where('order_id',$request->id)->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('orders.order_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('ORDER NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('inv_pdfview');
    }
    
     public function invoice_receipt(Request $request){

        //if landscape heigth * width but if portrait widht *height      // dd($dataResult);
        $customPaper = array(0,0,198.425,494.80);

        $invoices = Order::find($request->id);
        $invoice_items=OrderItems::where('order_id',$request->id)->get();
     

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('orders.order_receipt_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('ORDER RECEIPT INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('invoice_receipt');

    }
}
