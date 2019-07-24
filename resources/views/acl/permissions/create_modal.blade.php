<!-- Model for create permission -->
    <div class="modal fade stick-up" id="create_permission_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Create Permission</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input placeholder="Name" value="{{old('name')}}" id="e_name" class="form-control" name="name" type="text">
                    <span id="error_msg"></span>
                </div>

                <div class="form-group">
                    <label>Display Name</label>
                    <input placeholder="Display Name" value="{{old('display_name')}}" class="form-control" name="display_name" type="text">
                </div>
                <div class="form-group">
                    <label>Description</label>
                     <input placeholder="Discription" value="{{old('description')}}" class="form-control" name="description" type="text">
                </div>
                <div class="error_msg_p_c" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="createPermission()">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for permission  ---->

@section('script')
@parent
<script>
/** validate username **/
  var regexname="^[a-zA-Z0-9_.]*$";
  $('#e_name').on('keyup',function(){
    if ($(this).val().match(regexname)) {
    }
    else{
      var strng = $(this).val();
      $("#error_msg").html('<p class="alert alert-danger error_message">Special character and space not allowed...</p>');
      setTimeout(function(){
              $("#error_msg").html('');
      },2000);
      $(this).val(strng.substring(0,strng.length-1));
    }
  });
  function createPermission() {
      $.ajax({
          type: "POST",
          url: "{{route('permission.store')}}",
          data: $('#formid_create').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
              $('#create_permission_model').modal('hide');
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
              $('.error_msg_p_c').html(html_error);
            }
        }
      });
    }
    $(document).ready(function(){
    $('#create_permission_model').on('shown.bs.modal', function (e) {
       $('.error_msg_p_c').html('');
    });
  });
</script>
@endsection