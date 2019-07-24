<div class="modal fade slide-right " id="outgoing_review_request" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height text-center ">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
							</button>
							<div class="row m-t-30">
								<div class="col-md-6 pull-left">
									<h4 class="modal-title pull-left" id="myModalLabel">
										<b>Review Request</b>
									</h4>
								</div>
							</div>
							 <div class="row m-t-10">
								<div class="col-lg-12 out_review_basic_info">
									
								</div>
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

    	
	    $('#outgoing_review_request').on('shown.bs.modal', function (e) {
    	  var id = $(e.relatedTarget).data('id');
	       $.get('{{route('frontend.consolidate.get_review_request')}}',{'id':id},function(response) {
	          if(response.status == 1){
	          	basicInfo(response);
	          }
	        },"json");
	    });
    });

function basicInfo(response){
	consolidation = response.consolidation;
	var html = ``;
	var a;

	html += `
				<div id="card-linear" class="card card-default">
				<div class="card-header  ">
					<div class="card-title pull-left"><b class="pull-left">Basic Info</b>
					</div>
					<div class="card-controls">
						
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12 p-r-10">
							<div class="row">
								<div class="col-lg-12">
									<p class="pull-left">Request ID:</p>
									<p class="pull-right bold">`+consolidation.unique_key+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<p class="pull-left">Customs & Insurance Value</p>
									<p class="pull-right bold">USD `+response.sum+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<p class="pull-left">Warehouse Location:</p>
									<p class="pull-right bold">`;

										if(consolidation.fetchLocation){
											html += consolidation.fetchLocation.location.name+' - '+consolidation.fetchLocation.location.color;
										}else{
											html += 'NULL';
										}

						html +=`</p>
								</div>
							</div>
							 
							
						</div>
						<div class="col-12 p-r-10">
							
							<div class="row">
								<div class="col-lg-12">
									<p class="pull-left">Number of items:</p>
									<p class="pull-right bold">0`;
								html += `</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<p class="pull-left">Weight (Pounds):</p>
									<p class="pull-right bold">0.00`;

									// if(consolidation.fetchLocation){
									//  html += consolidation.fetchLocation.created_at;
									// }else{
									// 	html += 'NULL';
									// }
								html += `</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<p class="pull-left">Destination Address:</p>
									<p class="bold m-l-5">`+consolidation.address.name+ ', '+ consolidation.address.street +', '+consolidation.address.city+', '+consolidation.address.state+', '+consolidation.address.country+', '+consolidation.address.phone+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<p class="pull-left">Special Request:</p>
									<p class="pull-left bold m-l-5">`+consolidation.special_instructions+`</p>
								</div>
							</div>
						<hr width="100%" />
						<div class="col-md-12">
							<b class="pull-left">ADDITIONAL INFO </b>
							<div class="clearfix"></div>`;
								
							$.each(response.consolidation_request_info,function(key,value){
								if(consolidation.request_infos){
									if($.inArray(value.id, consolidation.request_infos) != -1){
										a = 'checked';
									}else{
										a = '';
									}
								}
								html += `<div class="input-group-prepend ">
								<input type="checkbox"  name="spec[]" value="" `+a+` class=" m-t-10 m-r-10"   disabled="">
									<p class="m-b-0 m-t-5">
										`+value.title+`
									</p>
								</div>`;
							});
							
							
							
						html += `</div>
	
<ul class="ship-steps"><li class="step"><div class="icon-con  icon-current icon-node"><i class="iconfont icon-weicheng"></i></div> <p>
    Accepted by Last Mile Carrier
  </p> <p>
   2019-04-30 02:14:00&nbsp;[GMT+8]
  </p></li><li class="step"><div class="icon-con "><i class="iconfont"></i></div> <p data-spm-anchor-id="a2d0j.7922267.0.i1.78e041410eXKRZ">
    Shipment at local distribution center
  </p> <p>
   2019-04-30 02:14:00&nbsp;[GMT+8]
  </p></li><li class="step"><div class="icon-con "><i class="iconfont"></i></div> <p>
    Departed country of origin
  </p> <p data-spm-anchor-id="a2d0j.7922267.0.i2.78e041410eXKRZ">
   2019-04-22 23:30:00&nbsp;[GMT+8]
  </p></li><li class="step"><div class="icon-con "><i class="iconfont"></i></div> <p>
    Shipment accepted by airline
  </p> <p>
   2019-04-22 11:32:54&nbsp;[GMT+8]
  </p></li><li class="step"><div class="icon-con "><i class="iconfont"></i></div> <p>
    Shipment left country of origin warehouse
  </p> <p>
   2019-04-22 11:32:54&nbsp;[GMT+8]
  </p></li><li class="step"><div class="icon-con "><i class="iconfont"></i></div> <p>
    Shipment at country of origin warehouse
  </p> <p>
   2019-04-21 19:08:51&nbsp;[GMT+8]
  </p></li><li class="step"><div class="icon-con "><i class="iconfont"></i></div> <p>
    Shipment dispatched
  </p> <p data-spm-anchor-id="a2d0j.7922267.0.i0.78e041410eXKRZ">
   2019-04-21 18:38:51&nbsp;[GMT+8]
  </p></li></ul>


						</div>
				</div>
			</div>
			`;
	$('.out_review_basic_info').html(html);
}
</script>
@endsection