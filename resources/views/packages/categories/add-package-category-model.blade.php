<!-- Model for create permission -->
    <div class="modal fade stick-up" id="add_category_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Create Package Category</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create_category_add" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input placeholder="Title" value="{{old('title')}}" class="form-control" name="title" type="text"> 
                </div>
                <div class="error_msg_p_c_a" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="createCategory()">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for permission  ---->

@section('script')
@parent
<script>
 
  function createCategory() {
      $.ajax({
          type: "POST",
          url: "{{route('package.categories.store')}}",
          data: $('#formid_create_category_add').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
              $('#add_category_model').modal('hide');
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
              $('.error_msg_p_c_a').html(html_error);
            }
        }
      });
    }
    $(document).ready(function(){
    $('#add_category_model').on('shown.bs.modal', function (e) {
       $('.error_msg_p_c_a').html('');
    });
  });
</script>
@endsection