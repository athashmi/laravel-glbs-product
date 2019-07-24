<div class="modal fade slide-right" id="return_custom_value_modal"   role="dialog" aria-hidden="true">
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
								<h4 class = "modal-title pull-left" id = "myModalLabel"><b>Custom Value</b></h4>
							</div>
							<form class="form_custom_value" action="javascript:;"> 
								<div class="modal-body clone-body-custom">
										<input type="hidden" name="custom_value_package_id" id="custom_value_package_id">
										<div class="clone-body col-lg-12 m-t-10 pull-left">
											<div data-pages="card" class="card card-default" id="card-basic">
												<div class="card-header  ">
													<div class="card-title"><b>Item</b>
													</div>
													<div class="card-controls">
														<ul>
																<li>
																	<a href="#" class="custom-value-card-close">
																		<i class="card-icon card-icon-close"></i>
																	</a>
																</li>
														</ul>
													</div>
												</div>
												<div class="card-body">
			                                        <ul class="list-group item_inner list-group-flush">
					                                    <li class="list-group-item row">
					                                    	<div class="col-lg-12 pull-left">
						                                        <span class="bold">Categories :</span>
						                                        <select class="form-control clone-a full-width select2" name="category[]">
						                                        	@if($custom_categories)
							                                        	@foreach($custom_categories as $custom_category)
																			<option value="{{$custom_category->id}}">{{$custom_category->title}}</option>
							                                        	@endforeach
						                                        	@endif
						                                        </select>
					                                    	</div>
					                                    	<div class="col-lg-6 pull-left">
						                                        <span class="bold">Qty :</span>
						                                        <span> <input type="number" class="pull-right form-control quantity" name="quantities[]"></span>
					                                    	</div>
					                                    	<div class="col-lg-6 pull-left">
					                                    		<span class="bold">Value :</span>
					                                        	<span> <input type="number" class="pull-right form-control" name="value[]"></span>
					                                    	</div>
					                                    </li>
		                                			</ul> 
												</div>
											</div>
										</div>

										<div class="custom-category">
											

										</div>
									
								</div>
								<div class="col-lg-12">
									 <button class="pull-right btn-cutom-value btn btn-default"> <i class="fa fa-plus"></i></button>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-12">
									<div class="error_msg_custom_value_submition"></div>
									<hr style="width:100%">
									<button type="submity" onclick="customValueSubmit()" class="btn btn-primary btn-return-send float-sm-right">Send</button>
								</div>
							</form>
						</div>
						
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
	var outgoing_page_re = 0;
	$(document).ready(function(){

		html_custom_value = $('.clone-body-custom > .clone-body').clone(true);
		$('select.select2').select2();
		$('.btn-cutom-value').on('click',function(){
			renderCustomValue();
		});

		  
		 $(document).on("click", '.custom-value-card-close',function(){			 
			$(this).parent().parent().parent().parent().parent().parent().remove();
		 });
		 $('#return_custom_value_modal').on('shown.bs.modal', function (e) {
		 	   if($(e.relatedTarget).data('id')){
		 	   		var pa = $(e.relatedTarget).data('id');
		 	   		outgoing_page_re = 1;
		 	   	 	$('#custom_value_package_id').val(pa);
		 	   }else{
		 	   		var pa = $("#package_detail_id").val();
		 	    	$('#custom_value_package_id').val(pa);
		 	   }
		 	   
		       var custom = $('.custom-category').children();
				if(custom.length == 0){
					$('.custom-value-card-close').parent().parent().parent().hide();

				}

			$.get('{{URL::route("storage.exist_package_custom_value")}}',{'custom_value_package_id':pa},function(response) {
	           if(response.status == 1)
	            {
	              var le = response.data.length; 
	              var quantity_input;
	              var select_catgry;
	              var val = [];
	              var quan = [];
	              var catgry = [];
	              $('.custom-category').children().remove();
	              $.each(response.data,function(key,value){
	              	val.push(value.value);
	               	quan.push(value.quantity); 
	               	catgry.push(value.custom_category_id);
	              	if(key < le-1){
	              		renderCustomValue();
	              	}
	              });
	              input = $('input[name="value[]"]');
	              quantity_input = $('input[name="quantities[]"]');
	              select_catgry  = $('select[name="category[]"]');
	              $(input).each(function(key){
	              	$(this).val(val[key]);
	              });
	              $(quantity_input).each(function(key){ 
	              	 $(this).val(quan[key]);
	              });
	              $(select_catgry).each(function(key){
	              	$(this).val(catgry[key]).change();
	              });
	            }
	        },"json");
		    }); 
	});

function renderCustomValue(){
	$('.custom-category').append(html_custom_value.clone('true'));
	$('.custom-category').each(function(){				 
			var exist = $(this).find('select2-id');
			if(exist.length > 0){
			}else{
				$(this).find('select.select2').select2();
			}
		});
}
function customValueSubmit() {
  $.ajax({
      type: "POST",
      url: "{{route('storage.packagecustomvalue')}}",
      data: $('.form_custom_value').serialize(),
      dataType: "JSON",
      success: function (response) {
      if(response.status == 1)
      {
      	var a = 0;
      	var b = 0;
      	$('input[name="value[]"]').each(function(key){
	    	a = parseFloat($(this).val()) * parseFloat($(this).parent().parent().prev().find('.quantity').val());
	    	b = parseFloat(b) + parseFloat(a);
	    });
	    $('.value_custom_detail_page').html("$"+parseFloat(b));
        responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
          $('#return_custom_value_modal').modal('hide');
          if(outgoing_page_re == 1){
          	location.reload(true);
          }
      }
      },
      error: function(jqXHR, exception){
          if (jqXHR.status == 422) {
          var html_error = '';
      
	          html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button style="top: 14px;" type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>All filed is required.</div></div>';
	          html_error += "</ul></div>"; 
          $('.error_msg_custom_value_submition').html(html_error);
          
        }
    }
  });
}
	 
	 
	
</script>
@endsection