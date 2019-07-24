<!-- Model for create Country -->
    <div class="modal fade stick-up" id="withdraw_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Widthdraw Money</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create2" action="javascript:;" accept-charset="UTF-8">
            @csrf
      <div class="modal-body">
      	<div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>First Name</label>
                    <input placeholder="First Name" id="first_name" class="form-control" name="first_name" type="text">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Last Name</label>
                    <input placeholder="Last Name" id="last_name" class="form-control" name="last_name" type="text">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Bank Name</label>
                    <input placeholder="Bank Name" id="b_name" class="form-control" name="bank_name" type="text">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Bank Routing Transit Number</label>
                    <input placeholder="Transit Number" id="b_t_name" class="form-control" name="bank_transit_name" type="text">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Bank Account Number</label>
                    <input placeholder="Account Number" id="b_a_name" class="form-control" name="bank_account_no" type="text">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Confirm Bank Account Number</label>
                    <input placeholder="Confirm Account Number" id="c_b_a_name" class="form-control" name="bank_account_no_confirmation" type="text">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Bank Address</label>
                    <input placeholder="Bank Address" id="b_address" class="form-control" name="bank_address" type="text">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Total Withdraw</label>
                    <input placeholder="less then $100"  id="total_w_draw" class="form-control" name="total_withdraw" type="text" >
                </div>
                <div class="form-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                    <label>Remarks</label>
                    <textarea placeholder="Remarks" id="remarks" class="form-control" name="remarks"></textarea>
                </div>
                <div class="border-checkbox-section col-md-12 col-sm-12 col-xs-12 col-lg-12">
                    <div class="border-checkbox-group border-checkbox-group-primary">
                            <input class="border-checkbox" type="checkbox" name="verification" id="checkbox1">
                            <label class="border-checkbox-label" for="checkbox1">I certify all information provided is correct.</label>
                    </div> 
                </div> 
               
                
        </div>
        <div class="error_msg_w_w_d"></div>
      </div>
      </form>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="submitWithDrawRequest()">WidthDraw</button>
      </div>
      
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('script')
@parent
<script>
   function submitWithDrawRequest() {
      $.ajax({
          type: "POST",
          url: "{{route('wallet.withdraw')}}",
          data: $('#formid_create2').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
            $('#withdraw_modal').modal('hide'); 
          }
          if(response.status == 0)
          {
            responseMsg("error","{{asset('images/error.png')}}",response.msg);
            $('#withdraw_modal').modal('hide'); 
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
              $('.error_msg_w_w_d').html(html_error);
              
            }
        }
      });
    }
</script>
@endsection