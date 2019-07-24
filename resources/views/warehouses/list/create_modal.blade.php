<!-- Model for create Country -->
    <div class="modal fade stick-up" id="create_warehouse_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Add Warehouse</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create" action="javascript:;" accept-charset="UTF-8" novalidate="">
      <div class="modal-body">
      	<div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Name</label>
                    <input placeholder="Name" id="name" class="form-control" name="name" type="text">
                    <span id="error_msg"></span>
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Email</label>
                    <input placeholder="example@test.com" id="email" class="form-control" name="email" type="email">
                    <span id="error_msg"></span>
                </div>
        </div>

        <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Phone</label>
                    <input placeholder="+923066189896" id="phone" class="form-control" name="phone" type="text">
                    <span id="error_msg"></span>
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Street</label>
                    <input placeholder="Street" id="street" class="form-control" name="street" type="text">
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
                    <input placeholder="Street" id="state" class="form-control" name="state" type="text">
                    <span id="error_msg"></span>
                </div>
        </div>

        <div class="row">               
                <div class="form-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                    <label>Country</label>
                    <select name="country_id" class="form-control">
                    	<option value="" >Please choose country</option>
                    	@foreach($countries as $country)
                    		<option value="{{$country->id}}">{{$country->name}}</option>
                    	@endforeach
                    </select>
                    <span id="error_msg"></span>
                </div>
        </div>
                
                <div class="error_msg_w_c" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="createCountry()">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('script')
@parent
<script>
  function createCountry() {
      $.ajax({
          type: "POST",
          url: "{{route('warehouse.store')}}",
          data: $('#formid_create').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
              $('#create_warehouse_model').modal('hide');
              $('.datatable').DataTable().draw();
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
              $('.error_msg_w_c').html(html_error);
              
            }
        }
      });
    }

    $(document).ready(function(){
    $('#create_warehouse_model').on('shown.bs.modal', function (e) {
       $('.error_msg_w_c').html('');
    });
  });
</script>
@endsection