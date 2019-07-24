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
						<!-----------------   Body ---------------->
						<hr width="100%" class="margin-6" />
						<div class="col-md-12">
							<table class="table table-responsive-block text-center datatable" id="" style="width:100%">
								<thead class="bg-white">
									<tr>
										<th class="color-black"><b>Location</b></th>
										<th class="color-black"><b>Image</b></th>
										<th class="color-black"><b>Tracking #</b></th>
										<th class="color-black"><b>Action</b></th>
									</tr>
								</thead>
								<tbody>
									@if($packages)
										@foreach($packages as $package)
										<tr class="">
											<td class="text-center"><b>{{$package['warehouse_loc']}}</b></td>
											<td class="text-center"><img class="img-thumbnail" src="{{$package['image']}}"></td>
											<td class="text-center word-break">{{$package['tracking_no']}}</td>
											<td class="text-left">
												@php
												$cart_colors = ['red'=>'picked','blue'=>'picked','yellow'=>'picked','orange'=>'picked','green'=>'picked','missing'=>'missing'];
												@endphp

												@foreach($cart_colors as $cart_section=>$status)
												<div class="radio radio-primary">
													<input type="radio" class="cart_loc" value="{{$cart_section}}" name="cart_location" id="{{$cart_section}}" data-status="{{$status}}" data-pkg_id="{{$package['id']}}" data-color="{{$cart_section}}">
													<label for="{{$cart_section}}">{{ucfirst($cart_section)}}</label>
												</div>
												@endforeach
												
											</td>
										</tr>
										@endforeach
									
									@endif
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
									 <form action="{{route('employee.pickup.pick_packages')}}" method="post">
									 	@csrf
									 <div class="col-md-12">
									 	<h4><b>Select Rows</b></h4>
									 	<div class="clearfix"></div>

									 	@foreach(range('a','l') as $i)
									 	<div class="col-4 pull-left checkbox  checkbox-circle check-primary ">
									 		<input type="checkbox" name="racks[]" class="rows" id="{{$i}}" value="{{strtoupper($i)}}" 
									 		@if(is_array(old("racks")) && in_array(strtoupper($i), old('racks'))) checked @endif>
									 		 <label for="{{$i}}"> {{strtoupper($i)}}</label>
									 	</div>
									 	@endforeach
									 </div>
									 <div  class="clearfix"></div>
									 
									 <div class="col-md-12">
									 	<h4><b>Select Cart</b></h4>
									 	<div class="col-md-12 pull-left">
									 		<select class="form-control full-width" name="cart_loc" id='cart_loc'>
									 			<option value="cart1">Cart1</option>
									 			<option value="cart2">Cart2</option>
									 			<option value="cart3">Cart3</option>
									 			<option value="cart4">Cart4</option>
									 		</select>
									 	</div>
									 </div>
									 <div class="clearfix"></div>
									 <div class="col-md-12 m-t-20">
									 	<button class="btn btn-default btn-color btn-border btn-rounded m-b-10">Begin Pickup</button>
									 	<button class="btn btn-default btn-color btn-border btn-rounded m-b-10 m-l-10">First Pickup</button>
									 	<input type="text" name="cart_input" class="form-control col-5 pull-left btn-border-black m-b-10">
									 	<button class="btn btn-default btn-color btn-border btn-rounded m-b-10 m-l-10">Special Pickup</button>
									 </div>
									 <hr/>
									 
									</form>
									@if(Request::isMethod('post'))
									 <div class="col-md-12 m-t-20">
									 	<button class="btn btn-danger text-center" id="end_task">End Task</button>
									 </div>
									 @endif
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
@include('revox-theme.js-css-blades.sweetalert')
@include('employee.delay-model')
@include('revox-theme.js-css-blades.flipclock')
@endsection

@section('style')
.checkbox+.checkbox, .radio+.radio {
     margin-top: 0px; 
}
.radio, .checkbox {
    
    margin-top: 0px; 
   
}
@endsection
@section('script')
@parent
<script type="text/javascript">
	var start_time_picking = '';
$(document).ready(function() {

@php
    if(Request::isMethod('post')):
@endphp
	countTime();
	start_time_picking = getCurrentDateTime();

@php
	else:

@endphp
	startCountDown(30);
@php 
	endif;
@endphp



$('#end_task').on('click',function(){

	$.ajax({
          type: "POST",
          url: "{{route('employee.pickup.end_task')}}",
          data: 'start_time='+start_time_picking,
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
	

//remainingTimeDashboard();

	$(".datatable").css('width','100%');
	    var id = 0;

	    var datatbl = $('.datatable').DataTable({
	     "ordering": false,
         "pageLength" : 1,
         "bLengthChange": false,
         "bFilter": false,
	   
	   });
	    

	    $("div.dataTables_length").parent().css({"flex-direction": "row"});
	    $("div.dataTables_info").parent().css({"flex-direction": "row"});

		$(".datatable").on('click','.cart_loc',function(){
			
			$(this).parent().parent().css("background-color",$(this).data('color'));

			$(this).parent().parent().siblings().css("background-color",$(this).data('color'));

			if($(this).data('color') =='yellow' || $(this).data('color') =='orange' || $(this).data('color') =='missing')
			{
				$(this).parent().parent().siblings().css("color",'black');
				$(this).parent().parent().css("color",'black');
			}
			else
			{
				$(this).parent().parent().siblings().css("color",'white');
				$(this).parent().parent().css("color",'white');
			}

			if($(this).data('status') =='missing'){
				$(this).parent().parent().css("background-color",'white');
			$(this).parent().parent().siblings().css("background-color",'white');
			}

			$.ajax({
		          type: "POST",
		          url: "{{route('employee.pickup.package_status_update')}}",
		          data: 'status='+$(this).data('status')+'&cart_section_color='+$(this).data('color')+'&package_id='+$(this).data('pkg_id')+'&cart='+$('#cart_loc').val(),
		          dataType: "JSON",
		          success: function (response) {
		            if(response.status == 1)
		            {
		              responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}",response.msg);
		               
		            }
		          }
  			});

		});
    
});
</script>
@endsection