<div class="modal fade  stick-up" id="edit_payment_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Edit Payment Method</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_edit_payment" action="javascript:;" accept-charset="UTF-8" enctype="multipart/form-data">
	      <div class="modal-body">
	        <div class="form-group">
	        	<input type="hidden" name="id" class="edit_id">
	            <label>Title</label>
	            <input placeholder="Title" class="form-control edit_title" name="name" type="text"> 
	        </div>
	        <div class="form-group">
	            <label>Charges</label>
	            <input placeholder="Charges" class="form-control edit_charges" name="charges" type="number"> 
	        </div>
	        <div class="form-group">
	            <label>Applicable Module</label>
	            <input placeholder="applicable Module" class="form-control edit_applicable_module" name="applicable_module" type="text"> 
	        </div>
	        <div class="form-group">
	            <label>Charges Type</label>
	            <select class="form-control full-width edit_charges_type select2" name="charges_type">
	            	<option value="">Please Choose Charges Type</option>
	            	<option value="fixed">Fixed</option>
	            	<option value="percentile">Percent</option>
	            </select> 
	        </div>
	        <div class="form-group">
	            <label>Status</label>
	            <select class="form-control full-width edit_status select2" name="status">
	            	<option value="">Please Choose Status</option>
	            	<option value="active">Active</option>
	            	<option value="in_active">Inactive</option>
	            </select> 
	        </div>
	        <div class="col-4 padding-border border-black remove-div">
    			<div class="border-black">
    				<div class="">
    					<img src="" draggable="false" class="img-fluid img_show">
    				</div>
    			</div>
    			<div class="">
    				<ul class="list-inline pull-right">
    					<li>
    						<a href="javascript:void(0)" class=" fa fa-trash del-img"></a>
    					</li>
    				</ul>
				</div>
	        </div>
	        <div class="form-group m-t-20">
	            <label>Upload Image</label>
	            <input type="file" name="image_name" >
	            <input type="hidden" name="img_del" value="0" class="img_del_hidden">
	        </div>
	        <div class="form-group error_msg_edit_payment">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary add-payment">Edit Payment</button>
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
	   $('#edit_payment_model').on('shown.bs.modal', function (e) {
	   		var id = $(e.relatedTarget).data('id');
	        $.get('{{URL::route("payment.edit")}}',{'id':id},function(response) {
	            if(response.status == 1){
	              $(".edit_id").val(id);
	              $(".edit_title").val(response.data.name);
	              $('.img_show').attr('src',response.img_url);
	              $(".edit_charges").val(response.data.charges);
	              $(".edit_applicable_module").val(response.data.applicable_module);
	              $(".edit_charges_type").val(response.data.charges_type).change();
	              $(".edit_status").val(response.data.status).change();
	              $('.remove-div').show();
	            }
	        },"json");
		});
	   $('.del-img').click(function(){
	   		$('.remove-div').hide();
	   		$('.img_del_hidden').val(1);
	   });

	   $("#formid_edit_payment").on('submit',function(e){
			e.preventDefault();
			var formData = new FormData(this);
		    $.ajax({
		          type: "POST",
		          url: "{{route('payment.update')}}",
		          data: formData,
		          cache:false,
			      contentType: false,
			      processData: false,
		          dataType: "JSON",
		          success: function (response) {
		          if(response.status == 1)
		          {
		              responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
			          $('#edit_payment_model').modal('hide');
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
		              $('.error_msg_edit_payment').html(html_error);
		              
		            }
		        }
		    });
		})
	
  });
</script>
@endsection