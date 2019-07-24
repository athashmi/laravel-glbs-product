
      <div class="modal fade stick-up" id="update_wallet_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Update Wallet</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_shopaholic_wallet_update" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
                <input type="hidden" name="u_id" id="s_u_wallet">
                <div class="form-group">
                    <label>Current wallet amount</label>
                    <input placeholder="Current Wallet Amount" id="c_wallet_amount" class="form-control wallet-update-input"  name="c_wallet_amount" type="text" disabled="true">
                </div>
               
                <div class="form-group">
                    <label>Enter wallet amount</label>
                    <input placeholder="$20" id="wallet_amount" class="form-control" name="wallet_amount" type="text">
                </div>

                <div class="form-group">
                    <label>Reason to Update</label>
                    <textarea class="form-control" name="remarks"></textarea>
                    
                </div>
                <div class="error_msg_up_w">
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="updateWalletShopaholic()">Update Wallet</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('document_ready')
@parent
 
  $('#update_wallet_modal').on('shown.bs.modal', function (e) {
      
        var id = $(e.relatedTarget).data('id');
         
        $('.error_msg_up_w').html('');
        $.post('{{URL::route("shopaholic.get-shopaholic-wallet")}}',{'id':id},function(response) {
              $("#s_u_wallet").val(id);
              $("#c_wallet_amount").val(response.balance);
               
            

        },"json");

      });

@endsection
@section('script')
@parent
 <script>
   function updateWalletShopaholic() {
     var id  = $("#s_u_wallet").val();
    
    $.ajax({
        type: "post",
        url: '{{URL::route("shopaholic.update-shopaholic-wallet")}}',
        data: $("#formid_shopaholic_wallet_update").serialize(),
        dataType: "JSON",
          success: function (response) {
            if(response.status == 1){

              $('#update_wallet_modal').modal('hide'); 
              responseMsg('update','{{asset('images/icons8-ok-filled-480.png')}}');
            }
            if(response.status == 0){
              responseMsg('error',"{{asset('images/icons8-ok-filled-480.png')}}");
              $('#update_wallet_modal').modal('hide'); 
            }
          },
          error: function (jqXHR, exception) {
            if (jqXHR.status == 422) {
              var html_error = '';
              $.each(jqXHR.responseJSON.errors, function (key, value)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
              })
              html_error += "</ul></div>";
              $('.error_msg_up_w').html(html_error);
              // setTimeout(function(){
              //   $(".error_msg_up_w").html('');
              // },2000);
            }
          }
        });


 


   }
</script>
@endsection