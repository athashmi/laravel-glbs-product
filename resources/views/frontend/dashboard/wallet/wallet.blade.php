@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('wallet') }}
{{-- <ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Data Tables</li>
</ol> --}}

 
</div>
</div>
</div>



<div class=" container-fluid   container-fixed-lg bg-white">
<div class="card card-transparent">
<div class="card-header ">
<div class="card-title">Wallet History
</div>
 
 
<div class="clearfix"></div>
</div>
<div class="card-body">
<div class="row">
<div class="col-lg-9">

  <div class="card card-default">
       
       <!--  <div class="card-body"> -->
        <div class="col-lg-12">
          <div class="col-lg-4  m-t-30 pull-left">
            

            
            <div class="m-b-10 row">
            <div class="col-lg-12 bg-white b-a b-grey padding-10">
              <span>Available Balance</span>
                <h2 class="text-center">
                    @if($balance < 0)

                    <b class="lbl-red"> -${{abs($balance) }} </b>
                    @else
                   <b>  <sup>
                          <small class="semi-bold">$</small>
                        </sup>{{$balance}} </b>
                    
                  @endif
                <b>USD </b></h2>
            </div>
          </div>
                

          <div class="row">
              <div class="col-lg-4">
                   <div class="dropdown-primary dropdown open">
                      <button class="btn btn-sm btn-primary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Deposit</button>
                      <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                          <a href="javascript:;" class="dropdown-item waves-light waves-effect" data-toggle = "modal" data-target = "#bank-transfer-deposit-modal">Bank Transfer</a>
                          <a class="dropdown-item waves-light waves-effect"  id="credit-card-drop-class" href="javascript:;">Credit Card</a>
                          <a class="dropdown-item waves-light waves-effect" data-toggle = "modal" data-target = "#paypal_model" href="javascript:;" >Paypal</a> 
                      </div>
                  </div>

              </div>
                  @if($balance > 0 )
                  <div class="col-lg-4">
                    <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle = "modal" data-target = "#withdraw_modal">Widthdraw</a>
                  </div>
                  @endif

          </div>      

            <!-- <div class="col-md-12 no-padding">
              <div class="row m-l-5 m-t-10">
                <div class="col-1 no-padding ">
                  <div class="bg-success p-t-30 p-b-11"></div>
                </div>
                <div class="col-10 bg-white b-a b-grey padding-10">
                  <p class="no-margin text-black bold text-uppercase fs-12">Deposit</p>
                </div>
              </div>
            </div>
            <div class="col-md-12 no-padding">
              <div class="row m-l-5 m-t-10">
                <div class="col-1 no-padding ">
                  <div class="bg-danger  p-t-30 p-b-11"></div>
                </div>
                <div class="col-10 bg-white b-a b-grey padding-10">
                  <p class="no-margin text-black bold text-uppercase fs-12">Withdrawal</p>
                </div>
              </div>
            </div>
            <div class="col-md-12 no-padding">
              <div class="row m-l-5 m-t-10">
                <div class="col-1 no-padding ">
                  <div class="bg-warning p-t-30 p-b-11"></div>
                </div>
                <div class="col-10 bg-white b-a b-grey padding-10">
                  <p class="no-margin text-black bold text-uppercase fs-12">Refunded</p>
                </div>
              </div>
            </div> -->
            <div class="clearfix"></div>
          </div>
          <div class="col-lg-3 no-padding m-b-10 pull-right">
                <canvas id="myChart" width="250" height="250"></canvas>
          </div>
        </div>
        <!-- </div> -->
  </div>
 
  

  
<div class="col-lg-12 no-padding">
    <div class="card card-default">
        <div class="card-header ">
            <div class="card-title">
            </div>  
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover transaction_shopaholic demo-table-search table-responsive-block datatable" id="">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Ref ID</th>
                        <th>Opening Blanace</th>
                        <th>Amount</th> 
                        <th>Closing Blanace</th>
                      </tr>
                    </thead>
                  <tbody>

                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="col-lg-3 padding-0">

{{--<div class="col-lg-12">
    <div class="card card-default">
       
        <div class="card-body">
           <span>Available Balance</span>
                <h2>
                    @if($balance < 0)

                    <b class="lbl-red"> -${{abs($balance) }} </b>
                    @else
                   <b>  <sup>
                          <small class="semi-bold">$</small>
                        </sup>{{$balance}} </b>
                    
                  @endif
                <b>USD </b></h2>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-lg-4">
                 <div class="dropdown-primary dropdown open">
                    <button class="btn btn-sm btn-primary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Deposit</button>
                    <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <a href="javascript:;" class="dropdown-item waves-light waves-effect" data-toggle = "modal" data-target = "#bank-transfer-deposit-modal">Bank Transfer</a>
                        <a class="dropdown-item waves-light waves-effect"  id="credit-card-drop-class" href="javascript:;">Credit Card</a>
                        <a class="dropdown-item waves-light waves-effect" data-toggle = "modal" data-target = "#paypal_model" href="javascript:;" >Paypal</a> 
                    </div>
                </div>

            </div>
                @if($balance > 0 )
                <div class="col-lg-4">
                  <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle = "modal" data-target = "#withdraw_modal">Widthdraw</a>
                </div>
                @endif

          </div>
            <div class="f-right">
            </div>
        </div>
    </div>
</div>--}}
<div class="col-lg-12">
    <div class="card card-default">
        <div class="card-header ">
            <div class="card-title">Credit Card
            </div>  
            <button class="pull-right btn btn-primary btn-sm"  id="add_credit_card_id"> Add Credit Card</button>
        </div>
    </div>



</div>
<div class="col-lg-12 card-html">
</div>

</div>

</div>
</div>
</div>

</div>





</div>

@include('revox-theme.js-css-blades.card')
@include('frontend.dashboard.wallet.credit-card-modal')
@include('frontend.dashboard.wallet.credit-card-verified')
@include('frontend.dashboard.wallet.bank-transfer-deposit-modal')
@include('frontend.dashboard.wallet.credit-card-deposit-modal')
@include('frontend.dashboard.wallet.Widthdraw_modal')
@include('revox-theme.js-css-blades.select2')
@include('frontend.dashboard.wallet.paypal-modal')
@include('revox-theme.js-css-blades.datatables')
@endsection


{{--@section('styles')
<link href="{{URL::asset('adminity-components/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
@endsection--}}



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
        $("#credit-card-field").val('');
        $("#shopaholic_id_add_d").val('');
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

     var datatbl = $('.transaction_shopaholic').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('wallet.gettransaction') }}",
        columns: [ 
             {
                "className":      'details-control',
                "orderable":      false,
                "searchable":     false,
                "data":           null,
                "defaultContent": '<img src="{{asset('images/details_open.png')}}" class="btn-open">'
            },
            {data: 'created_at',"className": "text-center"},
            {data: 'ref_code',"className": "text-center"},
            {data: 'opening_balance',"className": "text-center"},
            {data: 'amount',"className": "text-center"},
            {data: 'closing_balance',"className": "text-center"},
           
        ],
        order: [[ 1, "desc" ]]
        });
        
    
    $('.transaction_shopaholic tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
          
        var row = datatbl.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            $(this).html('<img src="{{asset('images/details_open.png')}}" />');
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( template(row.data()) ).show();
            $(this).html('<img src="{{asset('images/details_close.png')}}" />');
            tr.addClass('shown');
        }
    });

   

     
     $(".datatable").css('width','100%');
    var template = Handlebars.compile($("#details-template").html());
    Handlebars.registerHelper('Requesttype', function(context, options) {
        if(context.data.root.type == 'deposit' && context.data.root.details.child_request_id == 0 && (context.data.root.details.deposit.process_via == 'authorize_net' || context.data.root.details.deposit.process_via == 'paypal' ))
        {
            return '<tr><td><button class="btn btn-primary btn-sm ref_btn_pay loading_class" onclick = refundTransaction('+context.data.root.id+',"'+context.data.root.details.deposit.process_via+'") data-id="context.data.root.id">Refund Payment</button></td><td></td></tr>';
        }
        else
        {
            return "";
        }
        
    });
    
    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
   getJsonCreditCard();


   var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
    type: 'doughnut',
     data:{
              datasets: [{
                  data: [{{$deposits}}, {{$withdrawals}},{{$refunds}}],
                  backgroundColor: [
                '#10cfbd',
                '#f55753',
                '#f8d053']
              }],

              labels: [
                  'Deposits: ${{$deposits}}',
                  'Withdreawals: ${{$withdrawals}}',
                  'Refunds: ${{$refunds}}'
              ]
          },
          options: {
        responsive: true,
         legend: {
            display: true,
           /*onClick:function()
           {

           }*/
            
        },
        tooltips: {
        enabled:false
      }
      }
  });
     
     
@endsection
 
@section('script')
@parent
{{--<script type="text/javascript" src="{{URL::asset('js/Chart.min.js')}}"></script> --}}

<script id="details-template" type="text/x-handlebars-template">
    <table class="table">
        <tr>
            <th> Status :</th>
            <td>@{{status}}</td>
        </tr>
        <tr>
            <th> Request Type :</th>
            <td>@{{type}}</td>
        </tr>
        
        @{{#Requesttype}}
        
        @{{/Requesttype}}
    </table>
</script>

<script>
 
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
               
                var html_credit_card = '<div class="col-md-12 col-sm-12 col-lg-12"><h4>Please Verify or Add the credit Card First...</h4></div>';
                $('.add-credit-card-verify').html(html_credit_card);
                $('.exist-credit-card').css('display','none');
                $('.btn-amount-credit-card').hide();
                 
                $("#credit-card-deposit-modal").modal('show');
            } else {
              $("#error_msgs_credit_card_deposit_form").html('');
              $("#credit-card-deposit-form")[0].reset();
                renderVerifyCreditCard(response); 
                $("#shopaholic_id_add_d").val(response.data[0].shopaholic_id);
            }
             
          },
          error: function(jqXHR, exception){
            
            
        }
      });
}

function refundTransaction(id,transactionProcessVia) {


    $.ajax({
          type: "POST",
          url: (transactionProcessVia == 'authorize_net') ? "{{route('credit_card.refund-credit-card')}}" : "{{route('paypal.refund_deposit')}}", 
          data: {'id' : id},
          dataType: "JSON",
          success: function (response) {
          
               if(response.status == 1) {
                responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}",response.Msg);
                $('.transaction_shopaholic').DataTable().draw();
                 setTimeout(function() { 
                    location.reload();
                }, 2000);
              }
              if(response.status == 0) {
                responseMsg("error","{{asset('images/error.png')}}",response.Msg);
              }
               
          },
          error: function(jqXHR, exception){
           if(exception == 'error'){
            responseMsg('error',"{{asset('images/error.png')}}",'Something Went Wrong...');
           }
            
        }
      });
}

</script>
@endsection