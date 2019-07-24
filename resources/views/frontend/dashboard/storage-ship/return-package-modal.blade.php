<div class="modal fade slide-right" id="return_package_detail_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height">
							<div class="modal-header">
								<button type="button" class="backgroud-clr btn btn-default pull-left" data-dismiss="modal" aria-hidden="true">
								<i class="fa fa-long-arrow-left  fs-14"></i>
								</button>
								<h4 class="modal-title pull-left" id="myModalLabel"><b>Return Package</b></h4>
							 
							</div>
							<div class="modal-body">
								<form class="return_package_form">
									<div class="form-group">
										<input type="hidden" name="package_id" id="package_id_return_page">
										<input type="hidden" name="service_id" id="service_id_return_page">
										<label>Pick the file</label>
										<input type="file" name="file" class="form-control">
									</div>
								
							</div>
							<div class="clearfix"></div> 
							<div class="col-lg-12">
								 
								<button type="submity" class="btn btn-primary btn-return-send float-sm-right">Send</button>
							</div>	
							</form>	 
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@section('script')
@parent
 <script>
 	$(document).ready(function(){
 		$('.return_package_form').on('submit',function(e){
		    e.preventDefault();    
		    var formData = new FormData(this);
		    $.ajax({
		        url: '{{route("storage.returnpackagefile")}}',
		        type: 'POST',
		        data: formData,
		        success: function (response) {
		            if(response.status == 1){
		            	responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
		            	$('.pgn-wrapper').css('z-index','999999 !important');
			            $('.return_label_btn').prop('disabled',true);
			            $('.return_label_btn').next().show();
		            	$("#return_package_detail_modal").modal('hide');
		            }
		        },
		        cache: false,
		        contentType: false,
		        processData: false
		    });
 		});

 		$('#return_package_detail_modal').on('shown.bs.modal', function (e) {

		var package_id = $("#package_detail_id").val();
		var service_id = $("#service_detail_id").val();
		$('#package_id_return_page').val(package_id);
		$('#service_id_return_page').val(service_id);
		});
 	});
 </script>
@endsection