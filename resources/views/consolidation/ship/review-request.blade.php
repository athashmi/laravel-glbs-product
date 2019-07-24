@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			<div class="inner">
				{{ Breadcrumbs::render('shopaholic') }}
			</div>
		</div>
	</div>
	<div class=" container-fluid   container-fixed-lg bg-white">
		<div class="row">
			<div class="col-lg-12">
				<div class=" container-fluid   container-fixed-lg">
					<div class="card card-transparent ">
						<div class="card-header ">
							<div class="card-title"><b>Consolidate And Ship Request</b>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6">
									<div id="card-linear" class="card card-default">
										<div class="card-header  ">
											<div class="card-title">Basic Info
											</div>
											<div class="card-controls">
												
											</div>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-6 p-r-10">
													<div class="row">
														<div class="col-lg-12">
															<p class="pull-left">Request ID:</p>
															<p class="pull-right bold">{{$consolidation->unique_key}}</p>
														</div>
													</div>
													{{-- <div class="row">
														<div class="col-lg-12">
															<p class="pull-left">Warehouse Location:</p>
															<p class="pull-right bold">05:20</p>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<p class="pull-left">Number of items:</p>
															<p class="pull-right bold">20%</p>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<p class="pull-left">Weight (Pounds):</p>
															<p class="pull-right bold">60%</p>
														</div>
													</div> --}}
													<div class="row">
														<div class="col-lg-12">
															<p class="pull-left">Customs & Insurance Value</p>
															<p class="pull-right bold">USD ${{$sum}}</p>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<p class="pull-left">Consolidated Boxes Location:</p>
															<p class="pull-right bold">
																@if($consolidation->fetchLocation)
																{{$consolidation->fetchLocation->location->name}} - {{$consolidation->fetchLocation->location->color}}
																@else
																NULL
																@endif
															</p>
														</div>
													</div>
													
												</div>
												<div class="col-6 p-l-10">
													
													<div class="row">
														<div class="col-lg-12">
															<p class="pull-left">Weight added at:</p>
															<p class="pull-right bold">
															{{($consolidation->fetchLocation ? Helper::formatDate($consolidation->fetchLocation->created_at) : 'NULL')}}
														</p>
														</div>
													</div>
												</div>
												<hr width="100%" />
												<div class="col-md-12">
													<b>ADDITIONAL INFO </b>
													<div class="clearfix"></div>

													@foreach($consolidation_request_info as $request_info)
													
													<div class="input-group-prepend ">
														<input type="checkbox"  name="spec[]" value="" class=" m-t-10 m-r-10" @if($consolidation->request_infos){{in_array($request_info->id,$consolidation->request_infos) ? 'checked' : ''}}@endif  disabled="">
														<p class="m-b-0 m-t-5">
															{{$request_info->title}}
														</p>
													</div>
													@endforeach
													
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div data-pages="card" class="card card-default card-collapsed" id="">
										<div class="card-header  ">
											<div class="card-title">Address Info
											</div>
											<div class="card-controls">
												
											</div>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-12 p-l-10">
													<div class="row">
														<div class="col-lg-12">
															<p class="">Destination Address:</p>
															<p class="bold">
																@if($consolidation->address)
																{{$consolidation->address->name.', '.$consolidation->address->city.', '.$consolidation->address->state.', '.$consolidation->address->zip_code.', '.$consolidation->address->country.', '.$consolidation->address->phone}}
																@endif
															</p>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<p class="">Special Request (If any)</p>
															<p class="bold">{{$consolidation->special_instructions}}</p>
														</div>
													</div>
													<div class="row">
														<hr width="100%" />
														<div class="col-lg-12">
															<h3>Request History</h3>
															 <div id="timeline">
																@foreach($consolidation->requestDetail as $request_detail)
																	<div class="timeline-item">
																		<div class="timeline-icon">
																			<img src="{{asset('images/icons8-ok-filled-480.png')}}" class="img-fluid" alt="">
																		</div>
																		<div class="timeline-content">
																			<h5>{{$request_detail->action_status}}</h5>
																			<p>
																				{{Helper::formatDate($request_detail->created_at)}}
																			</p>
																			@if($request_detail->action_status == 'cancelled')
																				<p>{{$request_detail->details->reason}}</p>
																			@endif
																		</div>
																	</div>
																@endforeach
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="custom_package_listing col-lg-12">
								</div>
								<div class="col-md-12">
									<div class="dataTables_wrapper">
										<div class="col-ms-12 pagination-div pull-right dataTables_paginate paging_simple_numbers">
											<ul class="pagination pagination-la "></ul>
											<div class="clearfix"></div>
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
</div>
@include('revox-theme.js-css-blades.datatables') 
@include('revox-theme.js-css-blades.pagination')
@endsection
@section('styles')
@parent
<style type="text/css">
	th.sorting{
		width:auto !important;
	}
	th.sorting_asc{
		width:auto !important;
	}
	th.sorting_desc{
		width:auto !important;
	}
	th.sorting_disabled{
		width:auto !important;
	}
</style>
@endsection
@section('script')
@parent
<script type="text/javascript">
	$(document).ready(function(){
	
		packageAjax('{{URL::route("consolidation.shipment.get_review_request_package")}}?page=1');
		 $(document).on("click",'.pg-ar-show',function(){
			var el = $(this).find('i.pg-arrow_maximize');
			if(el.length > 0){
				el.addClass('pg-arrow_minimize');
				el.removeClass('pg-arrow_maximize');
				$(this).parent().parent().parent().parent().find('.card-body-h').show();
			}else{
				var pl = $(this).find('i.pg-arrow_minimize');
				pl.addClass('pg-arrow_maximize');
				pl.removeClass('pg-arrow_minimize');
				$(this).parent().parent().parent().parent().find('.card-body-h').hide();
			}
		});
	});
	  var paginate = function(total,per_page){
    
     $('.pagination-la').pagination({
        items: total,
        itemsOnPage: per_page,
        //cssStyle: 'light-theme',
        hrefTextPrefix:'?page=',
        listStyle: 'paginate_button',
        prevText: '<',
        nextText: '>',
        
        onPageClick: function(pageNumber, event) {
        	event.preventDefault();
        	packageAjax('{{URL::route("consolidation.shipment.get_review_request_package")}}?page='+pageNumber,1);
        },
        onInit:function(){
          $('.page-link-href').parent().addClass('paginate_button');
          $('a.current').parent().addClass('active');

        }
    }); 
  }
    function packageAjax(url,d=''){
    	$.get(url,{'id':{{$consolidation->id}}},function(response) {
		if(response.status == 1)
		{
			packageRender(response);
			if(d ==''){
				paginate(response.data.total,response.data.per_page);
			}
			
			
		}
		},"json");
		
		
    } 
	function packageRender(response){
		var html = ``;
		var i = 1; 
		var a = '';
		var sum = 0;
		$.each(response.data.data,function(key,value){
			 sum = 0;
			html += `<div class="col-lg-12 pack`+value.id+`">
										<hr width="100%" />
										<div data-pages="card" class="card card-default card-collapsed" id="card-basic">
											<div class="card-header p-b-0 m-b-0 ">
												<div class="row">
													<div class="col-md-2 col-sm-6 col-xs-6 pull-left">
														<b>Package </b>
													</div>
													<div class="col-md-3 col-sm-6 col-xs-6 pull-left">
														<b>Tracking : </b><span>`+value.tracking_number+`</span>
													</div>
													<div class="col-md-3">
														<b>ID : </b><span>`+value.package_id+`</span>
													</div>
													<div class="col-md-2">
														<b>Location : </b><span>`;
														if(value.warehouse_shelf){
															html += value.warehouse_shelf.name ;
														}else{
															html += 'NULL';
														}
														html +=`</span>
													</div>
													<div class="col-md-2 ">
														<a data-toggle="collapse" class="card-collapse pg-ar-show pull-right " href="#"><i class="pg-arrow_maximize"></i></a>
													</div>
												</div>
											</div>
											<hr width="100%" class="m-0 p-0" />
											<div class="row card-body card-body-h" style="display:none">
											<div class="col-md-4 m-l-5 m-b-10">
												<div class="list-group-item col-md-12 clearfix m-b-5">		
													<span class="bold pull-left">Consolidated Location :</span>
													<span class="pull-right">
														 <span class="color-normal">@if($consolidation->fetchLocation)
																{{$consolidation->fetchLocation->location->name}} - {{$consolidation->fetchLocation->location->color}}
																@else
																NULL
																@endif</span>
													</span>
												</div>
												<div class="list-group-item col-md-12  clearfix m-b-5">
													<span class="bold pull-left">Package Uploaded At :</span>
													<span class="pull-right"> `+ value.created_at+` </span>
												</div>
												<div class="list-group-item col-md-12 clearfix m-b-5">
													<span class="bold pull-left">Image Uploaded At :</span>
													<span class="pull-right value_custom_detail_page">`;
													if(value.primary_thumbnail){
														html += value.primary_thumbnail.created_at;
													}else{
														html += 'NULL';
													}
													html += `</span>
												</div>
												<div class="list-group-item col-md-12 clearfix m-b-5">		
													<span class="bold pull-left">Location updated At :</span>
													<span class="pull-right">
														 <span class="color-normal">No Idea</span>
													</span>
												</div>
											</div>
											<div style="border-left:1px solid #e6e6e6;height:auto" class="m-b-10 m-l-15"></div>
											<div class="col-md-3">
												<b>Package Image</b>
												<img src="`;
												if(value.primary_thumbnail){
													html += value.primary_thumbnail.image_name;
												}
												html += `" class="img-fluid m-t-10 img-thumbnail">
											</div>
											<div style="border-left:1px solid #e6e6e6;height:auto" class="m-b-10 m-l-15"></div>
											<div class="col-md-4">
												<b>Package Custom Value</b>
												 <div class="row m-t-10 m-l-5">
												 	 `;
												  
												 	if(value.package_custom_detail.length > 0){
												 		html += `<table class="table table-hover">
															<tbody>`;
															$.each(value.package_custom_detail,function(k,ite){
																html += `<tr>
																<td class="font-montserrat all-caps fs-12 w-50">Item</td>
																<td class="font-montserrat all-caps fs-12 w-50"><b>Category:</b> `+ite.category.title+`</td>
																 <td class="w-25">
																<span class="font-montserrat fs-18"><b>Qty:</b> `+ite.quantity+`</span>
																</td>
																<td class="w-25">
																<span class="font-montserrat fs-18"><b>Value:</b> $`+ite.value+`</span>
																</td>
															</tr>`;
															sum = parseFloat(ite.value)+parseFloat(sum);
															});
															
														html += `</tbody>
														</table>
														<div class="row m-t-20"><div class="col-md-12 p-l-15 sm-p-t-15  clearfix sm-p-b-15 d-flex flex-column justify-content-center pull-left"><h5 class="font-montserrat pull-right all-caps small no-margin hint-text bold">Total</h5> <h3 class="no-margin pull-right outgoing_total_custom">USD $`+sum+`</h3></div></div>
														`;
												 	}else{
												 		html += `<div class="list-group-item col-md-12 clearfix m-b-5">		
															<span class="pull-left">No Any Custom Value...</span>
														</div>`;
												 	}
														
														html += `</div>
												  
											</div>
											<div class="col-md-12">
												<hr width="100%"  />
											</div>
											<div class="col-md-4 m-l-10 m-b-10">
												<b>Paid Services </b>
												<div class="clearfix"></div>
												<div class="btn-group btn-group-justified row w-100 m-t-10 m-l-5 paid_append">
												`;
												if(value.paid_service.length > 0){
												$.each(value.paid_service,function(ind,valuee){
													html += `<div class="btn-group  col-5 p-l-10 m-b-10">
														<button type="button" class="backgroud-clr split_btn btn btn-default w-100 btni'+value.id+'">
														<span class="p-t-5 p-b-5">
																<i class="fa fa-star fs-15"></i>
														</span>
														<br>
														<span class="fs-11 font-montserrat text-uppercase"><b>`+valuee.services.title+`</b></span>
														</button>
														<div class="img-op" data-id="">
														<img src ="<?=asset('images/checked.png') ?>" class="img-fluid" />
														</div>
													</div>`;
												});
											}else{
												html += `<div class="list-group-item col-md-12 clearfix m-b-5">		
															<span class="pull-left">No Any Paid Service selected...</span>
														</div>`;
											}
											html +=`
												
													 
													 

													 
												</div>
											</div>
											<div style="border-left:1px solid #e6e6e6;height:auto" class="m-b-10">
											</div>
											<div class="col-md-4 m-b-10">
												<b>Free Services </b>
														<div class="clearfix"></div>
															`;
														$.each(response.free_ser, function(ind,valu){
															if($.inArray(valu.id,value.free_services) != '-1'){
																	a = 'checked';
																}else{
																	a = '';
																}
															html += `<div class="input-group-prepend ">
															<input type="checkbox" `+a+` name="spec[]" value="" class=" m-t-10 m-r-10"  disabled="">
															<p class="m-b-0 m-t-5">
																`+valu.title+`
															</p>
															</div>`;
														}); 
												
											html += `</div>
											<div style="border-left:1px solid #e6e6e6;height:auto" class="m-b-10"></div>
											<div class="col-md-3">
												<b>Action</b>
												<div class="form-group-default input-group padding-custom m-t-10">
													<div class="input-group-prepend ">
														<span class="input-group-text">
															Package
														</span>
													</div>
													<div class="form-check form-check-inline m-l-15">
													  <input class="form-check-input" value="male" name="gender" id="male" type="radio">
													  <label for="male">Found</label>
													</div>
													<div class="form-check form-check-inline m-l-10">
													  <input class="form-check-input" value="female" style="margin-left: 78px;" name="gender" id="female" type="radio">
													  <label for="female">Missing</label>
													</div>
												</div>
												<div class="form-group-default input-group padding-custom m-t-20">
													<div class="input-group-prepend ">
														<span class="input-group-text">
															Package
														</span>
													</div>
													<div class="form-check form-check-inline m-l-15">
													  <input class="form-check-input" value="male" name="gender" id="male" type="radio">
													  <label for="male">Dangerous goods</label>
													</div>
													<div class="form-check form-check-inline" style="margin-left: 89px;">
													  <input class="form-check-input"  value="female" name="gender" id="female" type="radio">
													  <label for="female">Items remaining</label>
													</div>
												</div>
											</div>
											</div>
										</div>
									</div>`;
			i++;
		});
		$('.custom_package_listing').html(html);
	}
</script>
@endsection