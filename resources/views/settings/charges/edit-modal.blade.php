    <div class="modal fade  stick-up" id="edit_charge_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Update Charge</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="form_update_charge" action="javascript:;" accept-charset="UTF-8" novalidate="">
      <div class="modal-body">
        <div class="form-group">
            <label>Title</label>
            <input placeholder="Title" value="{{old('title')}}" id="title"  class="form-control" name="title" type="text"> 
        </div>
       
        <div class="form-group">
            <label>Amount</label>
            <input placeholder="Amount" value="{{old('amount')}}" id="amount" class="form-control" name="amount" type="number"> 
        </div>
        <div class="form-group">
        	<input type="hidden" name="id" id="id_u_c">
            <label>Applicable Module</label>
           <div class="  ">
				<input type="checkbox" name="applicable_module[]" value="package" id="package">
				<label for="checkbox1">Package fee</label>
			</div>
			<div class="">
				<input type="checkbox" name="applicable_module[]" value="consolidation" id="consolidate">
				<label for="checkbox2">consolidation fee</label>
			</div> 
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
	  $('#edit_charge_model').on('shown.bs.modal', function (e) {
	  		$("#package").prop('checked',false);
	  		$("#consolidate").prop('checked',false);
	       $('.error_msg_e_c_u_y').html('');
	        var id = $(e.relatedTarget).data('id');
	        $.get('{{route('setting.charges.edit')}}',{'id':id},function(response) {
	           if(response.status == 1){
	              $("#id_u_c").val(id);
	              $("#title").val(response.data.title);
	              $("#amount").val(response.data.amount);
	              if(response.total > 1){
	              	$.each(response.data.applicable_module.name,function(index,value){
	              		if(value == 'package')
	              			$("#package").prop('checked',true);
	              		if(value == 'consolidation')
	              			$("#consolidate").prop('checked',true);
	              	});
	              }else{
	              	if(response.data.applicable_module.name == 'package')
	              		$("#package").prop('checked',true);
	              	if(response.data.applicable_module.name == 'consolidation')
	              		$("#consolidate").prop('checked',true);
	              }
	             }
	        },"json");
	      });
    });
  function update() {
      $.ajax({
          type: "POST",
          url: "{{route('setting.charges.update')}}",
          data: $('#form_update_charge').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
              $('#edit_charge_model').modal('hide');
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
              $('.error_msg_e_c_u_y').html(html_error);
              
            }
        }
      });
    }
    
</script>
@endsection