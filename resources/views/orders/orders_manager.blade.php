@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Order </h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Order
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Order</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Ref No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 186.484px;">User</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 136.484px;">Order Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Amount</th>
                                                   
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 121.219px;">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 168.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($orders))
                                                    @foreach ($orders as $row)
                                                       

                                                        <tr class="gradeA even" role="row">

                                                            <td>
                                                                <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('orders.show', $row->id) }}"
                                                                    role="tab"
                                                                    aria-selected="false">{{ $row->reference_no }}</a>
                                                            </td>
                                                            <td>{{ $row->client->name }}</td>

                                                            <td>{{Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y')}}</td>

                                                            <td>{{ number_format($row->invoice_amount + $row->innvoice_tax, 2) }}{{ $row->exchange_code }}</td>
                                                           
                                                            <td>
                                                                @if ($row->status == 0)
                                                                    <div class="badge badge-danger badge-shadow">Pending</div>
                                                                @elseif($row->status == 1)
                                                                    <div class="badge badge-success badge-shadow">Order Completed
                                                                   
                                                                @endif
                                                            </td>


                                                            <td>
                                                            @if($row->status == '1')
                                                                <div class="form-inline">
                                                                   
                                                                    <div class="dropdown">
                                                                        <a href="#"
                                                                            class="list-icons-item dropdown-toggle text-teal"
                                                                            data-toggle="dropdown"><i
                                                                                class="icon-cog6"></i></a>

                                                                        <div class="dropdown-menu">
                                                                  
 
                            <a class="nav-link" id="profile-tab2" href="{{ route('orders_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}">Download PDF</a>
                             <a class="nav-link" id="profile-tab2" href="{{ route('orders_receipt', ['download' => 'pdf', 'id' => $row->id]) }}">Download Receipt</a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (empty($id))
                                                <h5>Create Order</h5>
                                            @else
                                                <h5>Edit Order</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                {{ Form::model($id, array('route' => array('orders.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data", 'id' => 'invform')) }}
                                                        
                                                    @else
                                                        {!! Form::open(array('route' => 'orders.store',"enctype"=>"multipart/form-data", 'id' => 'invform')) !!}
                                                        @method('POST')
                                                    @endif


                                                    <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Delivered Address</label>
                                                    <div class="col-lg-8">
                                                    <textarea name="address"  class="form-control" required></textarea>
                                                       
                                                    </div>
                                                </div>
                                                    
                                                       
                                                    <input type="hidden" name="invoice_date" value="{{ date('Y-m-d') }}" class="form-control">
                                                     <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" class="form-control">
                                                    

                                                   

                                                   
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name <span class="required"> * </span></th>
                                                                    
                                                                    <th>Quantity <span class="required"> * </span></th>
                                                                    <th>Price <span class="required"> * </span></th>
                                                                    <th>Total <span class="required"> * </span></th>
                                                                    <th>Select </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if (!empty($items))
                                                                @foreach ($items as $i)
                                                                            <tr class="line_items">
                                                                                <td>
                                                                                {{$i->heading}}
                                                                                
                                                                                </td>
                                                                                
                                                                                
                                                                                
                                                                                <td class="quantity{{$loop->iteration}}">
                <input type="number" name="quantity[]" class="form-control item_quantity" data-sub_category_id="{{$loop->iteration}}" value="1" placeholder="quantity" id="quantity" />
                                                                                </td>
                                                                                
                                                                                <td >
                                                        <input type="text" name="price[]" class="form-control item_price{{$loop->iteration}}"  value="{{ isset($i) ? $i->price : '' }}" readonly/>
                                                                                </td>
                                                                               
                                                                                
                                                                               
                                                                                <td>
                                                <input type="text" class="form-control item_cost{{$loop->iteration}}" name="total_cost[]" readonly />
                                                                                </td>
                                                                                
                                                                                <td> 
                                                                <input name="item_name[]" type="checkbox"  class="checks" value="{{$i->id}}" data-sub_category_id="{{$loop->iteration}}"></td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                              

                                                            </tbody>
                                                            <tfoot>
                                                               


                                                                <tr class="line_items">
                                                                    <td colspan="2"></td>
                                                                    <td><span class="bold">Total</span>: </td>
                                                                    <td>
                                                    <input type="text" name="amount[]" class="form-control total_cost" id="amount" required readonly></td>
                                                            </tfoot>
                                                        </table>
                                                    </div>


                                                    <br>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))

                                                                <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                    href="{{ route('invoice.index') }}">
                                                                    Cancel
                                                                </a>
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                    data-toggle="modal" data-target="#myModal"
                                                                    type="submit" id="save">Update</button>
                                                            @else
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                    type="submit" id="save" disabled>Save</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- supplier Modal -->
    <div class="modal fade" data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">

        </div>
    </div>
    
   
@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
             "ordering": false,
            
            "columnDefs": [{
                "orderable": false,
                "targets": [3]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>



<script type='text/javascript'>
$(document).on("change", function () {
      


 $(function () {  
       $('input:checkbox').click(function (e) {  
         calculateTotalSum(4);  
       });  
     function calculateTotalSum(colidx) {
     
  var total= 0; 

       $("tr:has(:checkbox:checked) td:nth-child(" + colidx + ") input").each(function () {  
      a=$(this).val().replace(/\,/g,''); // 1125, but a string, so convert it to number
      
      console.log(a);

        total += parseInt(a,10); 
        console.log(total);
         });  
         
          var d=addCommas(total.toFixed(2));
         $('#amount').val(d); 
        
       }  
     }); 


$('input:checkbox').click(function() {
  var sub_category_id = $(this).data('sub_category_id');;      
console.log(sub_category_id);
  if($(this).is(':checked')){  

$('.quantity'+sub_category_id).find('.item_quantity').attr("name", "checked_quantity[]");;
  $('.item_price'+sub_category_id).attr("name", "checked_price[]");;
  $('.item_cost'+sub_category_id).attr("name", "checked_total_cost[]");;
   $(this).attr("name", "checked_item_name[]");; 
  }
else{
$('.quantity'+sub_category_id).find('.item_quantity').attr("name", "quantity[]");;
$('.item_price'+sub_category_id).attr("name", "price[]");;
  $('.item_cost'+sub_category_id).attr("name", "total_cost[]");;
   $(this).attr("name", "item_name[]");; 
}

})



});
</script>

       <script>
$(document).ready(function() {
   $(document).on('change', '.item_quantity', function() {
            var id = $(this).val();
           
            var sub_category_id = $(this).data('sub_category_id');
             console.log(sub_category_id);
           
             var price=$('.item_price' + sub_category_id).val();
             
             var s=id* price;
             var cost=addCommas(s);
            
            
                $('.item_price' + sub_category_id).empty();
                $('.item_cost' + sub_category_id).val(cost);
            

    });

$('.item_quantity').trigger('change'); 

}); 
    </script>
    
<script>
$('input:checkbox').click(function() {
 if ($(this).is(':checked')) {
 $('#save').prop("disabled", false);
 } else {
 if ($('.checks').filter(':checked').length < 1){
 $('#save').prop("disabled", true);

}
 }
});

         </script>


    <script type="text/javascript">
        $(document).ready(function() {


            function autoCalcSetup() {
                $('table#cart').jAutoCalc('destroy');
                $('table#cart tr.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('table#cart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();

           
        });
    </script>






<script>
    
    function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

  </script>


    
    
    

    
    
     
    

@endsection
