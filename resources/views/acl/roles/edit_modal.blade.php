<!-- Model for Edit permission -->
    <div class="modal fade stick-up" id="EditRoleModel" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Edit Role</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" action="javascript:;" id="formid" accept-charset="UTF-8">
      <div class="modal-body">
      
              @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input placeholder="Name" value="" class="form-control" id="e_name" name="name" type="text">
                    <span id="error_msg" ></span>
                </div>
                 
                <div class="form-group">
                    <label>Display Name</label>
                    <input placeholder="Display Name" value="" class="form-control" id="e_display_name" name="display_name" type="text">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="hidden" name="update_role_id" id="update_role_id">
                     <input placeholder="Discription" value="" id="e_description" class="form-control" name="description" type="text">
                </div>
                <div class="form-group">
                    <label>Permissions</label>
                  <select class="form-control full-width permission_assign_edit" name="permissions[]" multiple="multiple">
                    @foreach($all_perms as $perm)
                      <option value="{{$perm->id}}">{{$perm->display_name}}</option>
                    @endforeach
                  </select>
            </div>  
                <div class="error_msg_r_u" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="update()">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
<input type="hidden" id="delete_role" name = "delete_permission" value="<?php echo route('role.delete'); ?>">
<!-- End Edit permission model -->

@section('script')
@parent
  <script type="text/javascript">
  $(document).ready(function(){
    $('#EditRoleModel').on('shown.bs.modal', function (e) {
      $('.error_msg_r_u').html('');
      var id = $(e.relatedTarget).data('id');
      $("#update_role_id").val(id);
      $.ajax({
        type: "get",
        url: '{{URL::route("role.edit")}}' ,
        dataType: "JSON",
        data:'id='+id,
        success: function (response) {
        if(response.status == 1)
        {
          $("#e_name").val(response.role.name);
          $("#e_display_name").val(response.role.display_name);
          $("#e_description").val(response.role.description);
          var htmls = "";
          var selected_perms = [];
          $('.permission_assign_edit').val(response.assigned_perms).select2();
        }
        },
        error: function (jqXHR, exception) {
        }
      });
    });
  });

  function update() {
    var url = $("#update_role").val();
    var id = $("#update_role_id").val();
    $.ajax({
      type: "POST",
      url: "{{route('role.update')}}",
      data: $('#formid').serialize(),
      dataType: "JSON",
      success: function (response) {
        if(response.status == 1)
        {
          responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");
          $('#EditRoleModel').modal('hide');
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
              $('.error_msg_r_u').html(html_error);
            }
          }
      });
  }
</script>

@endsection