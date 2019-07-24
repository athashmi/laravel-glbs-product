<div class="modal fade slide-right " id="bathroom_employee_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height text-center "> 
							<div class="row m-t-30">
								<div class="col-md-6 pull-left">
									<h4 class="modal-title pull-left" id="myModalLabel">
										<b>Bathroom</b>
									</h4>
								</div>
								<div class="col-md-6 pull-right m-t-10">
								</div>
							</div>
							<hr style="width: 100%" />
							{{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
							</button> --}}
							<div class="row m-t-30">
								<div class="col-md-7 offset-md-2">
									<div data-url="upload" class="">
										<div id="card-linear-colors" class="card card-default">
											<div class="card-body p-t-10 p-b-0 p-l-5">
												<div class="col-12 pull-left text-center">
													<img src="http://gs.production/images/bathroom-employee.svg" class="width-100 img-fluid m-r-15">
												</div> 
												<div class="col-md-12 pull-left">
													<h3 class="text-center">
														<b class="m-r-0">Bathroom</b>
													</h3>
												</div>
											</div>
										</div>
										</div>


										<div class="row">
											<div class="bathroom_model_count col-md-12">
											</div>
											<div class="col-md-7 offset-md-2">
												<button onclick="postTaskDetail('{{route('employee.taskgeneral')}}','#bathroom_employee_modal','bathroom')" class="btn btn-danger text-center">
												 	End Task
												</button>
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
	var off = 0;
	$(document).ready(function(){
		var clock;
		$('#bathroom_employee_modal').on('shown.bs.modal', function (e) {
			off = 0;
			if(localStorage.getItem('upload_window') == 'active'){
			}else{
				localStorage.setItem('count_time', 'type_change');
			}
			if(localStorage.getItem('count_time') > 0){
		    	clock = $('.bathroom_model_count').FlipClock(localStorage.getItem('count_time'),{
		    		clockFace: 'MinuteCounter',
		    	});
		    }else{
		    	clock = $('.bathroom_model_count').FlipClock({
		    		clockFace: 'MinuteCounter',
		    	});
		    }

		    setTimeout(function(){
		    	timer_count(clock);
		    }, 1000);
		});
	});

	function endBankTask(){
		off = 1;
		localStorage.setItem('count_time', '');
		localStorage.setItem('upload_window', '');
		localStorage.setItem('task_type', '');
		remainingTimeDashboard();
		$('#bathroom_employee_modal').modal('hide');
	}
	</script>
	@endsection