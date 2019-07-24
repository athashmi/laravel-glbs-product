
    <div class="modal fade stick-up" id="paypal_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">PayPal</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_paypal" action="{{route('paypal.deposit')}}" accept-charset="UTF-8">
          @csrf
      <div class="modal-body">
                <div class="form-group">
                    <label>Deposit Amount</label>
                    <input placeholder="Amount is less then $100" value="{{old('amount')}}" id="amount_paypal" class="form-control" name="amount" type="number">
                    <span id="error_msg"></span>
                </div>
                <span id="error_msgs_paypal" ></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-paypal">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

@section('document_ready')
@parent
$('.btn-paypal').click(function(e){
  e.preventDefault();

  var amount = $("#amount_paypal").val();
  var html_error = '';
  if(amount > 100) {
    
    html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Amount is less then $100.</div></div>';
    $('#error_msgs_paypal').html(html_error);
  }
  if(amount.length === 0) {
    html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Amount field is required.</div></div>';
    $('#error_msgs_paypal').html(html_error);
  }
  if(amount.length !== 0 && amount < 100) {
    $('#error_msgs_paypal').html('');
    $('#formid_paypal').submit();
  }

});

  

  @if(Session::get('status') == 0 && Session::get('paypal_res') == 1)
    responseMsg('error',"{{asset('images/error.png')}}");
  @endif
  @if(Session::get('status') == 1 && Session::get('paypal_res') == 1)
    responseMsg('insert',"{{asset('images/icons8-ok-filled-480.png')}}");
  @endif

@endsection

