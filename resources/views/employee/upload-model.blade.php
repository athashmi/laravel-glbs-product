<div class="modal fade slide-right " id="upload_package_employee" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height text-center "> 
							<div class="row m-t-30">
								<div class="col-md-6 pull-left">
									<h4 class="modal-title pull-left" id="myModalLabel">
										<b>Upload Packages</b>
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
										<div id="card-linear-color" class="card card-default">
											<div class="card-body p-t-10 p-b-0 p-l-5">
												<div class="col-12 pull-left text-center">
													<img src="http://gs.production/images/upload-employee.svg" class="width-100 img-fluid m-r-15">
												</div> 
												<div class="col-md-12 pull-left">
													<h3 class="text-center">
														<b class="m-r-0">Upload</b>
													</h3>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="upload_model_count col-md-12">
										</div>
										<div class="col-md-12">
											<button onclick="endUploadTask()" class="btn btn-danger text-center">
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
		$('#upload_package_employee').on('shown.bs.modal', function (e) {
			off = 0;
			if(localStorage.getItem('upload_window') == 'active'){
			}else{
				localStorage.setItem('count_time', 'type_change');
			}
			if(localStorage.getItem('count_time') > 0){
		    	clock = $('.upload_model_count').FlipClock(localStorage.getItem('count_time'),{
		    		clockFace: 'MinuteCounter',
		    	});
		    }else{
		    	clock = $('.upload_model_count').FlipClock({
		    		clockFace: 'MinuteCounter',
		    	});
		    }

		    setTimeout(function(){
		    	timer_count(clock);
		    }, 1000);
			
		});
	});
	function timer_count(clock){
		if(localStorage.getItem('break_time') == 'active'){
			

			if(localStorage.getItem('break_time_count') == 0){
					alert('Break Time Is Finished :(');
					localStorage.setItem('count_time', '');
					localStorage.setItem('upload_window', '');
					localStorage.setItem('task_type', '');
					localStorage.setItem('break_time', '');
					localStorage.setItem('break_time_count', '');
					remainingTimeDashboard();
					$('#break_employee_modal').modal('hide');
				}else{
					var num = localStorage.getItem('break_time_count');
					if(off == 0){
						localStorage.setItem('upload_window', 'active');
						setTimeout(function(){
					    	timer_count(clock);
					    }, 1000);
					   if(localStorage.getItem('break_time_count') == 0){
						}else{
							localStorage.setItem('break_time_count', parseInt(num)-1);
						}
					}	
				}
		}else{
			var num = localStorage.getItem('count_time');
			if(off == 0){
				localStorage.setItem('upload_window', 'active');
				setTimeout(function(){
			    	timer_count(clock);
			    }, 1000);
				if(num > clock.timer.count){
					localStorage.setItem('count_time', parseInt(num)+1);
				}else{
					localStorage.setItem('count_time', clock.timer.count);
				} 
			}
		}
		
		
	}







	function endUploadTask(){
		$('#confirm_model').modal('show');
		// off = 1;
		// localStorage.setItem('count_time', '');
		// localStorage.setItem('upload_window', '');
		// localStorage.setItem('task_type', '');
		
		// remainingTimeDashboard();
		// $('#upload_package_employee').modal('hide');
	}
	</script>
	@endsection