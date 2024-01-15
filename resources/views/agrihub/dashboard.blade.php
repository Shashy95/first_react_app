@extends('layouts.master')

@section('content')




    <div id="invoice_state_report_div">    
        <div id="state_report" style="display: ">
            <div class="row">
        
                       
        
                        @if(auth()->user()->id == '1')
                      <div class="col-sm-6 col-xl-4">
                                    <div class="card card-body">
                                        <div class="d-flex align-items-center">
                                        
        
                                            <div class="flex-fill text-center">
                                                <h4 class="mb-0">{{number_format($pos_invoice,2)}} </h4>
                                                <span class="text-primary m0">Total Order Amount</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                  <div class="col-sm-6 col-xl-4">
                                    <div class="card card-body">
                                        <div class="d-flex align-items-center">
                                        
        
                                            <div class="flex-fill text-center">
                                                <h4 class="mb-0">{{number_format($pos_invoice - $pos_due,2)}} </h4>
                                                <span class="text-success m0">Paid Orders</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                   
                    
                    <div class="col-sm-6 col-xl-4">
                                    <div class="card card-body">
                                        <div class="d-flex align-items-center">
                                        
        
                                            <div class="flex-fill text-center">
                                                <h4 class="mb-0">{{number_format($pos_due,2)}} </h4>
                                                <span class="text-warning m0">Total Outstanding Orders</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                @endif
        
                                  @if($total == '0')
                                  
                                    <div class="col-sm-6 col-xl-4">
                                    <div class="card card-body">
                                        <div class="d-flex align-items-center">
                                        
        
                                            <div class="flex-fill text-center">
                                            
                                            
                                            
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-1">Unpaid 
                                                 <div class="col-md-6"></div>  <div class="col-md-6"><span class="text-muted ms-auto"> 0</span></div></div>
                                                <div class="progress" style="height: 0.375rem;">
                                                    <div class="progress-bar bg-danger" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                  <div class="col-sm-6 col-xl-4">
                                    <div class="card card-body">
                                        <div class="d-flex align-items-center">
                                        
        
                                            <div class="flex-fill text-center">
                                                <div class="mb-3">
                                                <div class="d-flex align-items-center mb-1">Fully Paid 
                                                 <div class="col-md-4"></div>  <div class="col-md-4"><span class="text-muted ms-auto">0</span></div></div>
                                                <div class="progress" style="height: 0.375rem;">
                                                    <div class="progress-bar bg-primary" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                   
                    
                    <div class="col-sm-6 col-xl-4">
                                    <div class="card card-body">
                                        <div class="d-flex align-items-center">
                                        
        
                                            <div class="flex-fill text-center">
                                                <div class="mb-3">
                                                <div class="d-flex align-items-center mb-1">Cancelled  
                                              <div class="col-md-6"></div>  <div class="col-md-6"><span class="text-muted ms-auto">0</span></div></div>
                                                <div class="progress" style="height: 0.375rem;">
                                                    <div class="progress-bar bg-success" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>	
                                  
                                  
                                  @else
                                  
                                    <div class="col-sm-6 col-xl-4">
                                    <div class="card card-body">
                                        <div class="d-flex align-items-center">
                                        
        
                                            <div class="flex-fill text-center">
                                            
                                            
                                            
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-1">Unpaid 
                                                 <div class="col-md-6"></div>  <div class="col-md-6"><span class="text-muted ms-auto"> {{$unpaid}} / {{$total}}</span></div></div>
                                                <div class="progress" style="height: 0.375rem;">
                                                    <div class="progress-bar bg-danger" style="width: {{($unpaid/$total) * 100  }}%" aria-valuenow="{{($unpaid/$total) * 100  }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                  <div class="col-sm-6 col-xl-4">
                                    <div class="card card-body">
                                        <div class="d-flex align-items-center">
                                        
        
                                            <div class="flex-fill text-center">
                                                <div class="mb-3">
                                                <div class="d-flex align-items-center mb-1">Fully Paid
                                                 <div class="col-md-4"></div>  <div class="col-md-4"><span class="text-muted ms-auto">{{$paid}} / {{$total}}</span></div></div>
                                                <div class="progress" style="height: 0.375rem;">
                                                    <div class="progress-bar bg-primary" style="width: {{($paid/$total) * 100  }}%" aria-valuenow="{{($paid/$total) * 100  }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                   
                    
                    <div class="col-sm-6 col-xl-4">
                                    <div class="card card-body">
                                        <div class="d-flex align-items-center">
                                        
        
                                            <div class="flex-fill text-center">
                                                <div class="mb-3">
                                                <div class="d-flex align-items-center mb-1">Cancelled 
                                              <div class="col-md-6"></div>  <div class="col-md-6"><span class="text-muted ms-auto">{{$part}} / {{$total}}</span></div></div>
                                                <div class="progress" style="height: 0.375rem;">
                                                    <div class="progress-bar bg-success" style="width: {{($part/$total) * 100  }}%" aria-valuenow="{{($part/$total) * 100  }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>	
                                  
                                  @endif
        
                                   
                    
                    
        
                       
                    </div>
                    </div>
        
        </div>


					
@endsection

@section('scripts')





@endsection


