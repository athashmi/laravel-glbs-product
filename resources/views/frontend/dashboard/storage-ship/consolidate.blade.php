<div class="modal fade slide-right" id="consolidate_package_modal"   role="dialog" aria-hidden="true">
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
								<h4 class = "modal-title pull-left" id= "myModalLabel"><b>Consolidate And Ship Request Form</b></h4>
							</div>
							<form class="consolidate_form_request" action="javascript:;"> 
								<div class="modal-body">
									<div class="form-group">
										<label>Total Packages Consolidated</label>
										<input type="text" class="form-control total_pkg_cons color-black" disabled="">
										<input type="hidden" class="total_pkg_cons" name="total_pkg">
									</div>
									<div class="form-group">
										<label>Total Customs & Insurance Value</label>
										<input type="text" class="form-control total_custom_value_cons color-black" disabled="" >
										<input type="hidden" class="total_custom_value_cons" name="total_cus">
									</div>
									<div class="form-group">
										<label>Destination Address</label>
										<select class="form-control select2 consolidate_address full-width" name="dest_add"> 
										</select>
									</div>
									<div class="form-group">
										<label>Special Request (If any)</label>
										<textarea type="text" class="form-control"   name="spec_req"></textarea>
									</div>
									<div class="form-group consolidate_request_info">
										

									</div>

								</div>
								<div class="clearfix"></div>
								<div class="consolidate_error_msg_model"></div>
								<div class="col-lg-12">
									<div class=""></div>
									<hr style="width:100%">
									<button type="submit" class="btn btn-primary float-sm-right">Send</button>
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
<script type="text/javascript">
	$(document).ready(function(){
		 $('#consolidate_package_modal').on('shown.bs.modal', function (e) { 
		 	$('.consolidate_form_request').find("input[type=text], textarea").val("");
		 	sThisVal = [];
		 	$('.consolidate_error_msg_model').html('');
		 	$('.checkbox_package').each(function (key,value) {
			  if(this.checked){
			  	sThisVal.push($(this).data('id'));
			  }
			});
			$('.total_pkg_cons').val(sThisVal.length);


			 $.get('{{URL::route("frontend.consolidate.get_consolidate_info")}}',{'custom_value_package_id' : JSON.stringify(sThisVal)},function(response) {
		           if(response.status == 1)
		            {
		            	var consolidate_info_html = '<label>Additional Info</label>';
		            	var consolidate_address   = '';
		            	$.each(response.consolidate_request_infos ,function(key,value){
		            	consolidate_info_html += `<div class="input-group-prepend ">
												<input type="checkbox"  name="spec[]" value="`+value.id+`" class=" m-t-10 m-r-10">
												<p class="m-b-0 m-t-5">`+value.title+`
												</p>
											</div>`;
						});
						$.each(response.shopaholics[0].addresses ,function(key,value){
		            	consolidate_address += `<option value="`+value.id+`">`+value.name+` ,`+value.street+` `+value.city+` ,`+value.zip_code+`</option>`;
						});
						$('.total_custom_value_cons').val(response.custom_value);
						$('.consolidate_address').html(consolidate_address);
		            	$('.consolidate_request_info').html(consolidate_info_html);
		            	
		            }
		        },"json");

		});
		$('.consolidate_form_request').on('submit',function(e){
			e.preventDefault();
			var data = $('.consolidate_form_request').serializeArray();
			data.push({name: 'pacakge_ids', value: sThisVal});
			$.ajax({
            type: "post",
            url: '{{URL::route("frontend.consolidate.save")}}',
            data: data,
            dataType: "JSON",
              success: function (response) {
              	if(response.status == 1){
          		  responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
	              $('#consolidate_package_modal').modal('hide');
	              $('.datatable').DataTable().draw();
              	}
              },
              error: function (jqXHR, exception) {
              	if (jqXHR.status == 422) {
		              var html_error = '';
		              $.each(jqXHR.responseJSON.errors, function (key, value)
		              {
		                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" style="top: 15px;" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
		              })
		              html_error += "</ul></div>";
		              $('.consolidate_error_msg_model').html(html_error);
	            }
              }
            });
		})

	});
</script>
@endsection