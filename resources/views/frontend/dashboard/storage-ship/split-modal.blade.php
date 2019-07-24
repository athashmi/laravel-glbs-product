<div class="modal fade slide-right" id="package_split_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height col-lg-12">
							<div class="modal-header">
								<button type="button" class="backgroud-clr split_back_btn btn btn-default pull-left" data-dismiss="modal" aria-hidden="true">
									<i class="fa fa-long-arrow-left  fs-14"></i>
								</button>
								<h4 class="modal-title pull-left" id="myModalLabel">
									<b>Split Package</b>
								</h4>
								
							</div>

							<form id="packages-form">

								<input type="hidden" name="split_id" id="split_id">
								<input type="hidden" name="package_id" id="package_id">
								<div class="col-lg-12" id="packages-div">
									<div data-pages="card" class="card card-default package-card" id="package-card">
										<div class="card-header  ">
											<div class="card-title">Package-Child-1
											</div>
											<div class="card-controls">
												<ul>
													<li>
														<a data-toggle="close" class="card-close" href="#"><i class="card-icon card-icon-close package-card-close"></i></a>
													</li>
												</ul>
											</div>
										</div>
										<div class="card-body package_split_show">
											
											<div class="widget-11-table table-responsive">
												<table class="table table-condensed table-hover">
													<thead>
														<tr class="d-flex">
															<th class="col-8">Name</th>
															<th class="col-3">Qty</th>
															<th class="col-1"></th>
														</tr>
													</thead>
													<tbody id="items">
														<tr class="d-flex">
															<td class="col-8 font-montserrat all-caps fs-12 b-r b-dashed b-grey">
																<!-- <input type="text" class="col-md-12 no-border form-control" placeholder="Item name" name="package[1][item][1][name]" rel="input-name" required> -->
																<div class="form-group form-group-default">
																
																<input type="text" class="col-md-12 form-control" placeholder="Item name" name="package[1][item][1][name]" rel="input-name" required>
																</div>
																	
															</td>
															
															<td class="col-3  b-r b-dashed b-grey">
																<div class="form-group form-group-default">
																<input type="text" class="col-md-12 form-control" placeholder="Qty" name="package[1][item][1][qty]" rel="input-qty" required>
															</div>
															</td>
															<td class="col-1 text-middle">
																<span class="font-montserrat fs-18"></span>
															</td>
														</tr>
													</tbody>
													<tfoot>
														<tr>
															<td  class="col-12">
															
					                                        <a href="javascript:void(0)" class="pull-right btn-plus-add btn btn-default" id="item-add" data-pkg="1" data-item="1"> <i class="fa fa-plus" ></i></a>
					                                       </td>
				                                    	</tr>
													</tfoot>
												</table>
											</div>

										</div>
									</div>
								</div>
							</form>
						<div class="clearfix"></div> 
						<div class="modal-footer">
							<div class="error_msg_p_split col-lg-12"></div>
							<div class="col-lg-12">
								<button type="button" class="btn btn-primary add-package-btn float-sm-left"><i class="fa fa-plus"></i> Add Package</button>
								<button type="button" class="btn btn-primary btn-send-split-package float-sm-right">Send</button>
							</div>
						</div>	 
						</div>
						<div class="clearfix"></div> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@section('script')
@parent
<script type="text/javascript">
	var package_card ='';
	var num = 1;

	
	$(document).ready(function(){
		package_card = $('#package-card').clone(true);
		
		$('.add-package-btn').on('click',function(){
			 num++;			
			 package_card.find('.card-title').text('package-child-'+num);
			 package_card.find('input[rel="input-name"]').attr('name','package['+num+'][item][1][name]');
			 package_card.find('input[rel="input-qty"]').attr('name','package['+num+'][item][1][qty]');
			 package_card.find('#item-add').data('pkg',num);
			 $('#packages-div').append(package_card.clone(true));
			
		});
		$(document).on("click", '.btn-plus-add',function(){

	       		//var idss = $(this).attr("id");
   				//var ar_split_plus = idss.split('_'); 
   				var pkg = $(this).data('pkg');
   				var item = ($(this).data('item'))+1;
   				//alert(pkg);
   				var html = '<tr class="d-flex">\
								<td class="col-8 font-montserrat all-caps fs-12 b-r b-dashed b-grey">\
								<div class="form-group form-group-default">\
									<input type="text" class="col-md-12 form-control" placeholder="Item name" name="package['+pkg+'][item]['+item+'][name]" required>\
									</div>\
									</td>\
								<td class="col-3  b-r b-dashed b-grey">\
								<div class="form-group form-group-default">\
									<input type="text" class="col-md-12  form-control" placeholder="Qty" name="package['+pkg+'][item]['+item+'][qty]" required>\
									</div>\
								</td>\
								<td class="col-1 text-middle">\
									<span class="font-montserrat fs-18">\
									<a href="javascript:void(0)" class="remove-item">X</a>\
									</span>\
								</td>\
							</tr>';
				$(this).data('item',item);
			
			var div = $(this).parent().parent().parent().siblings('#items').append(html);

		});

		$(document).on("click", '.remove-item',function(){
			$(this).parent().parent().parent().remove();
		});
		$(document).on("click", '.package-card-close',function(){	
		//console.log($(this).text());
			$(this).parent().parent().parent().parent().parent().parent().remove();
		});
		
		$('.btn-send-split-package').on('click',function(e){
			//e.preventDefault();

			$("#packages-form").validate(
			/*{
				invalidHandler: function(form, validator) {
				    //var errors = validator.numberOfInvalids();

				    if (errors) {
				        var errors = "";

				        if (validator.errorList.length > 0) {
				            for (x=0;x<validator.errorList.length;x++) {
				                errors += "<p>" + validator.errorList[x].message + "</p>";
				            }
				        }
				        //display_modal('You have an error', errors);
				        //$('.error_msg_p_split').text(errors)
				    }
				    //validator.focusInvalid();
				    e.preventDefault();
				}
			}*/
			);

			if($("#packages-form").valid()) {
						
				$.ajax({
			        type: "POST",
			        url: "{{URL::route('storage.splitpackage')}}",
			        //data: {'name' : $('input[name*="item"]').serialize(),'quantity':$('input[name*="quantity"]').serialize(),'service_id':$('#split_id').val(),'package_id':$("#package_id").val()},
			        data:$('#packages-form').serialize(),
			        dataType: "JSON",
			        success: function (response) {
			          if(response.status == 1)
			          {   
			            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
			            $('.pgn-wrapper').css('z-index','999999 !important');
			            $('.split_btn').prop('disabled',true);
			            $('.split_btn').next().show();
					    $('#package_split_modal').modal('hide');	            
			          }

			         	$('.datatable').DataTable().draw();
			      	}
			    });
			}
		});


		 $('#package_split_modal').on('shown.bs.modal', function (e) {
		       var id = $(e.relatedTarget).data('id');
		       var package_id = $(e.relatedTarget).data('p_id');

		       $('#split_id').val(id);
		       $("#package_id").val(package_id);
		    });
	});
</script>
@endsection