@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			<div class="inner">
				{{ Breadcrumbs::render('add_employee') }}
			</div>
		</div>
	</div>
	<div class=" container-fluid   container-fixed-lg bg-white">
		<div class="card card-transparent">
			<div class="card-header ">
				<div class="card-title">
				</div>
				
				
				<div class="clearfix"></div>
			</div>
			<div class=" container-fluid   container-fixed-lg">
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-default">
							<div class="card-header ">
								<div class="card-title">
									<h5>
									Add Employee
									</h5>
								</div>
							</div>
							<div class="card-body">
								
								<form action="{{route('employee.store')}}" method="post" class="j-pro form-employee-add"  enctype="multipart/form-data" novalidate role="form">
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>First name</label>
												<input type="text" id="first_name" class="form-control" name="first_name"  placeholder="First name" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Last name</label>
												<input type="text"  id="last_name" class="form-control" name="last_name" placeholder="Last name">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Email</label>
												<input type="email"  placeholder="Email" class="form-control" id="email" name="email" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Phone</label>
												<input type="text" class="form-control"  placeholder="Phone" id="phone" name="phone" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Password</label>
												<input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Password Confirmation</label>
												<input type="password" placeholder="Password Confirmation" class="form-control" id="password" name="password_confirmation">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Managed By</label>
												<select name="managed_by" id="managed_by" class="select2 form-control">
													<option value="" selected>Select managed by</option>
													@foreach($managers as $manager)
													<option value="{{$manager->id}}">{{$manager->first_name.' '.$manager->last_name.'('.$manager->roles->first()->name.')'}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2" >
												<label>Select Role/Position</label>
												<select name="role" class="select2 form-control ">
													<option value="" selected>Select Role/Position</option>
													@foreach($roles as $role)
													<option value="{{$role->id}}">{{$role->name}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Date of Birth</label>
												<input type="text" autocomplete="off"   class="form-control"  class="date dob_date" id="dob" name="dob_date" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Date of Hiring</label>
												<input type="text" autocomplete="off" id="hire_date" class="form-control" name="hire_date" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Pay type</label>
												<select name="pay_type" class="select2 form-control" required>
													<option value="" selected>Pay type</option>
													@foreach(payTypes() as $key=>$type)
													<option value="{{$key}}">{{$type}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Pay Rate</label>
												<input type="text" placeholder="" class="form-control" id="pay_rate" name="pay_rate" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Vocation Yearly</label>
												<select name="vocation_yearly" class="select2 form-control">
													<option value="" selected>Vocation Yearly</option>
													@for($i =0; $i <=20; $i++)
													<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Sick Leaven</label>
												<select name="sick_leave" class="select2 form-control">
													<option value="" selected>Sick leave</option>
													@for($i =0; $i <=20; $i++)
													<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Emergency Contact Name</label>
												<input type="text" class="form-control" id="emergency_name" name="emergency_name">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Emergency Contact No</label>
												<input type="text" class="form-control" id="emergency_no" name="emergency_no">
											</div>
										</div>
									</div>
									<div class="form-group  form-group-default">
										<label>Home Address</label>
										<textarea name="address" id="address" class="form-control" placeholder="Home Address"></textarea>
									</div>
									<div class="form-group  form-group-default">
										<label>Choose Image</label>
										<input type="file" name="files" id="filer_input">
									</div>
									<div class="row">
										
										<div class="col-sm-12">
											<div class="error_msg_e_c"></div>
											<div class="pull-right">
												<button type="submit" class="btn btn-primary btn-employee-add">Send</button>
												<button type="reset" class="btn btn-default m-r-20">Reset</button>
											</div>
										</div>
									</div>
								</form>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	@include('revox-theme.js-css-blades.datatables')
	@include('revox-theme.js-css-blades.select2')
	@include('revox-theme.js-css-blades.datepicker')
	@include('revox-theme.js-css-blades.image-upload')
	
	@endsection
	@section('script')
	@parent
	@endsection
	@section('document_ready')
	@parent

$('.select2').select2();
$('#hire_date, #dob').datepicker();

$(".form-employee-add").on('submit',function(e){
e.preventDefault();
var formData = new FormData(this);
	$.ajax({
          type: "POST",
          url: "{{route('employee.store')}}",
          data:formData,
	      cache:false,
	      contentType: false,
	      processData: false,
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            	responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
          }
          },
          error: function(jqXHR, exception){
			if (jqXHR.status == 422) {
			
              var html_error = '';
              $.each(jqXHR.responseJSON.errors, function (key, value)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
              })
              html_error += "</ul></div>";
              $('.error_msg_e_c').html(html_error);
               
              $(".alert ").css("max-width","none");
            }
        }
      });
});
$(".footer").css("position","relative");

@endsection

