<!-- Model for create Country -->
    <div class="modal fade stick-up" id="bank-transfer-deposit-modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Deposit Money</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create" action="javascript:;" accept-charset="UTF-8">
          @csrf
        <div class="modal-body">
        	<div class="row">
                  <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                      <label>Transaction Id</label>
                      <input placeholder="145878544" id="transaction_id" class="form-control" name="transaction_id" type="text">
                  </div>
                 
                  <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                      <label>Transaction Amount</label>
                      <input placeholder="$20" id="transaction_amount" class="form-control" name="transaction_amount" type="text">
                      <span id="error_msg"></span>
                  </div>
                  <div class="col-md-12">
                  <div class="error_msg_b_d_p"></div>
          </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="submitBankTransferDepositRequest()">Deposit Money</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('script')
@parent
<script>
  function submitBankTransferDepositRequest() {
      $.ajax({
          type: "POST",
          url: "{{route('wallet.deposit')}}",
          data: $('#formid_create').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
            $('#bank-transfer-deposit-modal').modal('hide'); 
          }
          if(response.status == 0)
          {
            responseMsg("error","{{asset('images/error.png')}}",response.msg);
            $('#bank-transfer-deposit-modal').modal('hide'); 
          }

          },
          error: function(jqXHR, exception){
            if (jqXHR.status == 422) {
              var html_error = '';
              $.each(jqXHR.responseJSON.errors, function (key, value)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
              })
              html_error += "</ul></div>";
              $('.error_msg_b_d_p').html(html_error);
              
            }
        }
      });
    }
</script>
@endsection