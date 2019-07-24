<div class="modal fade slide-right " id="break_employee_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height text-center "> 
							<div class="row m-t-30">
								<div class="col-md-6 pull-left">
									<h4 class="modal-title pull-left" id="myModalLabel">
										<b>Break Time</b>
									</h4>
								</div>
								<div class="col-md-6 pull-right m-t-10">
								</div>
							</div>
							<hr style="width: 100%" />
							<div class="row m-t-30">
								<div class="col-md-7 offset-md-2">
									<div data-url="upload" class="">
										<div id="card-linear-colors" class="card card-default">
											<div class="card-body p-t-10 p-b-0 p-l-5">
												<div class="col-12 pull-left text-center">
													<img src="http://gs.production/images/break-employee.svg" class="width-100 img-fluid m-r-15">
												</div> 
												<div class="col-md-12 pull-left">
													<h3 class="text-center">
														<b class="m-r-0">Break Time</b>
													</h3>
												</div>
											</div>
										</div>
										</div>


										<div class="row">
											<div class="break_time_model_count col-md-12">
											</div>
											<div class="col-md-7 offset-md-2">
												<button onclick="postBreakTime('{{route('employee.post_break_time')}}','#break_employee_modal','break')" class="btn btn-danger text-center">
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
		var timer_break = 0;
		$('#break_employee_modal').on('shown.bs.modal', function (e) {
			$.get('{{URL::route("employee.get_break_time")}}',{'id':{{Auth::user()->id}}},function(response) {
	           if(response.status == 1){
	            	 off = 0;
					if(localStorage.getItem('upload_window') == 'active'){
					}else{
						localStorage.setItem('count_time', 'type_change');
						//localStorage.setItem('count_time', 15);
						localStorage.setItem('break_time', 'active');
						localStorage.setItem('break_time_count', response.time_start);
					}
					if(localStorage.getItem('break_time_count') < response.time_start){
						console.log(1);
						clock = $('.break_time_model_count').FlipClock(localStorage.getItem('break_time_count'),{
				    		clockFace: 'MinuteCounter',
				    		countdown : true
				    	});
					}else{
						console.log(response.time_start);
						   	clock = $('.break_time_model_count').FlipClock(response.time_start, {
								clockFace: 'MinuteCounter',
								countdown: true
							});
					}
	            }

	        },"json");
			
		    setTimeout(function(){
		    	timer_count(clock);
		    }, 1000);
		});
	});

	// function endBreakTimeTask(){
	// 	off = 1;
	// 	localStorage.setItem('count_time', '');
	// 	localStorage.setItem('upload_window', '');
	// 	localStorage.setItem('task_type', '');
	// 	localStorage.setItem('break_time', '');
	// 	localStorage.setItem('break_time_count', '');
	// 	remainingTimeDashboard();
	// 	$('#break_employee_modal').modal('hide');
	// }
	function postBreakTime(url,id,type){
		var time = localStorage.getItem('break_time_count');
		$.ajax({
	        type: "POST",
	        url: url,
	        data: {'time' : time,'task_type' : type},
	        dataType: "JSON",
	        success: function (response) {
	          if(response.status == 1){          
	            off = 1;
				localStorage.setItem('count_time', '');
				localStorage.setItem('upload_window', '');
				localStorage.setItem('task_type', '');
				localStorage.setItem('break_time', '');
				localStorage.setItem('break_time_count', '');
				remainingTimeDashboard();
				$(id).modal('hide');
				responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
	          }
	          if(response.status == 0){
	          	responseMsg("error",'{{asset('images/error.png')}}');
	          }
	      	},
	      error: function (jqXHR, exception) {
	           
	        }
      	});
	}
	 
	</script>
	@endsection