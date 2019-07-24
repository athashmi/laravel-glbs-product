<div class="modal fade slide-right " id="package_services_charges_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height text-center "> 
							<div class="row m-t-30">
								<div class="col-md-6 pull-left">
									<h4 class="modal-title pull-left" id="myModalLabel">
										<b>Charges Details</b>
									</h4>
								</div>
							</div>

							<hr style="width: 100%" />
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
							</button>
							@php $i =1; $rate = 0; @endphp
							@foreach($consolidation->packages as $package)
							@php $sub_rate = 0; @endphp
								<h5 class="pull-left col-md-12"><b class="pull-left">Package {{$i}}</b></h5>
								<div class="">
									<table class="table table-hover demo-table-search table-responsive-block dataTable no-footer">
										<thead>
											<tr>
												<th>Services</th>
												<th>Rate</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											@foreach($package->paidService as $key=>$service_req)
												<tr>
													<td>{{$service_req->services->title}}</td>
													<td>$ {{$service_req->services->amount}}</td>
													<td>$ {{$service_req->services->amount}}</td>
												</tr>
												@php
													$sub_rate = (float)$service_req->services->amount + (float)$sub_rate;
											 	@endphp
											@endforeach
											@php
												$rate = (float)$rate + (float)$sub_rate;
													//echo $rate;
											@endphp
										</tbody>
									</table>
								</div>
								@php $i++; @endphp
								<div class="col-md-4 pull-right m-t-20">
									<h5 class="font-montserrat all-caps small no-margin hint-text bold">
										Total
									</h5>
									<h3 class="no-margin">
										$ {{$sub_rate}}
									</h3>
								</div>
							@endforeach
							<div class="clearfix"></div>
							<div class="col-12 border-all m-t-30 p-r-0">
								<div class="col-2 pull-left m-t-20">
									<h3 class="no-margin">
										Total
									</h3>
								</div>
								<div class="col-4 offset-8 p-t-20 p-b-30 bg-color-black">
									<h3 class="no-margin color-white">
										$ {{$rate}}
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>