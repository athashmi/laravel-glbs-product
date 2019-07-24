<!-- Model for create Country -->
    <div class="modal fade  stick-up" id="add_assign_employee_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Select Employee</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" id="add_assign_employee_form" action="javascript:;" accept-charset="UTF-8">
	      <div class="modal-body">
            <div class="form-group">
                <label>Select Employee</label>
                <select class="select2 form-control full-width" name="employee">
                	<option value="">Choose the employee</option>
                	@foreach($employees as $employee)
                		<option value="{{$employee->id}}">{{$employee->user->first_name.' '.$employee->user->last_name}}</option>
                	@endforeach
                </select>
            </div>
            <span class = "error_add_assign_employee" ></span>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" onclick="addAssignEmployee()">Assign</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('script')
@parent
<script>

  $(document).ready(function(){
    $('#add_assign_employee_model').on('shown.bs.modal', function (e) {
      sThisVal = [];
    	selectedRequest();
       $('.error_add_assign_employee').html('');
    });
  });
  function addAssignEmployee(){
  	var data = $('#add_assign_employee_form').serializeArray();
  	data.push({name: 'request_id', value: sThisVal})
  	$.ajax({
      type: "POST",
      url: "{{route('consolidation.shipment.assign_employee')}}",
      data: data,
      dataType: "JSON",
      success: function (response) {
      if(response.status == 1)
      {
        responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
          $('#add_assign_employee_model').modal('hide');
          $('.top_button_generic_class').children().hide();
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
          $('.error_add_assign_employee').html(html_error);
       }
      }
    });
  }
  function selectedRequest(){
    $('.checkbox_package').each(function (key,value) {
        if(this.checked){
          sThisVal.push($(this).data('id'));
        }
      });
  }
</script>
@endsection