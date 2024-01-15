@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Orders </h4>
                        </div>
                        <div class="card-body">
                            
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
                                                        <a href="{{ route('orders.show', $row->id) }}">{{ $row->reference_no }}</a>
                                                            </td>
                                                            <td>{{ $row->client->name }}</td>

                                                            <td>{{Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y')}}</td>

                                                            <td>{{ number_format($row->invoice_amount + $row->innvoice_tax, 2) }}{{ $row->exchange_code }}</td>
                                                           
                                        <td>
                                            @if ($row->status == 0)
                                                <div class="badge badge-info badge-shadow">Pending</div>
                                            @elseif($row->status == 1)
                                                <div class="badge badge-success badge-shadow">Order Completed
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-danger badge-shadow">Order Cancelled      
                                                
                                            @endif
                                        </td>


                                                            <td>
                                                           
                                                <div class="form-inline">
                                                    
                                                    <div class="dropdown">
                                                        <a href="#"
                                                            class="list-icons-item dropdown-toggle text-teal"
                                                            data-toggle="dropdown"><i
                                                                class="icon-cog6"></i></a>

                                                        <div class="dropdown-menu">
                                                                  
                                                                            @if($row->status == '1')
                            <a class="nav-link" id="profile-tab2" href="{{ route('orders_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}">Download PDF</a>
                              @else
                              <a class="nav-link" id="profile-tab2" href="{{ route('orders.get_payment', $row->id) }}">Pay with PayPal</a>
                              <a class="nav-link" id="profile-tab2" href="{{ route('orders.cancel', $row->id) }}">Cancel Order</a>
                              @endif
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>
                                        </table>
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
