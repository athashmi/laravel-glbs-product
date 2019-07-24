<div class="modal fade stick-up" id="detailwithdraw" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Withdrawal Details</h4>
        <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <?php // $detail = json_decode($withdraws_obj->details);?>
        <div class="general-info">
          <div class="row">
            <div class="col-lg-12 col-xl-6">
              <div class="table-responsive">
                <table class="table m-0">
                  <tbody>
                    <tr>
                      <th scope="row">First Name</th>
                      <td id="f_name"></td>
                    </tr>
                    <tr>
                      <th scope="row">Last Name</th>
                      <td id="l_name"></td>
                    </tr>
                    <tr>
                      <th scope="row">Withdrawal Amount</th>
                      <td id="amount"></td>
                    </tr>

                    <tr>
                      <th scope="row">Wallet Balance</th>
                      <td id="w_balance"></td>
                    </tr>
                    {{-- <tr>
                      <th scope="row">Marital Status</th>
                      <td d>Single</td>
                    </tr>
                    <tr>
                      <th scope="row">Location</th>
                      <td>New York, USA</td>
                    </tr> --}}
                  </tbody>
                </table>
              </div>
            </div>
            <!-- end of table col-lg-6 -->
            <div class="col-lg-12 col-xl-6">
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <th scope="row">Bank Name:</th>
                      <td id="b_name"></td>
                    </tr>
                    <tr>
                      <th scope="row">Routing transit #:</th>
                      <td id="r_transit"></td>
                    </tr>
                    <tr>
                      <th scope="row">Account #:</th>
                      <td id="acc_no"></td>
                    </tr>
                    <tr>
                      <th scope="row">Bank Address</th>
                      <td id="b_address"></td>
                    </tr>
                    <tr>
                      <th scope="row">Remarks</th>
                      <td id="remarks"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- end of table col-lg-6 -->
          </div>
          <!-- end of row -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

@section('script')
@parent
<script>
   $('#detailwithdraw').on('shown.bs.modal', function (e) {
   var details_rec = $(e.relatedTarget).data('details');
   console.log(details_rec);
   var details = details_rec.details;

   let w_balance = 0;
   if(details_rec.wallet_balance <0)
        w_balance = '<h4>'+manipulateAmount(details_rec.wallet_balance)+' USD<h4>';
    else
    	w_balance = '<h4>'+manipulateAmount(details_rec.wallet_balance)+'<h4>';


//console.log(details.first_name);
        $(this).find("#f_name").html(details.withdrawal.first_name);
        

        $(this).find("#w_balance").html(w_balance);
        $(this).find("#amount").html('<h4>'+manipulateAmount(details_rec.amount)+'</h4>');
        $(this).find("#l_name").html(details.withdrawal.last_name);
        $(this).find("#b_name").html(details.withdrawal.bank_name);
        $(this).find("#r_transit").html(details.withdrawal.bank_transit_name);
        $(this).find("#acc_no").html(details.withdrawal.bank_account_no);
        $(this).find("#b_address").html(details.withdrawal.bank_address);
        $(this).find("#remarks").html(details.withdrawal.remarks);
        

});
</script>
@endsection