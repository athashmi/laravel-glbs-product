    <div class="modal fade stick-up" id="edit_package_category" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Edit Package Category</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" action="javascript:;" id="formid_edit_p_category" accept-charset="UTF-8">
      <div class="modal-body">
      
              @csrf
                <div class="form-group">
                    <label>Title</label>
                    <input placeholder="Title" value="" class="form-control" id="title" name="title" type="text"> 
                </div> 
                <input type="hidden" name="id" id="update_category_id">
                <div class="error_msg_p_c_e" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="updateCategory()">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
  <script type="text/javascript">
  $(document).ready(function(){
    $('#edit_package_category').on('shown.bs.modal', function (e) {
      $('.error_msg_p_c_e').html('');
      var id = $(e.relatedTarget).data('id');
      $("#update_category_id").val(id);
      $.ajax({
        type: "get",
        url: '{{URL::route("package.categories.edit")}}' ,
        dataType: "JSON",
        data:'id='+id,
        success: function (response) {
        if(response.status == 1)
        {
          $("#title").val(response.data.title);
        }
        },
        error: function (jqXHR, exception) {
        }
      });
    });
  });

  function updateCategory() {

    $.ajax({
      type: "POST",
      url: "{{route('package.categories.update')}}",
      data: $('#formid_edit_p_category').serialize(),
      dataType: "JSON",
      success: function (response) {
        if(response.status == 1)
        {
          responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");
          $('#edit_package_category').modal('hide');
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
              $('.error_msg_p_c_e').html(html_error);
            }
          }
      });
  }
</script>

@endsection