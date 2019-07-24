@extends('employee.layout')
@section('content')
<div class="content">
	<div class=" container-fluid   container-fixed-lg p-0 ">
		<div class="card card-transparent p-0">
			<div class="card-body p-0">
				<div class="col-md-8 p-t-20 pull-left">
					<div class="row">
						@include('employee.workday_started_remaining')
						<div class="col-lg-4">
							<div id="card-linear-color" class="card card-default">
								<div class="card-body p-t-10 p-b-0 p-l-5">
									<div class="col-4 pull-left">
										<img src="{{asset('images/employee-time-consuming.png')}}" class="img-fluid m-r-15 "     />
									</div>
									<div class="col-8 p-l-0 p-r-0 pull-left">
										<h6 class="m-b-0">Time Remaining to select</h6>
										<h3 class="m-t-0"><b class="m-r-0 remaing_time_select">00:30</b></h3>
									</div>
								</div>
							</div>
						</div>
						<hr width="100%" class="margin-6" />
						<!-----------------   Body ---------------->
						@php
							$cart_colors = ['red'=>'white','blue'=>'white','yellow'=>'black','orange'=>'black','green'=>'white'];
						@endphp
						@foreach($consolidation->packages as $package)

						<div class="col-md-5 m-b-20">
							<div class="widget-16 card no-margin widget-loader-circle" id="package_{{$package->id}}">

								<div class="card-header " style="background-color: {{$package->packagePicked->details->cart_section_color}};color:{{$cart_colors[$package->packagePicked->details->cart_section_color]}}">
									<div class="card-title">
										<b>C.Location : </b>
									</div>
									<div class="card-controls">
										<ul>
											<li>
												<b>{{$package->packagePicked->details->cart}}</b>
											</li>
										</ul>
									</div>
								</div>

								<div class="card-header ">
									<div class="card-title">
										<b>Tracking No : </b>
									</div>
									<div class="card-controls">
										<ul>
											<li class="trcking-num">
												{{$package->tracking_number }}
											</li>
										</ul>
									</div>
								</div>
								<hr/>
								<div class="card-header ">
									<div class="card-title">
										<b>Location : </b>
									</div>
									<div class="card-controls">
										<ul>
											<li>
												{{($package->warehouseShelf) ? $package->warehouseShelf->name : 'NULL'}}
											</li>
										</ul>
									</div>
								</div>

								<div class="p-l-25 p-r-45 p-t-25 p-b-25" >
									<div class="row">
										@if($package->images->count() > 0)
											<div class="gallery-item " data-width="2" data-height="2">
												<div class="live-tile clck-img slide" data-id ="{{$package->id}}" data-speed="750" data-delay="4000" data-mode="carousel">
													@foreach($package->images as $key => $image)
														<div class="slide-front">
															<img src="{{$image->image_name}}" alt="" class="image-responsive-height">
														</div>
														<div class="slide-back">
															<img src="{{$image->image_name}}" alt="" class="image-responsive-height">
														</div>
														@if($key == 0)
															@break
														@endif
													@endforeach
												</div>
											</div>
										@else
											<img src="{{asset('images/no-image.jpg')}}" class="img-fluid" />
										@endif
									</div>
								</div>
								<div class="b-b b-t b-grey p-l-20 p-r-20 p-b-10 p-t-10">
									<p class="pull-left">Package is missing</p>
									<div class="pull-right">
										<input type="checkbox"{{($package->status == 'missing' ? 'checked' : '')}} data-id ="{{$package->id}}" class="switchery pkg_check pkg_missing_{{$package->id}}" data-init-plugin="switchery" />
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="b-b b-grey p-l-20 p-r-20 p-b-10 p-t-10">
									<p class="pull-left">Package is found</p>
									<div class="pull-right">
										<input type="checkbox" {{($package->found) ? ($package->found->action_status == 'found' ? 'checked' : '') : ''}} data-id ="{{$package->id}}" data-init-plugin="switchery" class="switchery pkg_check pkg_found_{{$package->id}}" />
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="b-b b-grey p-l-20 p-r-20 p-b-10 p-t-10">
									<p class="pull-left">Remaining Item</p>
									<div class="pull-right">
										<input type="checkbox" class="switchery" data-init-plugin="switchery" />
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="b-b b-grey p-l-20 p-r-20 p-b-10 p-t-10">
									<p class="pull-left">Dangerous Goods</p>
									<div class="pull-right">
										<input type="checkbox" data-init-plugin="switchery" class="switchery" />
									</div>
									<div class="clearfix"></div>
								</div>

							</div>
						</div>
						@endforeach

						<!-----------------   End Body ------------>
					</div>
				</div>
				<div class="col-md-4 p-t-20 pull-left">
					<div class="row">
						<div class="col-lg-12 p-0">
							<div id="card-linear-color" class="card border-0 card-default p-0">
								<div class="card-body p-l-10 p-r-10">
									<div class="col-md-12 p-0">
				                  <form method="POST" id="formid_create_add_weight" action="javascript:;" accept-charset="UTF-8" autocomplete="off">
						                <h5>
						                	<input type="hidden" name="consolidate_id" value="{{$consolidation->id}}">
						                	<b>Customer</b>
						                	<span>: <b>{{@$consolidation->shopaholic->user->first_name .' '. @$consolidation->shopaholic->user->last_name}}</b></span>
						                </h5>
						                <h5>
						                	<b>Request ID :</b>
						                	<h6 class="m-l-50"> {{$consolidation->unique_key}}</h6>
						                </h5>
						                <p>
						                	Special request (if any)
						                </p>
						                <textarea class="m-b-20 form-control full-width" name="special_instructions">{{$consolidation->special_instructions}}</textarea>
						                <div class="clearfix"></div>
						                <div class="services_ row m-l-0 m-r-0 m-b-10 p-l-10 p-r-10">
							                <button type="button" class="cross_btn hide-cross" style="left:90%">×</button>
							                <div class="col-6 pull-left p-0 m-t-20">
							                	<b>Length</b>
							                	<input type="text" name="arr[0][lenght]" class="form-control lenght field_c_class">
							                </div>
							                <div class="col-6 pull-left p-r-0 m-t-20">
							                	<b>Width</b>
							                	<input type="text" name="arr[0][width]" class="form-control width field_c_class">
							                </div>
							                <div class="col-6 pull-left m-t-10 m-b-20 p-0">
							                	<b>Height</b>
							                	<input type="text"  name="arr[0][height]" class="form-control height field_c_class">
							                </div>
							                <div class="col-6 pull-left m-t-10 m-b-20 p-r-0">
							                	<b>Weight</b>
							                	<input type="text" name="arr[0][actual_weight]" class="form-control actual_weight field_c_class">
							                	<div class="paid_services">
							                		<input type="hidden" name="arr[0][dimensional_weight]" class="diemensional_weight_class">
							            		</div>
							                </div>
						            	</div>
										<div class="add_box_ser"></div>
						                <div class="col-4 offset-8 pull-left m-t-10 p-r-0">
						                	<button class="btn btn-primary pull-right add_more_box">
						                		<i class="fa fa-plus"></i>
						                		Add Box
						                	</button>
						                </div>


						                <!---- Battery amd liquid div ------->
						                @foreach($consolidate_goods_descriptions as $goods)
										@if($goods->type == 'liquid')
										<div class="col-5 pull-left border-all m-r-20 p-0 m-t-20 div_select">
											<input type="checkbox" name="goods_id[]" value="{{$goods->id}}" class="condition_box display-none">
											<div class="col-5 pull-left ">
												<img src="{{asset('images/liquid.png')}}" class="img-fluid" />
											</div>
											<div class="col-7 pull-left p-0 m-t-10">
												<p> <span> {{$goods->title}}</span></p>
											</div>
										</div>
										@endif
										@if($goods->type == 'battery')
										<div class="col-5 pull-left border-all  m-r-20  p-0 m-t-20 div_select">
											<input type="checkbox" name="goods_id[]" value="{{$goods->id}}" class="condition_box display-none">
											<div class="col-5 pull-left p-r-5 m-t-15">
												<img src="{{asset('images/battery.png')}}" class="img-fluid" />
											</div>
											<div class="col-7 pull-left p-0 m-t-10">
												<p> <span> {{$goods->title}}</span></p>
											</div>
										</div>
										@endif
										@endforeach



										<!---- End Battery and liquid --------->
										<div class="clearfix"></div>
										<div class="col-md-12 m-t-20">
											<p> Select Location</p>
											<select class="form-control full-width" name="location">
												<option value="">Choose Location</option>
												@foreach($warehouse_shelves as $shelf)
												<option value="{{$shelf->id}}">{{$shelf->name.'-'.$shelf->color}}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-12 m-t-20">
											<div class="error_msg_consolidate">
											</div>
										</div>
										<div class="row">
											<div class="col-3 pull-left m-l-10 m-t-20">
							                	<button class="btn btn-rounded btn-danger pull-right">
							                		SKIP
							                	</button>
							                </div>
							                <div class="col-3 pull-left  m-l-15 m-t-20">
							                	<button class="btn btn-rounded btn-warning pull-right">
							                		INVOICE
							                	</button>
							                </div>
							                <div class=" col-5 ">
							                	<div class="col-6 pull-left  m-l-20 m-t-20 ">
							                	<input type="submit" name="" value="SUBMIT" class="btn btn-rounded btn-submit-add-actual-weight  btn-success pull-right">
							                	</div>
							            	</div>
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
	</div>
</div>

 <div id="itemDetails" class="dialog item-details">
   <div id="" class="dialog item-details dlg-open">
	<div class="dialog__overlay"></div>
	<div class="dialog__content">
		<div class="container-fluid">
			<div class="row dialog__overview">
				<div class="col-md-12 no-padding item-slideshow-wrapper full-height">
					<div class="item-slideshow full-height owl-carousel body-dlg">


					</div>
				</div>
			</div>
			<button class="close action top-right btn-close-dlg" data-dialog-close><i class="pg-close fs-14"></i>
		</button>
		</div>

	</div>
</div>
</div>
@include('revox-theme.js-css-blades.switchery')
@include('revox-theme.js-css-blades.gallery')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.flipclock')
@include('employee.delay-model')
@include('employee.consolidate.vape_confirmation_model')
@endsection



@section('script')
@parent

<script type="text/javascript">
//document.addEventListener("DOMContentLoaded", yall);
	var already_send = 0;
	  var i = 1;
	var clone_html ;
	var start_time_cosolidation;
	var submit_form = false;

	var vap_items_arr ={};

	//saving ids to verify inner_content images
	var index = 0;
	var packageIds = [];
	<?php foreach($consolidation->packages as $package){ ?>
		packageIds[index] = parseFloat('<?php echo $package->id; ?>');
		index++;
	<?php } ?>

	$(document).ready(function(){

		startCountDown(300);
		start_time_cosolidation = getCurrentDateTime();



		clone_html = $('.services_').clone(true);
		$('.clck-img').click(function(){

			//if(already_send != 1){
				$.get('{{URL::route("employee.consolidate.package_images")}}',{'id':$(this).data('id')},function(response) {

		            	var html = ``;
		            	$.each(response.package.images,function(key,value){
		            		html += `<div class="slide slide_sm" data-image="`+value.image_name+`">
							</div>`;
		            	});
		            	$('.body-dlg').html(html);

						  //$('body').on('click', '.gallery-item', function () {
						    var dlg = new DialogFx($('#itemDetails').get(0));
						    dlg.toggle();
						  //});

						//$('.dlg-open').addClass('dialog--open');
						already_send = 1;

	        	},"json");
        	//}else{
        		//$('.dlg-open').addClass('dialog--open');
        	//}
		});
		$('.btn-close-dlg').click(function(){
			$('.dlg-open').removeClass('dialog--open');
		});
		$('.add_more_box').on('click',function(){
	    	renderCustomBox('.add_box_ser',clone_html);
	    });
	    $(document).on('keyup','.field_c_class',function(){

	    	dynamicCalculation($(this),'.paid_services');
	    });
	    $(document).on('click','.cross_btn',function(){
	    	$(this).parent().remove();
	    });
	    $('.div_select').click(function(){
	    	$(this).toggleClass('label-success');
	    	if($(this).find('.condition_box').prop('checked') == true){
	    		$(this).find('.condition_box').prop('checked',false);
	    	}else{
	    		$(this).find('.condition_box').prop('checked',true);
	    	}
	    });
	    $('.pkg_check').change(function(){
	    	var id = $(this).data('id');
	    	var clas_ = $(this).attr('class').split(/\s+/);
	    	if(last(clas_) == 'pkg_missing_'+id){
	    		$('.pkg_found_'+id).prop("checked", false);
	    		$('.pkg_found_'+id).next().removeAttr('style');
	    		$('.pkg_found_'+id).next().children().removeAttr('style');
	    		if($(this).prop('checked') == true){
	    			var data = {'id' : id,'type':'missing'};
	    			updatePackageStatus(data);
	    		}else{
	    			$('.pkg_found_'+id).next().css({"box-shadow":"rgb(16, 207, 189) 0px 0px 0px 16px inset","border-color": "rgb(16, 207, 189)","background-color":"rgb(16, 207, 189)","transition":"border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s"});
	    			$('.pkg_found_'+id).next().children().css({"left":"20px","background-color":"rgb(255, 255, 255)","transition":"left 0.2s ease 0s"});
	    			$('.pkg_found_'+id).prop("checked", true);
	    			var data = {'id' : id,'type':'found'};
	    			updatePackageStatus(data);

	    		}
	    	}
	    	if(last(clas_) == 'pkg_found_'+id){
	    		$('.pkg_missing_'+id).prop("checked", false);
	    		$('.pkg_missing_'+id).next().removeAttr('style');
	    		$('.pkg_missing_'+id).next().children().removeAttr('style');
	    		if($(this).prop('checked') == true){
	    			var data = {'id' : id,'status' : 'checked','type':'found'};
	    			updatePackageStatus(data);
	    		}else{
	    			$('.pkg_missing_'+id).next().css({"box-shadow":"rgb(16, 207, 189) 0px 0px 0px 16px inset","border-color": "rgb(16, 207, 189)","background-color":"rgb(16, 207, 189)","transition":"border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s"});
	    			$('.pkg_missing_'+id).next().children().css({"left":"20px","background-color":"rgb(255, 255, 255)","transition":"left 0.2s ease 0s"});
	    			$('.pkg_missing_'+id).prop("checked", true);
	    			var data = {'id' : id,'type':'missing'};
	    			updatePackageStatus(data);
	    		}
	    	}
	    });
	    $(".btn-submit-add-actual-weight").click(function(e){
	    	// alert('triggererefd');
	    	//console.log(e);
	    	e.preventDefault();
	    	//return false;
				var check = packageIds.length;

				if(check == 0){
					let this_btn = this;
					loader(this_btn);

					$(".condition_box").each(function(index){
							 if($(this).is(":checked")) {
									 vap_items_arr[index] = $(this).val();
							 }
					 });

					if(Object.keys(vap_items_arr).length == 0){
						 $("#VapeConfirmationModel").modal("show");
						 hide_loader(this_btn);

						 if(!submit_form)
						 return false;
					 }

				 //alert('jjjj');
				 //return false;
				 $.ajax({
						 type: "POST",
						 url: "{{route('employee.consolidate.add_actual_weight')}}",
						 data: $("#formid_create_add_weight").serialize()+'&start_time_consolidation='+start_time_cosolidation,
						 dataType: "JSON",
						 success: function (response) {
							 //console.log(response);
						 if(response.status == 1)
						 {
							 responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
							 setTimeout(function(){
								 location.replace("{{route('employee.consolidate.index')}}");
							 }, 1000);
						 }
						 },
						 error: function (jqXHR, exception) {
								if (jqXHR.status == 422) {
									 var html_error = '';
									 console.log(jqXHR.responseJSON.errors);
						 $.each(jqXHR.responseJSON.errors, function (key, value)
						 {
							 html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
						 })
						 html_error += "</ul></div>";
						 $('.error_msg_consolidate').html(html_error);
						 $('.btn-submit-add-actual-weight').show();
						 hide_loader(this_btn);
								 }
						 }
			 });
		 }else{
			 responseMsg("error","{{asset('images/error.png')}}","Inner images not available<br> against all packages");
		 }
	    });

});

	function renderCustomBox(class_name,html){
    	var newaddress= html.clone(true);
	    	newaddress.find('input').each(function() {
    			this.name = this.name.replace('[0]', '['+i+']');
			});
			i++;
	    	$(class_name).append(newaddress);
	    	$(class_name).find('.hide-cross').removeClass('hide-cross');
    }
    function last(array) {
	    return array[array.length - 1];
	}
	function updatePackageStatus(data){
	    	$.ajax({
			      type: "POST",
			      url: "{{route('employee.consolidate.package_missing_found')}}",
			      data: {'data':data},
			      dataType: "JSON",
			      success: function (response) {
			      if(response[0].status == 1){
			        responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
			      }
			     },
			      error: function (jqXHR, exception) {
		           if (jqXHR.status == 422) {

		            }
		        }
			});
    }
    function dynamicCalculation(e,clas_name){
    	//alert(222);
    	var length 				= $(e).parent().parent().find('.lenght').val();
    	var height 				= $(e).parent().parent().find('.height').val();
    	var width  				= $(e).parent().parent().find('.width').val();
    	var weight 				= $(e).parent().parent().find('.actual_weight').val();
     	var dimensional_weight 	= (length*width*height)/138.4;
    	var diff 				= parseFloat(dimensional_weight) - parseFloat(weight);
        if(diff>0){
            if(diff < 16){
            }else if(diff > 15 && diff < 25){
               dimensional_weight = (length*width*height)/166;
            }else if(diff > 24){
               dimensional_weight = (length*width*height)/194;
            }
        }
        $(e).next(clas_name).find('.diemensional_weight_class').val(dimensional_weight.toFixed(2));
    }

		//checking inner_content images from Database against packages
			setInterval(function(){
				if(packageIds.length>0){
					$.ajax({
						type: "POST",
						url: "{{route('employee.consolidate.check_package_inner_content')}}",
						data: {'packages':packageIds},
						dataType: "JSON",
						success: function (response) {
							for(var i=0;i<response.length;i++){
								$("#package_"+response[i]).addClass('green-border');
								packageIds = removeValueFromArray(response[i],packageIds);
							}
						},
						error: function (jqXHR, exception) {
							if (jqXHR.status == 422) {

							}
						}
					});
				}
			},
			3000);

</script>
@endsection
