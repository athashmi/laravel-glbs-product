<!-- Model for create Country -->
    <div class="modal fade" id="add_address_model" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Add Address</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
      	<div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Name</label>
                    <input placeholder="Name" id="name" class="form-control" name="name" type="text">
                    <span id="error_msg"></span>
                </div>
               <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Phone</label>
                    <input placeholder="+923066189896" id="phone" class="form-control" name="phone" type="text">
                    <span id="error_msg"></span>
                </div>
                
        </div>

        <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Zip code</label>
                    <input placeholder="50700" id="zip_code" class="form-control" name="zip_code" type="text">
                    <span id="error_msg"></span>
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Address</label>
                    <input placeholder="Address" id="street" class="form-control" name="street" type="text">
                    <span id="error_msg"></span>
                </div>
        </div>

        <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>City</label>
                    <input placeholder="City" id="city" class="form-control" name="city" type="text">
                    <span id="error_msg"></span>
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>State</label>
                    <input placeholder="State" id="state" class="form-control" name="state" type="text">
                    <span id="error_msg"></span>
                </div>
        </div>

        <div class="row">               
                <div class="form-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                    <label>Country</label>
                    <select name="country_name" class="form-control full-width select">
                    	<option value="" >Please choose country</option>
                    	@foreach($countries as $country)
                    		<option value="{{$country->id}}">{{$country->name}}</option>
                    	@endforeach
                    </select>
                    <span id="error_msg"></span>
                </div>
        </div>
                
                <span id="error_msgs1" ></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="createAdress()">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->
@section('document_ready')
@parent
$('#add_address_model').on('shown.bs.modal', function (e) {

});

@endsection

@section('script')
@parent
<script>
  function createAdress() {
      $.ajax({
          type: "POST",
          url: "{{route('profile.store')}}",
          data: $('#formid_create').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
              responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}","Information has been inserted successfully...");
              
              //$(".address").html(response.html);

               setTimeout(function(){
                $('#add_address_model').modal('hide');
                        location.reload();
                      },2000);
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
          // setTimeout(function(){
          //       $("#error_msgs1").html('');
          // },2000);
        }
      });
    }
</script>
@endsection