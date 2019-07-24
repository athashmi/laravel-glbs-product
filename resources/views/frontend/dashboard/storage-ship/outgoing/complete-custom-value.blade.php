<div class="modal fade slide-right " id="outgoing_complete_custom_value" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height text-center ">
							<div class="row m-t-30">
								<div class="col-md-12 pull-left">
									<h4 class="modal-title pull-left" id="myModalLabel">
									<b>Customs Declaration Value</b>
									</h4>
								</div>
							</div><button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
							</button>
							<div class="row m-t-10">
								<div class="card card-transparent">
									<div class="card-header ">
										<div class="card-title pull-left">
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<div id="" class="no-footer">
												<table class="table table-hover no-footer" id="basicTable" role="grid">
													<thead>
														<tr role="row">
															<th>Item
															</th>
															<th>Quantity
															</th>
															<th >Declared Value
															</th>
														</tr>
													</thead>
													<tbody class="outgoing_custom_all_value">
														
													</tbody>
												</table>
											</div>
										</div>
										<div class="row m-t-20">
											<div class="col-md-4 offset-md-8 p-l-15 sm-p-t-15  clearfix sm-p-b-15 d-flex flex-column justify-content-center">
												<h5 class="font-montserrat pull-right all-caps small no-margin hint-text bold">Total</h5>
												<h3 class="no-margin pull-right outgoing_total_custom"> USD $0.00</h3>
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
</div>
@section('script')
@parent
<script type="text/javascript">
$(document).ready(function(){


	$('#outgoing_complete_custom_value').on('shown.bs.modal', function (e) {
	  var id = $(e.relatedTarget).data('id');
	   $.get('{{route('frontend.consolidate.get_all_custom_value')}}',{'id':id},function(response) {
	      if(response.status == 1){
	      	renderCustomValueOutgoing(response);
	      }
	    },"json");
	});

});

function renderCustomValueOutgoing(response){
	var html = ``;
	var flag = 0;
	var total = 0.00;
	$.each(response.packages,function(index,value){
		if(value.package_custom_detail.length > 0){
			$.each(value.package_custom_detail,function(i,valu){
				html += `<tr role="row" class="odd">
					<td>
						<p>`+valu.category.title+`</p>
					</td>
					<td>
						<p>`+valu.quantity+`</p>
					</td>
					<td>
						<p>`+valu.value+`</p>
					</td>
				</tr>`;
				total = (parseFloat(valu.value) * parseFloat(valu.quantity)) + parseFloat(total);
				flag = 1;
			}); 
		}

		if(parseInt(total) == 0 || (total) < 0){
			html = `<tr role="row" class="odd">
					<td colspan="3">
						<p>No Any Custom Value Found...</p>
					</td>
				</tr>`;
		}
	});
	$('.outgoing_custom_all_value').html(html);
	$('.outgoing_total_custom').html('USD $'+parseFloat(total).toFixed(2));
}
</script>
@endsection