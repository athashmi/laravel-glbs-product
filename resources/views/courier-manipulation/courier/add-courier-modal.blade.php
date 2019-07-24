    <div class="modal fade stick-up" id="AddCourierModel" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Add Courier Zone</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" action="javascript:;" id="insert_courier" accept-charset="UTF-8">
        @csrf
      <div class="modal-body">
                <div class="form-group">
                    <label>Courier Name</label>
                    <input placeholder="Courier Name"  id="i_type" class="form-control" name="c_name" type="text">
                    <span id="error_msg"></span>
                </div>
                <div class="form-group">
                    <label>Courier Title</label>
                    <input placeholder="Courier Title"  id="i_type" class="form-control" name="c_title" type="text">
                    <span id="error_msg"></span>
                </div>
                <div class="error_msg_c_i" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="addCourierZone()" >Add Courier</button>
      </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">
  function addCourierZone() {
      $.ajax({
        type: "POST",
        url: "{{URL::route('courier.insert')}}",
        data: $('#insert_courier').serialize(),
        dataType: "JSON",
        success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
            $('#AddCourierModel').modal('hide');
            $('.datatable').DataTable().draw();
          }
          if(response.status == 0)
          {
            responseMsg("error",'{{asset('images/error.png')}}');
            $('#AddCourierModel').modal('hide');
            $('.datatable').DataTable().draw();
          }
      },
      error: function (jqXHR,status, exception) {
      	if (jqXHR.status == 422) {
              var html_error = '';
              $.each(jqXHR.responseJSON.errors, function (key, value)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
              })
              html_error += "</ul></div>";
              $('.error_msg_c_i').html(html_error);
              
            }
    }
      });
  }

  $(document).ready(function(){
    $('#AddCourierModel').on('shown.bs.modal', function (e) {
       $('.error_msg_c_i').html('');
    });
  });
  </script>
@endsection
