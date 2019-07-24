<div class="modal fade slide-right " id="package_outgoing_details_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height text-center "> 
							<div class="row m-t-30">
								<div class="col-md-6 pull-left">
									<h4 class="modal-title pull-left" id="myModalLabel">
										<b>Package Details</b>
									</h4>
								</div>
								<div class="col-md-6 pull-right m-t-10">
									<button type="button" class="btn  btn-primary btn-cons  pull-right from-top" data-toggle = "modal" data-target = "#return_custom_value_modal">
										<span>Custom Value</span>
									</button>
								</div>
								<input type="hidden" name="package_id" id="package_outgoing_detail_id">
							</div>
							<hr style="width: 100%" />
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
							</button>
							<div class="row outgoing_description-html">
							
							</div>
							<hr style="width: 100%" />
							<input type="hidden" name="service_outgoing_detail_id" id="service_outgoing_detail_id">
							<!-- Aditional Info -->
							<div class="row outgoing_additional_info">
							</div>
							<!-- Free Services --->
							
							<!-- Paid Services -->
							<div class="row row-sm-height outgoing_paid_services form-group-default input-group padding-custom m-t-20 ma">
								
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
	$(document).ready(function(){

		$('#package_outgoing_details_modal').on('shown.bs.modal', function (e) {
		var id = $(e.relatedTarget).data('id');
		$('#package_outgoing_detail_id').val(id);
		$('#package_id').val(id);
		$.get('{{URL::route("storage.getpackagedetails")}}',{'id':id},function(response) {
			//console.log(response);
		if(response.status == 1)
		{
			outgoing_additionalInfo(response);
			outgoing_paidServices(response);
			outgoing_freeServices(response);
			outgoing_descriptionPackage(response);
		}
		},"json");
		});

		$(document).on("change", '.outgoing_free_ser_checkbox',function(){
			var id = $(this).val();			 
			if($(this).is(':checked')){
				outgoing_postFreeServices(id,'insert');
			}else{
				outgoing_postFreeServices(id,'delete');
			}
		});
		$(document).on("click",'.outgoing_btn-description',function(){ 
			$.ajax({
		        type: "POST",
		        url: "{{URL::route('storage.packagedescription')}}",
		        data: {'package_id':$("#package_outgoing_detail_id").val(),'description':$('.decription-detail').val()},
		        dataType: "JSON",
		        success: function (response) {
		          if(response.status == 1)
		          {          
		            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
		          }
		          if(response.status == 0)
		          {          
		            responseMsg("error",'{{asset('images/error.png')}}');
		          }
		      	},
		      	error: function (jqXHR, exception) {
		           if (jqXHR.status == 422) {
		               
		            }
		        }
      		});
		});
	});
	function outgoing_additionalInfo(response){
		var a = '';
		var t = 0;
		if(response.storage > 180){
			t = 180-response.storage;
			a += '<span class="color-red">'+t+'Days</span>';
		}else{
			t = 180-response.storage;
			a += '<span class="color-normal">+'+t+'Days</span>';
		} 
		
		var outgoing_additional_info = '<div class="col-md-6">\
										<div class="list-group-item col-md-12  clearfix m-b-5">\
												<span class="bold pull-left">PACKAGE LOCATION :</span>';
												if(response.package.warehouse_shelf != null){
												outgoing_additional_info += '<span class="pull-right"> '+response.package.warehouse_shelf.name+'</span>';
												}else{
												outgoing_additional_info += '<span class="pull-right"> Null </span>';
												}	
										outgoing_additional_info += '</div>\
										<div class="list-group-item col-md-12 clearfix m-b-5">\
												<span class="bold pull-left">CUSTOM VALUE :</span>\
												<span class="pull-right outgoing_value_custom_detail_page"> NULL</span>\
										</div>\
										<div class="list-group-item col-md-12 clearfix m-b-5">\
												<span class="bold pull-left">STORAGE LEFT :</span>\
												<span class="pull-right"> '+a+'</span>\
										</div>\
									</div><div class="col-md-6 free_services">';
			$('.outgoing_additional_info').html(outgoing_additional_info);
	}
	function outgoing_freeServices(response){
		var a = "";
		var free_Services = '\
									<div class="card card-default">\
											<div class="card-header  separator">\
													<div class="card-title">Free Services\
													</div>\
											</div>\
											<div class="card-body">';
				$.each(response.free_services,function(index,value){
					
					if($.inArray(value.id,response.package.free_services) != '-1'){
						a = 'checked disabled';
					}else{
						a = 'disabled';
					}
					free_Services += '<div class="input-group-prepend ">\
															<input type="checkbox" '+a+' name="free_services" value="'+value.id+'" class="outgoing_free_ser_checkbox m-t-10 m-r-10">\
															<p class="m-b-0 text-c m-t-5">'+value.title+'\
															</p>\
												</div>';
					a = "";
				});
			free_Services += '</div>\
					</div>';
		$('.free_services').html(free_Services);
		$('.outgoing_value_custom_detail_page').html("$"+response.custom_detail_total);
	}
	function outgoing_paidServices(response){
		var url = '<?=route("storage.paidservicespackage"); ?>';
		var checked = [];
		var outgoing_paid_services = '<div class="col-md-3 justify-content-center d-flex flex-column bg-master-lighter">\
									<h4 class="text-center text-primary no-margin">\
									Paid Services\
									</h4>\
							</div>\
							<div class="col-md-9 col-sm-height padding-20 col-top">\
								<div class="btn-group btn-group-justified row w-100">';
				$.each(response.paid_services,function(index,value){
				console.log(response.package.parent_package_id);
				if(response.package.parent_package_id ==null){
				if(value.key == 'split'){
				outgoing_paid_services += '<div class="btn-group  col-5 p-l-10 m-b-10">\
													<button disabled ="true" type="button" data-toggle="modal" data-id="'+value.id+'" data-p_id="'+$("#package_outgoing_detail_id").val()+'" data-target="#package_split_modal" class="backgroud-clr split_btn btn btn-default w-100 btni'+value.id+'">\
													<span class="p-t-5 p-b-5">\
															<i class="fa fa-star fs-15"></i>\
													</span>\
													<br>\
													<span class="fs-11 font-montserrat text-uppercase">'+value.title+'</span>\
													</button>\
													<div class="img-paid-services img-paid paid'+value.id+'" data-id="">\
													<button class="btn"><img src ="<?=asset('images/checked.png') ?>" class="img-fluid" /></button>\
													</div>\
											</div>';
				}
				}
				if(value.key == 'detail_photos'){
				outgoing_paid_services += '<div class="btn-group col-5 p-l-10 m-b-10">\
													<button disabled ="true" type="button" title ="Add the Service" onclick="outgoing_paidServicesModal(\''+url+'\','+value.amount+','+value.id+',this)" class="backgroud-clr btn btn-default w-100 btni'+value.id+'">\
													<span class="p-t-5 p-b-5">\
															<i class="fa fa-history fs-15"></i>\
													</span>\
													<br>\
													<span class="fs-11 font-montserrat text-uppercase">'+value.title+'</span>\
													</button>\
													<div class="img-paid-services img-paid paid'+value.id+'">\
													<button class="btn"><img src ="<?=asset('images/checked.png') ?>" class="img-fluid" /></button>\
													</div>\
											</div>';
				}
				if(response.package.parent_package_id ==null){
				if(value.key == 'return'){
					$("#service_outgoing_detail_id").val(value.id);
				outgoing_paid_services += '<div class="btn-group col-5 p-l-10 m-b-10">\
													<button disabled ="true" type="button" data-service_id = "'+value.id+'" data-id = "'+$("#package_outgoing_detail_id").val()+'" title ="Add the Service" onclick="outgoing_paidServicesModal(\''+url+'\','+value.amount+','+value.id+',this,\'return\')" class="backgroud-clr btn btn-default return_label_btn w-100 btni'+value.id+'">\
													<span class="p-t-5 p-b-5">\
															<i class="fa fa-user fs-15"></i>\
													</span>\
													<br>\
													<span class="fs-11 font-montserrat text-uppercase">'+value.title+'</span>\
													</button>\
													<div class="img-paid-services img-paid paid'+value.id+'">\
													<button class="btn"><img src ="<?=asset('images/checked.png') ?>" class="img-fluid" /></button>\
													</div>\
											</div>';
				}
				}
				if(value.key == 'test_device'){
				outgoing_paid_services += '<div class="btn-group col-5 p-l-10 m-b-10">\
													<button disabled ="true" type="button" title ="Add the Service" onclick="outgoing_paidServicesModal(\''+url+'\','+value.amount+','+value.id+',this)" class="backgroud-clr btn btn-default w-100 btni'+value.id+'">\
													<span class="p-t-5 p-b-5">\
															<i class="fa fa-user fs-15"></i>\
													</span>\
													<br>\
													<span class="fs-11 font-montserrat text-uppercase">'+value.title+'</span>\
													</button>\
													<div class="img-paid-services img-paid paid'+value.id+'">\
													<button class="btn"><img src ="<?=asset('images/checked.png') ?>" class="img-fluid" /></button>\
													</div>\
													\
											</div>';
				}

				if($.inArray(value.id,response.added_paid_services) != '-1'){
					checked.push(value.id);

				}
			});
			outgoing_paid_services += '</div></div>';
			$('.outgoing_paid_services').html(outgoing_paid_services);
			$.each(checked,function(index,value){
				$('.paid'+value).show();

				$('.btni'+value).prop('disabled', true);
			});
		}
	function outgoing_postFreeServices(id,flag){
		$.ajax({
	        type: "POST",
	        url: "{{URL::route('storage.freeserviepackage')}}",
	        data: {'id' : id,'flag' : flag,'package_id':$("#package_outgoing_detail_id").val()},
	        dataType: "JSON",
	        success: function (response) {
	          if(response.status == 1)
	          {          
	            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
	          }
	          if(response.status == 2)
	          {          
	            responseMsg("delete",'{{asset('images/icons8-ok-filled-480.png')}}');
	          }
	          if(response.status == 0)
	          {          
	            responseMsg("error",'{{asset('images/error.png')}}');
	          }
	      	},
	      	error: function (jqXHR, exception) {
	           if (jqXHR.status == 422) {
	               
	            }
	        }
      });
	}
	function outgoing_paidServicesModal(url,amount,id,e,type=""){ 
			var package_id = $('#package_outgoing_detail_id').val();
		    swal({
	            title: "It will cost you $ "+amount+" USD",
	            text: '',
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: 'Ok',
	            cancelButtonText: "No, cancel please!",
	            closeOnConfirm: false,
	            closeOnCancel: true
	          },
	          function(isConfirm){
	            if (isConfirm) {
	            	if(type == ""){
		                $.ajax({
	                        type: "POST",
	                        url: url,
	                        data: {'service_id':id,'package_id':package_id},
	                        dataType: "JSON",
	                        success: function (response) {
	                          if(response.status == 1)
	                          {
	                          	// $(e).removeClass('backgroud-clr btn-default');
	                          	// $(e).addClass('btn-primary');
	                          	$(e).next().show();
	                          	$(e).prop('disabled', true);
	                            swal("Success", "Service Added. :)", "success");
	                          }
	                      	},
	                      	error: function (jqXHR, exception) { 
	                        }
		                });
	            	}else{
	            		$("#return_package_detail_modal").modal('show');
	            		swal.close()
	            	}
               	}else {
                	//swal("Cancelled", "Request cannot processed.", "error");
	            }
			}); 
	}
	function outgoing_descriptionPackage(response){
		var html = '';
		var a = '';


		console.log(response.package.description);

		
		if(response.package.description != null){
			a += response.package.description;
		}
		html += `<div class="col-md-10">
								<div class="form-group form-group-default pull-left">
									<label class="pull-left">Description</label>
									<textarea class="form-control decription-detail" name="description">`+a+`</textarea>

								</div>
							</div>
							<div class="col-md-2 m-b-10" >
								<button style="height:100%	" class="btn btn-primary outgoing_btn-description pull-left pull-left"><i class="fa fa-check"></i> </button>
							</div>`;
							
		$('.outgoing_description-html').html(html);
	}
	</script>
	@endsection