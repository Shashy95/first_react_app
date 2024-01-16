@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Order Payments</h4>
                        </div>
                        <div class="card-body">
                           
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ref</th>
                                            <th>Order No</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Mode</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($payments as $row)
                                       
                                        <tr>
                            <td class=""> {{$row->trans_id}}</td>
                            <td class=""> {{$row->invoice->reference_no}}</td>
                           <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}  </td>
                           <td class="">{{ number_format($row->amount ,2)}} </td>
                        <td class=""> {{ $row->payment_method }} </td>
                      
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
            </div>

        </div>
    </section>

    <!-- supplier Modal -->
    <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-lg">

        </div>
    </div>


   




@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            order: [
                [2, 'desc']
            ],
            "columnDefs": [{
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




@endsection
