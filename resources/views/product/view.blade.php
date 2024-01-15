@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product List</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">

                                    <!-- Horizontal cards view -->
{!! Form::open(array('route' => 'orders.store','method'=>'POST', 'class' => 'book-example' , 'name' => 'book-example')) !!}
<div class="pt-2 mb-3">
<span style="font-weight:bold;font-size:15px;">{{$count}} Items </span>
    
      @if($count > 0) 
      <div class="float-right">
      <b>Total : <span class="total" id="total">  </span></b></div><br>
      <button class="btn btn-sm btn-primary float-right m-t-n-xs"  type="submit" id="save">Pay with PayPal</button>@endif<br>
    <hr>
</div>

 

  
<div class="row">
  @if(!empty($data))
  
<input type="hidden" name="user_id" class="form-control daterange" value="{{auth()->user()->id}}"/>


  @foreach($data as $row)
    <div class="col-lg-4">
    
    <div class="card card-body">
            <div class="d-flex">
            
                <div class="flex-fill">
                    <h6 class="mb-0">  @if(!empty($row->img))  
                    <img src="{{url('assets/img/products')}}/{{$row->img}}" alt="{{$row->name}}" width="100"> @endif</h6>
                    <h6 class="mb-0">Name : {{$row->name}}</h6>
                    <h6 class="mb-0">Price : {{number_format($row->price,2)}}</h6>
                    <span class="">Category : @if(!empty($row->category_id))  {{$row->cat->name}} @else - @endif</span> <br>          
                    <span class="">Description : {{$row->description}}</span><br>
                    
                </div>
                
<div class="flex-shrink-0 ms-sm-3 mt-2 mt-sm-0">
         <input name="trans_id[]" type="checkbox"  class="checks" value="{{$row->id}}"  data-price="{{$row->price}}">
         <input type="hidden" class="price" value="{{$row->price}}">
        </div>
                
            
                

            
        </div>
    </div>
    </div>
    @endforeach
    
    @else
    
        <div class="col-lg-12">
    
    <div class="card card-body">
            <div class="d-flex">
            

            <br>
                    <h5 align="center" class="mb-0">NO DATA FOUND</h5>
                
                
                

                
            
                

            
        </div>
    </div>
    </div>
    
    


@endif



</div>

<input type="hidden" name="amount" class="form-control total_cost" id="amount" required readonly>
<!-- /horizontal cards view -->
   {!! Form::close() !!}

                                </div>
                            </div>
                           

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

$(document).ready(function() {

    $(document).on("click", ".checks", function() {

if ($(this).prop('checked') == true) {

  var price = $(this).attr("data-price");

  var tots = $('#amount').val();

  var setPrice = Number(price) + Number(tots);

  var ffp = Math.round(setPrice * 100) / 100;

  $('#amount').val(ffp);
  $('#total').html(parseFloat(ffp).toFixed(2));


} else if ($(this).prop('checked') == false) {


  var price = $(this).attr("data-price");

  var tots = $('#amount').val();

  var setPrice = Number(tots) - Number(price);


  var ffp = Math.round(setPrice * 100) / 100;

  $('#amount').val(ffp);
  $('#total').html(parseFloat(ffp).toFixed(2));
}





});


        
});
</script>


@endsection