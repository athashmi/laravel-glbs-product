     <div class="modal fade stick-up" id="credit-card-modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Verify Credit Card</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="verify-credit-card-form" action="javascript:;" accept-charset="UTF-8">
          @csrf
      <div class="modal-body"> 
                <div class="form-group">
                    <label>First Transaction Amount</label>
                    <input placeholder="First Transaction Amount" id="first_transaction_amount" class="form-control" name="first_transaction_amount" type="text">
                </div>
                <input type="hidden" name="digit_attempt" id="digit_attempt">
               
                <div class="form-group">
                    <label>Second Transaction Amount</label>
                    <input placeholder="Second Transaction Amount" id="second_transaction_amount" class="form-control" name="second_transaction_amount" type="text">
                    <span id="error_msg"></span>
                </div>
                <div class="form-group">
                    <label>Credit Card Last Four Digit</label>
                    <input placeholder="Second Transaction Amount" id="second_transaction_amount" class="form-control" name="last_four_digit" type="text">
                    <span id="error_msg"></span>
                </div>
                <div class="error_msg_c_v"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary card-verify">Verify Credit Card</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('document_ready')
@parent

  




$(".card-verify").on("click",function(){
 var html_error = '';
	$.ajax({
          type: "POST",
          url: "{{route('credit_card.verify_card')}}",
          data: $('#verify-credit-card-form').serialize(),
          dataType: "JSON",
          success: function (response) {
              if(response.status == 0)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Wrong Information. Try Again</div></div>';
                $('.error_msg_c_v').html(html_error);
              }
              if(response.status == 1)
              {
                getJsonCreditCard();
                responseMsg("verified","{{asset('images/icons8-ok-filled-480.png')}}");
                $('#credit-card-modal').modal('hide'); 
              }
              if(response.status == 5)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Card Blocked</div></div>';
                $('.error_msg_c_v').html(html_error);
                location.reload();
              }
              
          },
          error: function(jqXHR, exception){
            if (jqXHR.status == 422) {
             
              $.each(jqXHR.responseJSON.errors, function (key, value)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
              })
              html_error += "</ul></div>";
              $('.error_msg_c_v').html(html_error);
              
            }
        }
      });
})



@endsection

@section('script')
@parent
<script>
  /*
  function submitDepositRequest() {
      $.ajax({
          type: "POST",
          url: "{{route('wallet.deposit')}}",
          data: $('#formid_create').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert",response.msg);
            $('#deposit_modal').modal('hide'); 
          }
          if(response.status == 0)
          {
            responseMsg("error",response.msg);
            $('#deposit_modal').modal('hide'); 
          }

          },
          error: function(jqXHR, exception){
            
            var html_error = '<div  class="alert " style="background-color:#e67070; color:white;"><ul>';
            $.each(jqXHR.responseJSON.errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
             html_error += "</ul></div>";
          $('#error_msgs1').html(html_error);
          setTimeout(function(){
                $("#error_msgs1").html('');
          },2000);
        }
      });
    }
    */
</script>
@endsection