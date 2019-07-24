<div class="modal fade  stick-up" id="add_payment_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Add Payment Method</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_add_payment" action="javascript:;" accept-charset="UTF-8" enctype="multipart/form-data">
	      <div class="modal-body">
	        <div class="form-group">
	            <label>Title</label>
	            <input placeholder="Title" value="{{old('title')}}" class="form-control a_title" name="name" type="text"> 
	        </div>
	        <div class="form-group">
	            <label>Charges</label>
	            <input placeholder="Charges" value="{{old('charges')}}" class="form-control a_charges" name="charges" type="number"> 
	        </div>
	        <div class="form-group">
	            <label>Applicable Module</label>
	            <input placeholder="applicable Module" value="{{old('applicable_module')}}" class="form-control a_applicable_module" name="applicable_module" type="text"> 
	        </div>
	        <div class="form-group">
	            <label>Charges Type</label>
	            <select class="form-control full-width a_charges_type select2" name="charges_type">
	            	<option value="">Please Choose Charges Type</option>
	            	<option value="fixed">Fixed</option>
	            	<option value="percentile">Percent</option>
	            </select> 
	        </div>
	        <div class="form-group">
	            <label>Status</label>
	            <select class="form-control full-width a_status select2" name="status">
	            	<option value="">Please Choose Status</option>
	            	<option value="active">Active</option>
	            	<option value="in_active">Inactive</option>
	            </select> 
	        </div>
	        <div class="form-group m-t-20">
	            <label>Upload Image</label>
	            <input type="file" name="image_name"> 
	        </div>
	        <div class="form-group error_msg_c_c">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary add-payment">Add Payment</button>
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
	   $('#add_payment_model').on('shown.bs.modal', function (e) {
	       $("input:text").val('');
	       $(':input[type="number"]').val('');
	       $('.a_status').change().val('');
	       $('.a_charges_type').change().val('');
	       $('.error_msg_c_c').html('');
		});
	$("#formid_add_payment").on('submit',function(e){
		e.preventDefault();
		var formData = new FormData(this);
	    $.ajax({
	          type: "POST",
	          url: "{{route('payment.store')}}",
	          data: formData,
	          cache:false,
		      contentType: false,
		      processData: false,
	          dataType: "JSON",
	          success: function (response) {
	          if(response.status == 1)
	          {
	              responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
		          $('#add_payment_model').modal('hide');
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
	              $('.error_msg_c_c').html(html_error);
	              
	            }
	        }
	    });
	})
  });
</script>
@endsection