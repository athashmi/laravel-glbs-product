<!-- Model for create Country -->
    <div class="modal fade stick-up" id="edit_warehouse_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Edit Warehouse</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formEditWarehouse" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
      	<div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Name</label>
                    <input placeholder="Name" id="e_name" class="form-control" name="name" type="text">
                    <span id="error_msg"></span>
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Email</label>
                    <input placeholder="example@test.com" id="e_email" class="form-control" name="email" type="email">
                    <span id="error_msg"></span>
                </div>
        </div>

        <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Phone</label>
                    <input placeholder="+923066189896" id="e_phone" class="form-control" name="phone" type="text">
                    <span id="error_msg"></span>
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Street</label>
                    <input placeholder="Street" id="e_street" class="form-control" name="street" type="text">
                    <span id="error_msg"></span>
                </div>
        </div>

        <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>City</label>
                    <input type="hidden" name="id" id="id">
                    <input placeholder="City" id="e_city" class="form-control" name="city" type="text">
                    <span id="error_msg"></span>
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>State</label>
                    <input placeholder="Street" id="e_state" class="form-control" name="state" type="text">
                    <span id="error_msg"></span>
                </div>
        </div>

        <div class="row">               
                <div class="form-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                    <label>Country</label>
                    <select name="country_id" id="e_country_id" class="form-control">
                    	<option value="" >Please choose country</option>
                    	@foreach($countries as $country)
                    		<option value="{{$country->id}}">{{$country->name}}</option>
                    	@endforeach
                    </select>
                    <span id="error_msg"></span>
                </div>
        </div>
                
                <div class ="error_msg_w_u" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="update()">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('script')
@parent
<script>
   $('#edit_warehouse_model').on('shown.bs.modal', function (e) {
        $('.error_msg_w_u').html('');
        var id = $(e.relatedTarget).data('id');


        $.get('{{URL::route("warehouse.edit")}}',{'id':id},function(response) {

          console.log(response.data.name);

           if(response.status == 1)
            {
              $("#e_name").val(response.data.name);
              $("#e_email").val(response.data.email);
              $("#e_phone").val(response.data.phone);
              $("#e_street").val(response.data.street);
              $("#e_city").val(response.data.city);
              $("#e_state").val(response.data.state);
              $("#e_country_id").val(response.data.country_id);
              $("#id").val(id);
            }

        },"json");

      });

   function update() {
      $.ajax({
        type: "POST",
        url: "{{URL::route('warehouse.update')}}",
        data: $('#formEditWarehouse').serialize(),
        dataType: "JSON",
        success: function (response) {
          if(response.status == 1)
          {
            responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");
            $('#edit_warehouse_model').modal('hide');
            $('.datatable').DataTable().draw();
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
              $('.error_msg_w_u').html(html_error);
              
            }
        }
      });
  }
</script>
@endsection