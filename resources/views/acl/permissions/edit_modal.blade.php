<!-- Model for Edit permission -->
    <div class="modal fade stick-up" id="EditPermissionModel" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Edit Permission</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" action="javascript:;" id="update_permission" accept-charset="UTF-8">
      <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input placeholder="Name" value="" class="form-control" id="e_name_edit" name="name" type="text">
                    <span id="error_msgs" ></span>

                <div class="form-group">
                    <label>Display Name</label>
                    <input placeholder="Display Name" value="" class="form-control" id="e_display_name_edit" name="display_name" type="text" >
                </div>
                <div class="form-group">
                    <label>Description</label>

                    <input type="hidden" name="update_permission_id" id="update_permission_id">
                     <input placeholder="Discription" value="" id="e_description_edit" class="form-control" name="description" type="text">
                </div>
                <div class="error_msg_p_u" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="update()" >Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">

  $(document).ready(function(){
    /** validate username **/
    var regexname="^[a-zA-Z0-9_.]*$";
    $('#e_name_edit').on('keyup',function(){
    if ($(this).val().match(regexname)) {
    }
    else{
        var strng = $(this).val();
        $("#error_msgs").html('<p class="alert alert-danger error_message">Special character and space not allowed...</p>');
        setTimeout(function(){
          $("#error_msgs").html('');
        },2000);
        $(this).val(strng.substring(0,strng.length-1));
        }
    });
  /****************** end username validation  *********/
  //var

  $('#EditPermissionModel').on('shown.bs.modal', function (e) {
        $('.error_msg_p_u').html('');
        var id = $(e.relatedTarget).data('id');


        $.get('{{URL::route("permission.edit")}}',{'id':id},function(response) {

          console.log(response.data.name);

           if(response.status == 1)
            {
              $("#e_name_edit").val(response.data.name);
              $("#e_display_name_edit").val(response.data.display_name);
              $("#e_description_edit").val(response.data.description);
              $("#update_permission_id").val(response.data.id);
            }

        },"json");

      });
    });
  function update() {
      //var url = $("#update_permission").val();
      var id = $("#update_permission_id").val();
      $.ajax({
        type: "POST",
        url: "{{URL::route('permission.update')}}",
        data: $('#update_permission').serialize(),
        dataType: "JSON",
        success: function (response) {
          if(response.status == 1)
          {
            responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");
            $('#EditPermissionModel').modal('hide');
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
              $('.error_msg_p_u').html(html_error);
            }
        }
      });
  }
  </script>
@endsection