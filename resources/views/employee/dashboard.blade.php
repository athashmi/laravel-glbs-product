@extends('employee.layout')
@section('content')
<div class="content">
	<div class=" container-fluid   container-fixed-lg p-0 ">
		<div class="card card-transparent p-0">
			<div class="card-body p-0">
				<div class="col-md-9 p-t-20 pull-left">
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
						<!-----------------   Body ---------------->

						<div class="col-lg-4 " data-url = "http:\\Upload.URL" data-type = "upload">
							<div id="card-linear-color" class="card card-default employee-task">
								<div class="card-body p-t-10 p-b-0 p-l-5">
									<div class="col-12 pull-left text-center">
										<img src="{{asset('images/upload-employee.svg')}}" class="width-100 img-fluid m-r-15"     />
									</div>
									<div class="col-md-12 pull-left">
										<h3 class="text-center"><b class="m-r-0">Upload</b></h3>
									 
									</div>

								</div>
							</div>
						</div>
						<div class="col-lg-4 " data-url = "http:\\Pick.URL"  data-type = "pick">
							<div id="card-linear-color" class="card card-default employee-task"><a href="{{route('employee.pickup.index')}}">
								<div class="card-body p-t-10 p-b-0 p-l-5">
									<div class="col-12 pull-left text-center">
										<img src="{{asset('images/pick-employee.svg')}}" class="width-100 img-fluid m-r-15"     />
									</div>
									<div class="col-md-12 p-l-0 p-r-0 pull-left">
										<h3 class="text-center"><b>Pick</b></h3>
									</div>

								</div></a>
							</div>
						</div>
						<div class="col-lg-4 " data-url = "http:\\Consolidate.URL" data-type = "consolidation">
							<div id="card-linear-color" class="card card-default employee-task">
								<a href="{{route('employee.consolidate.index')}}">
									<div class="card-body p-t-10 p-b-0 p-l-5">
										<div class="col-12 pull-left text-center">
											<img src="{{asset('images/consolidate-employee.svg')}}" class="width-100 img-fluid m-r-15"     />
										</div>
										<div class="col-md-12 p-l-0 p-r-0 pull-left">
											<h3 class="text-center">
												<b class="m-r-0">Consolidate</b>
											</h3>
										</div>
									</div>
								</a>
							</div>
						</div>
						<div class="col-lg-4 " data-url = "http:\\Outgoing.URL" data-type = "outgoing">
							<div id="card-linear-color" class="card card-default employee-task">
								<div class="card-body p-t-10 p-b-0 p-l-5">
									<div class="col-12 pull-left text-center">
										<img src="{{asset('images/outgoing-employee.svg')}}" class="width-100 img-fluid m-r-15"     />
									</div>
									<div class="col-md-12 pull-left">
										<h3 class="text-center"><b class="m-r-0">Outgoing</b></h3>
									 
									</div>

								</div>
							</div>
						</div>
						<div class="col-lg-4 " data-url = "http:\\Support.URL" data-type = "support">
							<div id="card-linear-color" class="card card-default employee-task">
								<div class="card-body p-t-10 p-b-0 p-l-5">
									<div class="col-12 pull-left text-center">
										<img src="{{asset('images/support-employee.svg')}}" class="width-100 img-fluid m-r-15"     />
									</div>
									<div class="col-md-12 p-l-0 p-r-0 pull-left">
										<h3 class="text-center"><b>Support</b></h3>
									</div>

								</div>
							</div>
						</div>
						<div class="col-lg-4 " data-url = "http:\\CleanUp.URL" data-type = "cleanUp">
							<div id="card-linear-color" class="card card-default employee-task">
								<div class="card-body p-t-10 p-b-0 p-l-5">
									<div class="col-12 pull-left text-center">
										<img src="{{asset('images/clean-employee.svg')}}" class="width-100 img-fluid m-r-15"     />
									</div>
									<div class="col-md-12 p-l-0 p-r-0 pull-left">
										<h3 class="text-center"><b class="m-r-0">CleanUp</b></h3>
									 
									</div>

								</div>
							</div>
						</div> 


						<div class="col-lg-4 " data-url = "http:\\Bathroom.URL" data-type = "bathroom">
							<div id="card-linear-color" class="card card-default employee-task">
								<div class="card-body p-t-10 p-b-0 p-l-5">
									<div class="col-12 pull-left text-center">
										<img src="{{asset('images/bathroom-employee.svg')}}" class="width-100 img-fluid m-r-15"     />
									</div>
									<div class="col-md-12 pull-left">
										<h3 class="text-center"><b class="m-r-0">Bathroom</b></h3>
									 
									</div>

								</div>
							</div>
						</div>
						<div class="col-lg-4 " data-url = "http:\\Break.URL" data-type = "break">
							<div id="card-linear-color" class="card card-default employee-task">
								<div class="card-body p-t-10 p-b-0 p-l-5">
									<div class="col-12 pull-left text-center">
										<img src="{{asset('images/break-employee.svg')}}" class="width-100 img-fluid m-r-15"     />
									</div>
									<div class="col-md-12 p-l-0 p-r-0 pull-left">
										<h3 class="text-center"><b>Break</b></h3>
									</div>

								</div>
							</div>
						</div>
						<div class="col-lg-4 " data-url = "http:\\EndOfWork.URL" data-type = "EndOfWork">
							<div id="card-linear-color" class="card card-default employee-task">
								<div class="card-body p-t-10 p-b-0 p-l-5">
									<div class="col-12 pull-left text-center">
										<img src="{{asset('images/endworday-employee.svg')}}" class="width-100 img-fluid m-r-15"     />
									</div>
									<div class="col-md-12 p-l-0 p-r-0 pull-left">
										<h3 class="text-center"><b class="m-r-0">End Of Work</b></h3>
									 
									</div>
									<form id="end_of_day_form" action="{{route('employee.end_of_day')}}" method="POST" style="display: none;">
								            <input type="hidden" name="_token" value="{{csrf_token()}}">
								            
								    </form>

								</div>
							</div>
						</div> 

						<!-----------------   End Body ------------>
					</div>
				</div>
				<div class="col-md-3 pull-left">
					<div class="row">
						<div class="col-lg-12 p-t-20">
							<div id="card-linear-color" class="card border-0 card-default p-0">
								<div class="card-header  "> 
									<h4 class="text-center"><b>Your statistic</b></h4>
									 
								</div>
								<div class="card-body  ">
									 <div class="col-md-12">
						                <h5>Today's Consolidation  <span>4/18</span></h5>
						                <div class="progress" style="height:13px;">
						                  <div class="progress-bar" style="width:22.222222222222%;background:#2BC1ED"></div>
						                </div>
						                <h5 >Attendance - Missed Days  May<span>1/4</span></h5>
						                <div class="progress" style="height:13px">
						                  <div class="progress-bar" style="width:25%;background:#DB4B3E"></div>
						                </div>
						                <h5>Hours Earned</h5>
						                <div class="progress" style="height:13px">
						                  <div class="progress-bar" style="width:40%;background:#0E9E4C"></div>
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
@include('employee.upload-model')
@include('employee.support-modal')
@include('employee.delay-model')
@include('employee.bathroom')
@include('employee.break-model')
@include('employee.confirm-model')
@include('employee.clean_up-model')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.flipclock')
@endsection
@section('script')
@parent
<script type="text/javascript">
	var count;
	var upload_w = 0;
	var secs;
	var delay_time = 30;

	var delay_start_time ;
	if(localStorage.getItem('count_time') > 0){
	}else{
		count = 0;
	}

	
	
	$(document).ready(function(){
		

		if(localStorage.getItem('count_time') == null){
			localStorage.setItem('count_time', '');
			remainingTimeDashboard();
		}
		remainingTimeDashboard();

		localStorage.setItem('delay_time', 30);
		if(localStorage.getItem('delay_start_time') == null)
			localStorage.setItem('delay_start_time',getCurrentDateTime());

		localStorage.setItem('delay_time', 30);

		//localStorage.setItem('count_time', 0);
		



		$('.employee-task').hover(function(){
			$('.employee-task').removeClass('border-employee-task');
			$(this).addClass('border-employee-task');
		},function(){
			$(this).removeClass('border-employee-task');
		});

		$('.employee-task').click(function(){
			var type = $(this).parent().data('type');
			if(type == 'upload'){
				$('#upload_package_employee').modal({
					backdrop: 'static',
    				keyboard: false,
				});
			}
			if(type == 'support'){
				$('#support_employee_modal').modal({
					backdrop: 'static',
    				keyboard: false,
				});
			}
			if(type == 'bathroom'){
				$('#bathroom_employee_modal').modal({
					backdrop: 'static',
    				keyboard: false,
				});
			}
			if(type == 'cleanUp'){
				$('#clean_up_employee_modal').modal({
					backdrop: 'static',
    				keyboard: false,
				});
			}
			if(type == 'break'){
				$('#break_employee_modal').modal({
					backdrop: 'static',
    				keyboard: false,
				});
			}

			if(type == 'EndOfWork'){
				$('#end_of_day_form').submit();
			}
			localStorage.setItem('task_type', type);
			upload_w = 1
			//alert(localStorage.getItem('task_type'));
		});

		if(localStorage.getItem('task_type') == ''){
			remainingTimeDashboard();
		}

 		
	});


	

	function postTaskUpload(url,id,type){
		var time = localStorage.getItem('count_time');
		$.ajax({
	        type: "POST",
	        url: url,
	        data: {'time' : time,'task_type' : type,'data' : $("input[name='radion_agree']:checked").val()},
	        dataType: "JSON",
	        success: function (response) {
	          if(response.status == 1){          
	            off = 1;
				localStorage.setItem('count_time', '');
				localStorage.setItem('upload_window', '');
				localStorage.setItem('task_type', '');
				remainingTimeDashboard();
				$(id).modal('hide');
				responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
				$('#confirm_model').modal('hide');
	          }
	      	},
	      error: function (jqXHR, exception) {
	           
	        }
      	});
	}

	function postTaskDetail(url,id,type){
		var time = localStorage.getItem('count_time');
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
				remainingTimeDashboard();
				$(id).modal('hide');
				responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
	          }
	          if(response.status == 0){
	          	responseMsg("error","{{asset('images/error.png')}}");
	          }
	      	},
	      error: function (jqXHR, exception) {
	           
	        }
      	});
	}
	


</script>
@endsection