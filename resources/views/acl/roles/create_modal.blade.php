 
    <div class="modal fade stick-up" id="CreateRoleModel"  role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Add Role</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" action="javascript:;" id="formid_create" accept-charset="UTF-8">
      <div class="modal-body">
              @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input placeholder="Name" value="" class="form-control" id="e_name_create" name="name" type="text">
                    <span id="error_msg_create" ></span>
                </div>
                 
                <div class="form-group">
                    <label>Display Name</label>
                    <input placeholder="Display Name" value="" class="form-control" id="e_display_name_create" name="display_name" type="text" >
                </div>
                <div class="form-group">
                    <label>Description</label>
                     <input placeholder="Discription" value="" id="e_description_create" class="form-control" name="description" type="text">
                </div>
                <div class="form-group">
                    <label>Permissions assigned</label>
                  <select class="full-width permission_assign" name="permission[]" multiple="multiple" >
                    @foreach($all_perms as $perm)
                      <option value="{{$perm->id}}">{{$perm->display_name}}</option>
                    @endforeach
                  </select>
            </div>

            
                <div class="error_msg_r_c" ></div>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="showSuccessCreate()">Add</button>
      </div>
      </form>
    </div>
  </div>
</div> 
<!-- End Create permission model -->
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

  var regexname="^[a-zA-Z0-9_.]*$";
  $('#e_name_create').on('keyup',function(){
    if ($(this).val().match(regexname)) {                 
    }
    else{
      var strng = $(this).val(); 
      $("#error_msg_create").html('<p class="alert alert-danger error_message">Special character and space not allowed...</p>');
      setTimeout(function(){
        $("#error_msg_create").html('');
      },2000);
      $(this).val(strng.substring(0,strng.length-1));
    }
  });

  function showSuccessCreate() {
    $.ajax({
      type: "POST",
      url: "{{route('role.store')}}",
      data: $('#formid_create').serialize(),
      dataType: "JSON",
      success: function (response) {
      if(response.status == 1)
      {
        responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
        $('#CreateRoleModel').modal('hide');
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
              $('.error_msg_r_c').html(html_error);
            }
      }
    });
  }

  $(document).ready(function(){
    $('#CreateRoleModel').on('shown.bs.modal', function (e) {
       $('.error_msg_r_c').html('');
    });
  });
</script>
@endsection