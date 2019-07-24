<!-- Model for create Country -->
    <div class="modal fade" id="edit_address_model"  role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Edit address form</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_edit_address" action="javascript:;" accept-charset="UTF-8">

          <input type="hidden" name="id" id="id">
      <div class="modal-body">
      
       

          <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Name</label>
                    <input placeholder="Name" id="e_name" class="form-control" name="name" type="text" value="">
                    <span id="error_msg"></span>
                </div>
               <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Phone</label>
                    <input placeholder="+923066189896" id="e_phone" class="form-control" name="phone" type="text">
                    <span id="error_msg"></span>
                </div>
                
        </div>

        <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Zip code</label>
                    <input placeholder="50700" id="e_zip_code" class="form-control" name="zip_code" type="text">
                    <span id="error_msg"></span>
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Address</label>
                    <input placeholder="Address" id="e_street" class="form-control" name="street" type="text">
                    <span id="error_msg"></span>
                </div>
        </div>

        <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>City</label>
                    <input placeholder="City" id="e_city" class="form-control" name="city" type="text">
                    <span id="error_msg"></span>
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>State</label>
                    <input placeholder="State" id="e_state" class="form-control" name="state" type="text">
                    <span id="error_msg"></span>
                </div>
        </div>

        <div class="row">               
                <div class="form-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                    <label>Country</label>
                    <select name="country_id" id="e_country_name" class="form-control full-width">
                      <option value="" >Please choose country</option>
                      @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                      @endforeach
                    </select>
                    <span id="error_msg"></span>
                </div>
        </div>


        
  
                <span id="error_msgs_address_u" ></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="editAdress()">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('document_ready')
@parent
$('#edit_address_model').on('shown.bs.modal', function (e) {

        var id = $(e.relatedTarget).data('id');
//$('#e_country_name').select2();

        $.get('{{URL::route("profile.address_edit")}}',{'id':id},function(response) {

           if(response.status == 1)
            {
              $("#e_zip_code").val(response.data.zip_code);
              $("#e_name").val(response.data.name);
              $("#e_street").val(response.data.street);
              $("#e_city").val(response.data.city);
              $("#e_state").val(response.data.state);
              $("#e_phone").val(response.data.phone);
              $("#id").val(response.data.id);

              $("#e_country_name").select2().val(response.data.country_id).trigger('change');


            }

        },"json");

});

@endsection

@section('script')
@parent
<script>
function editAdress() {
      $.ajax({
        type: "POST",
        url: "{{URL::route('profile.address_update')}}",
        data: $('#formid_edit_address').serialize(),
        dataType: "JSON",
        success: function (response) {
          if(response.status == 1)
          {
            responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}","Information has been updated successfully...");
            
            setTimeout(function(){
              $('#edit_address_model').modal('hide');
            location.reload();
          },2000);
            
          }
      },
      error: function (jqXHR, exception) {
          var html_error = '<div  class="alert " style="background-color:#e67070; color:white;"><ul>';
          $.each(jqXHR.responseJSON.errors, function (key, value)
          {
            html_error +='<li>'+value+'</li>';
          })
          html_error += "</ul></div>";
          $('#error_msgs_address_u').html(html_error);
          setTimeout(function(){
            $("#error_msgs_address_u").html('');
          },2000);
        }
      });
  }
</script>
@endsection