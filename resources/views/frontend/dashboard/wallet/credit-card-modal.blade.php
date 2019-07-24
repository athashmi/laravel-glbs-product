<div class="modal  fade stick-up" id="add_credit_card_model" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Add Credit Card</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
       
      <div class="modal-body">
        <div class="card-wrapper"></div>
          <div class="credit-card">
            <form class="payment-form active form" id="credit_card_form">

                                 <div class="form-group">
                                      <label>Card Type</label>
                                      <select class="form-control" name="type">
                                        <option value="">Please Choose the card type</option>
                                        <option value="visa">Visa</option>
                                        <option value="master">Master</option>
                                        <option value="american">American Express</option>
                                        <option value="discover">Discover</option>
                                    </select>
                                  </div>

                                  <div class="form-group">
                                      <label>Card Number</label>

                                      <input name="number"  type="tel" class="form-control" placeholder="Card Number" id="cardNumber">

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
                                    <div id="captcha"></div>
                                  </div>
                                  <div class="form-group error_msg_w_a">
                                  </div>
            </form>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary credit-card-btn" >Create</button>
      </div>
      
    </div>
  </div>
</div>
</div>

<!--- Model create for Country  ---->

@section('document_ready')
@parent

$('#add_credit_card_model').on('shown.bs.modal',function() {

    $('#add_credit_card_model').css("z-index", 1059);

      grecaptcha.render("captcha", {sitekey: "{{Helper::dbConfigValue('recaptcha','site_key')}}", theme: "light"});
    });
     var correctCaptcha = function(response) {
      alert(response);
      };
     $('.credit-card-btn').on('click',function() {
      addCreditCard();

    }); 


@endsection

@section('script')
@parent
{!! NoCaptcha::renderJs() !!}
<script>
 
  function addCreditCard() {
    var html_error = '';
      if (grecaptcha.getResponse() == "") { 
          html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Please Verify reCaptcha.</div></div>';
             
            $(".error_msg_w_a").html(html_error); 
              return false;
      }else{
      $.ajax({
          type: "POST",
          url: "{{route('credit_card.verify')}}",
          data: $('#credit_card_form').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.success == true)
          {
              creditcardRender(response.data);
              responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
              $('#add_credit_card_model').modal('hide'); 
          }
           
          if(response.card_used == 1)
          {
            html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>This Card have already been used.</div></div>';
              $(".error_msg_w_a").html(html_error); 
          }
          if(response.success == false)
          {
             html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+response.errorMsg+'</div></div>';
                $(".error_msg_w_a").html(html_error);
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
              $('.error_msg_w_a').html(html_error);
              
            }
        }
      });
    }
  }

  function creditcardRender(creditCardArray)
  {
      var data = creditCardArray;
              var html_credit_card = "";
              $.each(data[0].shopaholic.credit_card_info,function(key,value){

                 html_credit_card += '<div class=" card payment-card">';
                 if(value.status == 'unverified'){
                   html_credit_card += '<div class="content-credit">';
                 }
                 if(value.status == 'blocked'){
                   html_credit_card += '<div class="content-credit">';
                 }
                 if(value.status == 'verified') {
                   html_credit_card += '<div>';
                 }
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
                  html_credit_card += '</div><div><h5 class="text-center">**** **** **** '+value.digit+'</h5><div class="row m-t-10"><div class="col-sm-12 text-center" style="margin-bottom:10px;"><strong class="text-center" >Name :</strong>'+data[0].first_name+' '+ data[0].last_name +'</div>';
                  html_credit_card += "</div></div>";
                  if(value.status == 'unverified'){
                  html_credit_card += '<button style="position:absolute;     margin-top: 71px;" class="btn-verify mar-right btn btn-danger" onclick="cardDigit('+value.digit+')" data-toggle = "modal" data-target = "#credit-card-modal"> <i class="icofont icofont-warning-alt"></i> Verify Card</button></div>';
                  }
                  if(value.status == 'blocked'){
                  html_credit_card += '<button style="position:absolute;     margin-top: 71px;" class="btn-verify mar-right btn btn-danger" > <i class="icofont icofont-warning-alt"></i> Blocked </button></div>';
                  }
                  if(value.status == 'verified') {
                    html_credit_card += '</div>';
                  }
                
              })

            $('.card-html').html(html_credit_card);
  }

function cardDigit(digit){

 $("#digit_attempt").val(digit);

}
 
</script>
@endsection