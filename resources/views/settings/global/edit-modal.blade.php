    <div class="modal fade  stick-up" id="edit_global_setting_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Update Charge</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="form_update_charge" action="javascript:;" accept-charset="UTF-8" novalidate="">
            <input type="hidden" name="id" id="id_update_glbl">
      <div class="modal-body">
        <div class="form-group">
            <label>Title</label>
            <input placeholder="Title" value="{{old('title')}}" id="title"  class="form-control" name="title" type="text"> 
        </div>
       
        <div class="form-group">
            <label>Value</label>
            <input placeholder="Value" value="{{old('value')}}" id="value" class="form-control" name="value" type="number"> 
        </div>
        
      	<span class = "error_msg_e_c_u_y" ></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="update()">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
<script>
	$(document).ready(function(){
	  $('#edit_global_setting_model').on('shown.bs.modal', function (e) {
	  		
	       $('.error_msg_e_c_u_y').html('');
	        var id = $(e.relatedTarget).data('id');
	        $.get('{{route('setting.global.edit')}}',{'id':id},function(response) {
	           if(response.status == 1){
	             $("#id_update_glbl").val(id);
	              $("#title").val(response.data.title);
	              $("#value").val(response.data.value);
	             
	             }
	        },"json");
	      });
    });
  function update() {
      $.ajax({
          type: "POST",
          url: "{{route('setting.global.update')}}",
          data: $('#form_update_charge').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
              $('#edit_charge_model').modal('hide');
              $('.datatable').DataTable().draw();
          }
          else
          {
            var html_error = '<ul>';
              
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>An error occured, Please retry later.</div></div>';
              
              html_error += "</ul></div>";
              $('.error_msg_c_c_a').html(html_error);
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
              $('.error_msg_e_c_u_y').html(html_error);
              
            }
        }
      });
    }
    
</script>
@endsection