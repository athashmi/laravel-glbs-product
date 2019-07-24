<!-- Model for create Country -->
    <div class="modal fade stick-up" id="credit-card-deposit-modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Deposit Money </h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        
        <div class="modal-body">
        	<div class="row add-credit-card-verify">

                  <div class="form-group col-md-4 col-sm-4 col-xs-12 col-lg-4">
                     {{-- <div class="card payment-card">
                      <div class="">
                       <div class="border-checkbox-section f-right  btn-click-credit-card col-md-12 col-sm-12 col-xs-12 col-lg-12">
                            <div class="border-checkbox-group border-checkbox-group-primary">
                                <input class="border-checkbox" type="checkbox" name="verification" id="checkbox1">
                                <label class=" border-checkbox-label" for="checkbox1"></label>
                            </div> 
                       </div>
                      <i class="icofont icofont-visa-alt"></i>
                      <h5>**** **** ****7777 </h5>  
                    </div>
                  </div>   --}}
                </div>
          
        </div>
       

         <div class="card-block">
                    <div class="row exist-credit-card">
                        <div class="col-sm-12">
                            <div class="card-wrapper2"></div>
                        </div>
                        <div class="col-sm-12 credit-card2">
                             <form class="payment-form active form" id="credit-card-deposit-form">

                               <input type="hidden" name="shopaholic_id" id="shopaholic_id_add_d">
                                <input type="hidden" name="credit_card" id="credit-card-field">
                                <div class="form-group">
                                    <label>Card Number</label>

                                    <input name="number"  type="tel" class="form-control" placeholder="Card Number" id="">

                                </div>
                               
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" type="text" class="form-control" placeholder="Name">
                                </div>
                                   <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input name="expiry" type="tel" class="form-control" placeholder="MM/YY">
                                </div>
                                <div class="form-group">
                                    <label>CSV Code</label>
                                    <input name="cvc" type="number" class="form-control" placeholder="CSV">
                                </div>
                                 <div class="form-group">
                                    <label>Amount</label>
                                    <input name="amount" type="number" class="form-control" placeholder="less then $100">
                                </div>
                                <div class="form-group">
                                </div>
                            <span id="error_msgs_credit_card_deposit_form"></span>
                            </form> 
                        </div>
                    </div>
                </div>

    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-amount-credit-card" onclick = "depositCreditCardAmount()">Deposit Money</button>
      </div>
   
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('document_ready')
@parent

$('#credit-card-field').val('');

$(".select-credit-card").on('change',function(){
  alert(this.val());
});
 $(".select-credit-card").select2({
 dropdownParent: $("#credit-card-deposit-modal")
});



 
@endsection

@section('script')
@parent

<script>
                   
function renderVerifyCreditCard(creditCardArray) {
    var data = creditCardArray;
            var html_credit_card = "";
            $.each(data['data'],function(key,value){ 
               html_credit_card += '<div class="form-group col-md-4 col-sm-4 col-xs-12 col-lg-4"><div class="card payment-card"> <div class=" "><div class="border-checkbox-section f-right  btn-click-credit-card col-md-12 col-sm-12 col-xs-12 col-lg-12"><input type="hidden" name = "checkbox" id="credit-card-'+value.id+'" value="'+value.digit+'"><div class="border-checkbox-group border-checkbox-group-primary"><input class="checkbox-con border-checkbox " onclick = "selectedBox('+value.id+')" type="checkbox" name="verification" id="checkbox1'+value.id+'"><label class=" border-checkbox-label" for="checkbox1'+value.id+'"></label></div> </div>';
               
               if(value.type == 'visa')
               {
                html_credit_card += '<img src="{{asset('images/visa.png')}}" style="    width: 66px;height: 63px; margin-left: 16px;" class="img-fluid" />';
               }
               if(value.type == 'master')
               {
                html_credit_card += '<img src="{{asset('images/master_card.png')}}" style="    width: 66px;height: 63px; margin-left: 16px;" class="img-fluid" />';
               }
               if(value.type == 'discover')
               {
                html_credit_card += '<img src="{{asset('images/discover.png')}}" style="    width: 66px;height: 63px; margin-left: 16px;" class="img-fluid" />';
               }
               if(value.type == 'american')
               {
                html_credit_card += '<img src="{{asset('images/american_express.png')}}" style="    width: 66px;height: 63px; margin-left: 16px;" class="img-fluid" />';
               }
               
               html_credit_card += '<h5>**** **** ****'+value.digit+' </h5></div></div></div>';
              
            });
           // console.log(html_credit_card);
          $('.add-credit-card-verify').html(html_credit_card);
          $("#credit-card-deposit-modal").modal('show');
}

 
function selectedBox(id)
{
  $(".checkbox-con").each(function() {
    $(this).prop('checked', false);
  });
  $('#checkbox1'+id).prop('checked',true);
  $('#credit-card-field').val($("#credit-card-"+id).val());
}

function depositCreditCardAmount() {
   var html_error = '';
    $.ajax({
          type: "POST",
          url: "{{route('credit_card.deposit-credit-card')}}",
          data: $('#credit-card-deposit-form').serialize(),
          dataType: "JSON",
          success: function (response) {
              if(response.status == 1)
              {

                responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
                $('#credit-card-deposit-modal').modal('hide');
                $('.transaction_shopaholic').DataTable().draw();
                location.reload();
              }
              if(response.status == 'not')
              {
                 html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+response.message+'</div></div>';
                $("#error_msgs_credit_card_deposit_form").html(html_error);
           
              }

              if(response.status == 'not_matched')
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+response.message+'</div></div>';
                $("#error_msgs_credit_card_deposit_form").html(html_error);
                  
              }
              
          },
          error: function(jqXHR, exception){
          
           if (jqXHR.status == 422) {
             
              $.each(jqXHR.responseJSON.errors, function (key, value)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
              })
              html_error += "</ul></div>";
              $('#error_msgs_credit_card_deposit_form').html(html_error);
            }
           
      }
      });
}




</script>
@endsection