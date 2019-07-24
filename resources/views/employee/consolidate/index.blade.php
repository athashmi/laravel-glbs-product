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
										<h3 class="m-t-0"><b class="m-r-0 remaing_time_select">00:00</b></h3>
									 
									</div>

								</div>
							</div>
						</div> 
						<hr width="100%" class="margin-6" />

						<!-----------------   Body ---------------->
						<div class="col-md-12">
							<table class="table table-hover demo-table-search table-responsive-block text-center datatable" id="">
								<thead class="bg-white">
									<tr>
										<th class="color-black"><b>REQ ID</b></th>
										<th class="color-black"><b>Shopaholic</b></th>
										<th class="color-black"><b>Package Count</b></th>
										<th class="color-black"><b>Status</b></th>
										<th class="color-black"><b>Date Submitted</b></th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
						<!-----------------   End Body ------------>
					</div>
				</div>
				<div class="col-md-3 pull-left p-t-20">
					<div class="row">
						<div class="col-lg-12 p-0">
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
									
									 <div  class="clearfix"></div>
									 <div class="row" style="margin-top:20px">
						                 <div class="col-md-12">
						                     <div class="form-group">
						                       <h5 style="text-align:center;color:green;font-weight:700">
						                       	<i class="fa fa-caret-up" aria-hidden="true" style="font-size:20px"></i>+0
						                       </h5>
						                       <h5 style="text-align:center;font-weight:700;margin-top:-7px">
						                       	0
						                       </h5>
						                       <h5 style="text-align:center;font-weight:700;margin-top:-6px">
						                       		Lead Consolidator
						                       	</h5>
						                     </div>
						                 </div>
           							 </div>
									 <div class="clearfix"></div>
									 <div class="col-md-12 m-t-20">
									 	<button class="btn btn-default btn-color btn-border btn-border-gray btn-rounded m-b-10 btn-pull-request"><b>
									 		Pull Request
									 	</b></button>
									 	<button class="btn btn-default btn-color-red btn-border-red btn-rounded m-b-10 m-l-10" data-toggle="modal" data-id=""   id="end_task" data-target="#confirm_model" ><b>
									 		End Task
									 	</b></button>
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
@include('employee.consolidate.confirm-consolidate-model')
@include('revox-theme.js-css-blades.flipclock')
@include('employee.delay-model')
@endsection
@section('script')
@parent
<script type="text/javascript">
	//var start_time_consolidation;

	
	//localStorage.setItem('current_task','consolidation');
$(document).ready(function() {

	localStorage.setItem('start_time_consolidation',getCurrentDateTime());

	//remainingTimeDashboard();
	startCountDown(30);
	//start_time_consolidation = getCurrentDateTime();

	$(".datatable").css('width','100%');
	    var id = 0;
	    var datatbl = $('.datatable').DataTable({
	    processing: true,
	    serverSide: true,
	    ajax: "{{ route('employee.consolidate.get_consolidatie_request') }}",
	    columns: [
	        {data: 'request_id',orderable: false, searchable: false,"className": "text-center"},
	        {data: 'name',"className": "text-center"},
	        {data: 'no_of_pkgs',"className": "text-center"},
	        {data: 'status',"className": "text-center"},
	        {data: 'created_at',"className": "text-center"}
	    ],
	    order: [[ 1, "asc" ]]
	    });

	    $("div.dataTables_length").parent().css({"flex-direction": "row"});
	    $("div.dataTables_info").parent().css({"flex-direction": "row"});
		$('.btn-pull-request').click(function(){
			$.ajax({
				type: "POST",
				url: "{{route('employee.consolidate.pull_consolidate_request')}}",
				dataType: "JSON",
				success: function (response) {
					if(response.status == 1){
						datatbl.draw();
					}
				},
				error: function(jqXHR, exception){
					if (jqXHR.status == 422) {
					}
				}
			});
			
		});


		$('#end_task').on('click',function(){

		$.ajax({
		          type: "POST",
		          url: "{{route('employee.consolidate.end_task')}}",
		          data: 'start_time_consolidation='+localStorage.getItem('start_time_consolidation'),
		          dataType: "JSON",
		          success: function (response) {
		            if(response.status == 1)
		            {
		              responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}",response.msg);

		              setTimeout(function(){
		              	window.location.href = '{{route("employee.employee_dashboard")}}';
		              },1000);
		               
		            }
		          }
				});
		});
	
    
});
</script>
@endsection
