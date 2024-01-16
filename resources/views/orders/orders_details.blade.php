@extends('layouts.master')
<style>
.p-md {
    padding: 12px !important;
}

.bg-items {
    background: #303252;
    color: #ffffff;
}
.ml-13 {
    margin-left: -13px !important;
}
</style>

@section('content')
<section class="section">
    <div class="section-body">


        <div class="row">


            <div class="col-12 col-md-12 col-lg-12">
            
            <div class="col-lg-10">

             @if($invoices->status == '1')
             <a class="btn btn-xs btn-success"  href="{{ route('orders_pdfview',['download'=>'pdf','id'=>$invoices->id]) }}"  title="" > Download PDF </a>
              
              @endif                           
    </div>

<br>


 
               
                <div class="card">
                   <div class="card-body">
                       
                        <?php
$settings= App\Models\System::first();


?>
                        <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                                   <div class="col-lg-6 col-xs-6 ">
                <img class="pl-lg" style="width: 90px;height: 90px;" src="{{url('assets/img/logo')}}/{{$settings->picture}}">
            </div>
                                  
 <div class="col-lg-3 col-xs-3">

                                    </div>

                                      <div class="col-lg-3 col-xs-3">
                                        
                                       <h5 class="mb0">REF NO : {{$invoices->reference_no}}</h5>
                                      Order Date : {{Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y')}}                  
                                     
                                      
          <br>Status: 
                                   @if($invoices->status == 0)
                                            <span class="badge badge-info badge-shadow">Pending</span>
                                            @elseif($invoices->status == 1)
                                            <span class="badge badge-success badge-shadow">Order Completed</span>
                                            @elseif($invoices->status == 2)
                                            <span class="badge badge-warning badge-shadow">Order Cancelled</span>
                                            @endif
                                       
                                                                                   
                    
                    
                
            </div>
                                </div>

<br>
                            
                               <div class="row mb-lg">
                                    <div class="col-lg-6 col-xs-6">
                                         <h5 class="p-md bg-items mr-15">Our Info:</h5>
                                 <h4 class="mb0">{{$settings->name}}</h4>
                    {{ $settings->address }}  
                   <br>Phone : {{ $settings->phone}}     
                  <br> Email : <a href="mailto:{{$settings->email}}">{{$settings->email}}</a>                                                               
                   <br>TIN : {{$settings->tin}}
                                    </div>
                                   

                                    <div class="col-lg-6 col-xs-6">
                                       
                                       <h5 class="p-md bg-items ml-13">  Client Info: </h5>
                                       <h4 class="mb0"> {{$invoices->client->name}}</h4>
                                        Phone : {{ $invoices->client->phone}} 
                                        

                                        </div>
 </div>

                                    </div>
                                </div>
                                
                               
                                
                                <?php
                               
                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>

                               <div class="table-responsive mb-lg">
           <table class="table items invoice-items-preview" page-break-inside:="" auto;="">
                <thead class="bg-items">
                    <tr>
                       <th style="color:white;">#</th>
                        <th style="color:white;">Items</th>
                        <th style="color:white;">Qty</th>
                        <th style="color:white;">Price</th>
                        <th style="color:white;">Total</th>
                    </tr>
                </thead>
                                    <tbody>
                                        @if(!empty($invoice_items))
                                        @foreach($invoice_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost ;
                                         $tax += $row->total_tax; 
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                            <?php
                                         $item_name = App\Models\Product::find($row->item_name);
                                        ?>
                                    <td class=""><strong class="block">@if(!empty($item_name->name)) {{$item_name->name}} @else {{$row->item_name}}  @endif  </strong></td>
                                    <td class="">{{ $row->quantity }} </td>
                                <td class="">{{number_format($row->price ,2)}}  </td>                                         
                                    <td class="">{{number_format($row->total_cost ,2)}} </td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif

                                       
                                    </tbody>
 <tfoot>

<tr>
    <td colspan="3"></td>
    <td>Total Amount</td>
    <td>{{number_format($gland_total ,2)}}  </td>
    </tr>
    
     @if(!empty($invoices->due_amount < $invoices->invoice_amount + $invoices->invoice_tax )) 
         <tr>
    <td colspan="3"></td>
                        <td>Paid Amount</p>
                        <td>{{number_format( ($invoices->invoice_amount + $invoices->invoice_tax ) - $invoices->due_amount,2)}}  </p>
                    </tr>
    
          <tr>
    <td colspan="3"></td>
                        <td class="text-danger">Total Due</td>
                        <td>{{number_format($invoices->due_amount,2)}}    </td>
                    </tr>
@endif


</tfoot>
</table>
                            </div>

                                    

                                
                             
                            </div>

                        </div>

                    </div>
                </div>
            </div>

         

  @if(!empty($payments[0]))
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br><h5 class="mb0" style="text-align:center">PAYMENT DETAILS</h5>
                      <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">     
                            
                                
                                <?php
                               
                                
                                 $i =1;
       
                                 ?>
                                <div class="table-responsive">
        <table class="table datatable-basic table-striped">
                                    <thead>
                                        <tr>
                                            <th>Transaction ID</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                     
                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($payments as $row)
                                       
                                        <tr>
                                            
                                            <td class=""> {{$row->trans_id}}</td>
                                               <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($row->amount ,2)}}  </td>
                                            <td class="">{{ $row->payment_method }}</td>
                                            
                                            
                                        </tr>
                                        @endforeach
                                       


                                    </tbody>
                                   
                                </table>
                              </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            @endif
            
           
            
        </div>
    </div>
</section>


   
@endsection

@section('scripts')
 <script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
@endsection