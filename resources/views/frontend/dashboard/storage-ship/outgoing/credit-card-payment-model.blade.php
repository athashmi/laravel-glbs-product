<div class="modal fade slide-right" id="credit-card-deposit-modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title pull-left" id="myModalLabel">Credit Card Detail</h4>
				{{-- <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button> --}}
			</div>
			
			<div class="modal-body">
				<div class="row add-credit-card-verify">
					<div class="form-group col-md-4 col-sm-4 col-xs-12 col-lg-4">
					</div>
				</div>
				<div class="card-block">
					<div class="row exist-credit-card">
						<div class="col-sm-12">
							<div class="card-wrapper"></div>
						</div>
						<div class="col-sm-12 credit-card">
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
									<input name="csv" type="number" class="form-control" placeholder="CSV">
								</div>
								{{-- <div class="form-group">
									<label>Amount</label>
									<input name="amount" type="number" class="form-control" placeholder="Amount">
								</div> --}}
								<div class="form-group">
								</div>
								<span id="error_msgs_credit_card_deposit_form"></span>
							</form>
						</div>
					</div>
				</div>
				<div class="error_msg_c_c_e"></div>
				<div class="modal-footer p-0" style="margin-top: 20px !important; margin-bottom: 0px !important;">
					<button type="button" class="btn btn-default btn_close_model" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success btn-amount-credit-card">Proceed To Checkout</button>
				</div>
			</div>
			
			
			
		</div>
	</div>
</div>
@section('document_ready')
@parent
$('#credit-card-field').val('');
$(".select-credit-card").on('change',function(){
alert(this.val());
});
{{-- $(".select-credit-card").select2({
dropdownParent: $("#credit-card-deposit-modal")
}); --}}
$('.btn_close_model').click(function(){
	$('.btn_checkout').show();
});
$('.btn-amount-credit-card').click(function(){
	$.ajax({
        type: "POST",
        url: "{{route('frontend.consolidate.post_checkout')}}",
        data: $('.form_checkout').serialize()+'&'+$('#credit-card-deposit-form').serialize(),
        dataType: "JSON",
        success: function (response) {
        	if(response.status == 1){
        		responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}','Payment sucscessfully processed...');
				setTimeout(function(){
				 location.replace("{{route('storage.index','list')}}"); 
				}, 2000);
				
        	}
        	$('.error_msg_c_c_e').html('');
      },
      error: function (jqXHR, exception) {
      	if (jqXHR.status == 422) {
          var html_error = '';
          $.each(jqXHR.responseJSON.errors, function (key, value)
          {
            html_error +='<div class="pgn push-on-sidebar-open pgn-simple" style="margin-left:0px; margin-right:0px;"><div class="alert alert-danger"><button type="button" class="close m-t-15" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
          })
          html_error += "</ul></div>";
          $('.error_msg_c_c_e').html(html_error);
        }
      }
    });
});
@endsection
@section('script')
@parent
<script>
</script>
@endsection