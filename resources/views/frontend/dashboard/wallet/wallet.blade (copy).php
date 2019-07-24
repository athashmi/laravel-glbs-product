@extends('layout.main')
@section('content')
<?php
use App\Helpers\Helper;
?>
<div class="col-xl-12 col-lg-12  filter-bar">
    <!-- Nav Filter tab start -->
    <nav class="navbar navbar-light bg-faded m-b-30 p-10">
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#!">Filter: <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#!" id="bydate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-clock-time"></i> By Date</a>
                <div class="dropdown-menu" aria-labelledby="bydate">
                    <a class="dropdown-item" href="#!">Show all</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#!">Today</a>
                    <a class="dropdown-item" href="#!">Yesterday</a>
                    <a class="dropdown-item" href="#!">This week</a>
                    <a class="dropdown-item" href="#!">This month</a>
                    <a class="dropdown-item" href="#!">This year</a>
                </div>
            </li>
            <!-- end of by date dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#!" id="bystatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-chart-histogram-alt"></i> By Status</a>
                <div class="dropdown-menu" aria-labelledby="bystatus">
                    <a class="dropdown-item" href="#!">Show all</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#!">Open</a>
                    <a class="dropdown-item" href="#!">On hold</a>
                    <a class="dropdown-item" href="#!">Resolved</a>
                    <a class="dropdown-item" href="#!">Closed</a>
                    <a class="dropdown-item" href="#!">Dublicate</a>
                    <a class="dropdown-item" href="#!">Wontfix</a>
                </div>
            </li>
            <!-- end of by status dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#!" id="bypriority" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-sub-listing"></i> By Priority</a>
                <div class="dropdown-menu" aria-labelledby="bypriority">
                    <a class="dropdown-item" href="#!">Show all</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#!">Highest</a>
                    <a class="dropdown-item" href="#!">High</a>
                    <a class="dropdown-item" href="#!">Normal</a>
                    <a class="dropdown-item" href="#!">Low</a>
                </div>
            </li>
        </ul>
        <div class="nav-item nav-grid">
            <span class="m-r-15">View Mode: </span>
            <button type="button" class="btn btn-sm btn-primary waves-effect waves-light m-r-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="list view">
            <i class="icofont icofont-listine-dots"></i>
            </button>
            <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="grid view">
            <i class="icofont icofont-table"></i>
            </button>
        </div>
        <!-- end of by priority dropdown -->
    </nav>
    <!-- Nav Filter tab end -->
    <!-- Task board design block start-->
</div>
<!-- Task-detail-right start -->
<div class="col-xl-4 col-lg-12 push-xl-8 task-detail-right">
    <div class="card">
        <div class="card-header">
            <h5 class="card-header-text">Money</h5>
        </div>
        <div class="card-block">
            <div class="counter">
                <span>Available Balance</span>
                <h2>
	                	@if($balance < 0)

	                	<b class="lbl-red"> -${{abs($balance) }} </b>
		                @else
		            	 <b>${{$balance}} </b>
		            		
		            	@endif
	            	<b>USD </b></h2>
            </div>
        </div>
        <div class="card-footer">
            <div class="f-left">

                 <div class="dropdown-primary dropdown open">
                    <button class="btn btn-sm btn-primary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Deposit</button>
                    <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <a href="javascript:;" class="dropdown-item waves-light waves-effect" data-toggle = "modal" data-target = "#bank-transfer-deposit-modal">Bank Transfer</a>
                        <a class="dropdown-item waves-light waves-effect"  id="credit-card-drop-class" href="javascript:;">Credit Card</a>
                        <a class="dropdown-item waves-light waves-effect" data-toggle = "modal" data-target = "#deposit_modal" href="javascript:;">Paypal</a> 
                    </div>
                </div>




                
                @if($balance > 0 )
                <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle = "modal" data-target = "#withdraw_modal">Widthdraw</a>
                @endif

            </div>
            <div class="f-right">
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-header-text">Credit Card</h3>
            <button class="f-right btn btn-primary btn-sm"  id="add_credit_card_id"> Add Credit Card</button>
        </div>
    </div>

    <div class="card-html">
    
        {{-- <div>
            <i class="icofont icofont-visa-alt"></i>
            <h5>**** **** **** 1567</h5>
            <div class="row m-t-10">
                <div class="col-sm-6">
                    <strong class="m-r-5">Expiry Date :</strong>20/09/17
                </div>
                <div class="col-sm-6 text-right">
                    <strong class="m-r-5">Name :</strong>Airi Sawarm
                </div>
            </div>
        </div> --}}

        {{-- <div>
            <i class="icofont icofont-visa-alt"></i>
            <h5>**** **** **** 1567</h5>
            <div class="row m-t-10">
                <div class="col-sm-6">
                    <strong class="m-r-5">Expiry Date :</strong>20/09/17
                </div>
                <div class="col-sm-6 text-right">
                    <strong class="m-r-5">Name :</strong>Airi Sawarm
                </div>
            </div>
        </div> --}}
    
</div>

 




</div>
<!-- Task-detail-right start -->
<!-- Task-detail-left start -->
<div class="col-xl-8 col-lg-12 pull-xl-4">
    <div class="card">
        <div class="card-header row">
            <h5 class="col-md-6 float-left"><i class="icofont icofont-tasks-alt m-r-5"></i> Transactions</h5>
            <div class="col-md-5">
                <ul class="nav-transaction">
                    <li><label <span class="label label-success"></label>Deposit</li>
                    <li><label <span class="label label-danger"></label>withdrawal</li>

                </ul>
            </div>
        </div>
        <div class="card-block">
            
            
            <div class="table-responsive">
                <table class="table table-framed">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Ref ID</th>
                            <th>Opening Blanace</th>
                            <th>Amount</th> 
                            <th>Closing Blanace</th>
                        </tr>
                    </thead>
                    <tbody>

                        
                        @foreach($transactions_rec as $transaction_rec)
                        <tr role="row" class="odd">
                            <td class="txt-primary" tabindex="0">
                                {{Helper::formatDate($transaction_rec->created_at)}}
                            </td>

                            
                            <td> 
                            @if($transaction_rec->type == 'deposit')

                                {{@$transaction_rec->details->ref_code}}
                             @endif
                            </td>
                           

                             
                            <td class="text-center">
                                <span >{!! Helper::manipulateAmount($transaction_rec->transaction->opening_balance) !!}</span>
                            </td>

                            <td>
                                @if($transaction_rec->type == 'withdrawal')
                                <span class="label label-danger">-{!! Helper::manipulateAmount($transaction_rec->amount) !!}</span>
                                @endif

                                @if($transaction_rec->type == 'deposit')
                                <span class="label label-success"><b>+</b>{!! Helper::manipulateAmount($transaction_rec->amount)!!}</span>
                                @endif
                            </td>


                            
                            
                            <td>
                                <span class="">{!! Helper::manipulateAmount($transaction_rec->transaction->closing_balance)!!}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                   
                </table>

            </div>
        
           {{--  <button id="btn-refund">Click</button> --}}
            <div class="f-right">
            {{$transactions_rec->links()}}
            </div>
        </div>


    </div>
</div>














 
























<!-- Task-detail-left end -->
@include('js-css-blades.select2-multiselect')
@include('frontend.dashboard.wallet.credit-card-modal')
@include('frontend.dashboard.wallet.credit-card-verified')
@include('js-css-blades.pnotify')
@include('js-css-blades.card')
@include('frontend.dashboard.wallet.bank-transfer-deposit-modal')
@include('frontend.dashboard.wallet.credit-card-deposit-modal')
@include('frontend.dashboard.wallet.Widthdraw_modal')

@include('js-css-blades.datatables')
@section('styles')
<link href="{{URL::asset('adminity-components/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
@endsection



@section('document_ready')
@parent
     "use strict";
    $("#add_credit_card_id").click(function() {
        $("#add_credit_card_model").modal("show");
    });

     $(".card-header-right .close-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').animate({
            'opacity': '0',
            '-webkit-transform': 'scale3d(.3, .3, .3)',
            'transform': 'scale3d(.3, .3, .3)'
        });

        setTimeout(function() {
            $this.parents('.card').remove();
        }, 800);
    });

    $(".card-header-right .minimize-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        $(this).toggleClass("icon-minus").fadeIn('slow');
        $(this).toggleClass("icon-plus").fadeIn('slow');
    });
    $(".card-header-right .full-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).toggleClass("icon-maximize");
        $(this).toggleClass("icon-minimize");
    });
     
    $('#credit-card-drop-class').on('click',function(){

        checkCreditCardExist();
    });

    $('#btn-refund').click(function(){
        $.ajax({
          type: "POST",
          url: "{{route('credit_card.refund-credit-card')}}",
          data: $('#credit-card-deposit-form').serialize(),
          dataType: "JSON",
          success: function (response) {
              
              
          },
          error: function(jqXHR, exception){
          
          }
        });
    });



   
  
 
   getJsonCreditCard();
   
@endsection

@section('script')
{{-- <script src="{{URL::asset('adminity-components/bootstrap-tagsinput/js/bootstrap-tagsinput.js')}}"></script> --}}
<script>
@parent   
function getJsonCreditCard()
{
    $.ajax({
          type: "POST",
          url: "{{route('credit_card.credit_card_all')}}",
          data: $('#credit_card_form').serialize(),
          dataType: "JSON",
          success: function (response) {
              creditcardRender(response); 
          },
          error: function(jqXHR, exception){
            
            
        }
      });
}

function checkCreditCardExist() {
     $.ajax({
          type: "POST",
          url: "{{route('credit_card.credit-card-exist')}}",
          dataType: "JSON",
          success: function (response) {
            if(response.status == 0)
            {
                var html_credit_card = '<div class="col-md-12 col-sm-12 col-lg-12"><h4>Credit card not verified...</h4></div>';
                $('.add-credit-card-verify').html(html_credit_card);
                $("#credit-card-deposit-modal").modal('show');
            } else {
                renderVerifyCreditCard(response); 
            }
             
          },
          error: function(jqXHR, exception){
            
            
        }
      });
}

</script>
@endsection
@endsection