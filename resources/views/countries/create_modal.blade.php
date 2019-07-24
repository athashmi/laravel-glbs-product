<!-- Model for create Country -->
    <div class="modal fade  stick-up" id="create_country_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Create Country</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input placeholder="Name" value="{{old('name')}}" id="e_name" class="form-control" name="name" type="text"> 
                </div>
               
                <div class="form-group">
                    <label>ISO</label>
                    <input placeholder="ISO" value="{{old('iso')}}" id="iso" class="form-control" name="iso" type="text"> 
                </div>
                <div class="form-group">
                    <label>ISO3</label>
                    <input placeholder="ISO3" value="{{old('iso')}}" id="iso3" class="form-control" name="iso3" type="text"> 
                </div>
               
                <div class="form-group">
                    <label>Num Code</label>
                    <input placeholder="Num Code" value="{{old('num_code')}}" id="num_code" class="form-control" name="num_code" type="number"> 
                </div>
                 <div class="form-group">
                    <label>Phone Code</label>
                    <input placeholder="Phone Code" value="{{old('phone_code')}}" id="phone_code" class="form-control" name="phone_code" type="number"> 
                </div>
                <span class = "error_msg_c_c" ></span>
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
          url: "{{route('country.store')}}",
          data: $('#formid_create').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
              responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
              $('#create_country_model').modal('hide');
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
              $('.error_msg_c_c').html(html_error);
              
            }
        }
      });
    }
    $(document).ready(function(){
    $('#create_country_model').on('shown.bs.modal', function (e) {
       $('.error_msg_c_c').html('');
    });
  });
</script>
@endsection