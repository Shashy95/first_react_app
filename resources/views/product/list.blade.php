@extends('layouts.master')



@section('content')
    <section class="section" id="nonPrintable">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Product</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Product
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Product</a>
                                </li>
                               
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-button-html5-basic" id="itemsDatatable">
                                            <thead>
                                                <tr role="row">

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 28.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Name</th>
                                                    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Price</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Category</th>

                                                    <th class="always-visible" class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                    @if (!@empty($list))
                                    @foreach ($list as $row)
                                        

                                        <tr class="gradeA even" role="row">
                                            <td>{{$loop->iteration}}</td>
                    <td>
                        <a href="#" onclick = "model3({{$row->id}})" data-id3 = "{{$row->id}}" data-type="details"  class="details" title="Details"  data-toggle="modal" data-target="#appFormModal">{{$row->name}}</a>   
        
                            </td>
                            <td>{{number_format($row->price,2)}}</td>
                            <td>@if(!empty($row->category_id))  {{$row->cat->name}} @else - @endif </td>

                            

                                           
                

                                            <td>
                                            
                                <div class="form-inline">
                                    
                                    <a class="list-icons-item text-primary" title="Edit"  href="{{ route("product.edit",$row->id)}}"><i class="icon-pencil7"></i></a>&nbsp
                                                       

                                    {!! Form::open(['route' => ['product.destroy',$row->id], 'method' => 'delete']) !!}
                                   {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                            {{ Form::close() }}
                      

                                                </div>
                                                
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
                                            @if (!empty($id))
                                                <h5>Edit Product</h5>
                                            @else
                                                <h5>Add New Product</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['product.update', $id], 'method' => 'PUT',"enctype"=>"multipart/form-data"]) }}
                                                    @else
                                                        {{ Form::open(['route' => 'product.store',"enctype"=>"multipart/form-data"]) }}
                                                        @method('POST')
                                                    @endif

                                                   

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Item Name <span class="required"> * </span></label>
                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"
                                                                value="{{ isset($data) ? $data->name : '' }}"
                                                                class="form-control item" required>

                                                           
                                                        </div>

                                                    </div>
                                                    
                       

                                            <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                    Price <span class="required"> * </span></label>

                                                <div class="col-lg-10">
                                                    <input type="number" name="price" id="cost_price"
                                                        value="{{ isset($data) ? $data->price : '' }}"
                                                        class="form-control" >
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Category</label>
                                                <div class="col-lg-10">
                                                    <select class="form-control m-b" name="category_id"
                                                        id="location" >
                                                        <option value="">Select Category</option>
                                                        @if (!empty($category))
                                                            @foreach ($category as $loc)
                                                                <option
                                                                    @if (isset($data)) {{ $data->category_id == $loc->id ? 'selected' : '' }} @endif
                                                                    value="{{ $loc->id }}">
                                                                    {{ $loc->name }}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>

                                                </div>
                                            </div>
                                                    
                                                    
                                                    
                          
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Desription</label>
                                            <div class="col-lg-10">
                                                <textarea name="description" class="form-control">{{ isset($data) ? $data->description : '' }}</textarea>
                                            </div>
                                        </div>
                                        

                                        <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Image <span class="required"> * </span></label>
                                            <div class="col-lg-10">
                                        @if (!empty($data->img))
          
   <input  type="file" name="img" value="{{$data->img }}" class="form-control" onchange="loadBigFile(event)" required><br>

<img src="{{url('assets/img/products')}}/{{$data->img}}" alt="{{$data->name}}" width="100"><br>
@else
<input  type="file" name="img" required  class="form-control" onchange="loadBigFile(event)" required>
          @endif
                                             
                            <br>
            <img id="big_output" width="100">
                                            </div></div>
                                                        
                                                        

                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-12">
                                    @if (!@empty($id))
                                        <button
                                            class="btn btn-sm btn-primary float-right save"
                                            
                                            type="submit" id="save">Update</button>
                                    @else
                                        <button
                                            class="btn btn-sm btn-primary float-right save"
                                            type="submit" id="save" >Save</button>
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
                </div>

            </div>
    </section>

    <!-- discount Modal -->
    <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

    <script src="{{ asset('assets/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.print.min.js') }}"></script>
    
    
    
    <script>
        
            $('#itemsDatatable').DataTable({
                processing: true,
                serverSide: false,
                searching: true,
                "dom": 'lBfrtip',

                buttons: [{
                        extend: 'copyHtml5',
                        title: 'ITEM LIST ',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                      
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'ITEM LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                       
                        footer: true
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'ITEM LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'ITEM LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)',
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        title: 'ITEM LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    }

                ],

           
           
        
        });

       
    </script>



    
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "orderable": false,
                "targets": [1]
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
    <script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>


    <script type="text/javascript">
      $(document).on("change", function (event) {
         
         var a=$('.type').val();
         var b=$('.item_name').val();
         var c=$('.item_tax').val();
         var d=$('#cost_price').val();
         var e=$('#sales_price').val();
         console.log(c);
        
         if(a == '' || b == '' || c == '' || d == '' || e == '' ){
               $("#save").attr("disabled", true);
              event.preventDefault(); 
         }
         
         else{
            
           $("#save").attr("disabled", false);
          
         }
        
    });      
            

    </script>
    
    
   
    
    

    <script type="text/javascript">
    
        
         function model3(id) {

            let url = '{{ route('product.show', ':id') }}';
            url = url.replace(':id', id);
            
             
             var type=$('a[data-id3="'+id+'"]').attr('data-type');;

            console.log(type);

            $.ajax({
                type: 'GET',
                url: url,
                 data: {'type': type,},

                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#appFormModal > .modal-dialog').html(data);
                     
                },
                error: function(error) {
                    $('#appFormModal').modal('toggle');

                }
            });

        }  
        
    </script>

<script>
    var loadBigFile=function(event){
      var output=document.getElementById('big_output');
      output.src=URL.createObjectURL(event.target.files[0]);
    };
  </script>  
@endsection
