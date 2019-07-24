<div class="col-lg-4">
	<div id="card-linear-color" class="card card-default">
		<div class="card-body p-t-10 p-b-0 p-l-5">
			<div class="col-4 pull-left">
				<img src="{{asset('images/employee-work-start.png')}}" class="img-fluid m-r-15"     />
			</div>
			<div class="col-8 pull-left">
				<h6 class="m-b-0">Work Day Start Time</h6>
				<h3 class="m-t-0"><b class="m-r-0">
				{{$work_day_started}}</b></h3>
				
			</div>
		</div>
	</div>
</div>
<div class="col-lg-4">
	<div id="card-linear-color" class="card card-default">
		<div class="card-body p-t-10 p-b-0 p-l-5">
			<div class="col-4 pull-left">
				<img src="{{asset('images/employee-work-rem.png')}}" class="img-fluid m-r-15"     />
			</div>
			<div class="col-8 p-l-0 p-r-0 pull-left">
				<h6 class="m-b-0">Work Day Remaining Time</h6>
				<h3 class="m-t-0 remaining_time "><b class ="clock" id="MyClockDisplay">00:00:00</b></h3>
			</div>
		</div>
	</div>
</div>