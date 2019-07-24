@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('edit_employee') }}
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
		Edit Employee
	</h5>
	</div>
	</div>
	<div class="card-body">
		
		<form action="javascript:;" method="post" class="j-pro form-employee-update" id="j-pro" enctype="multipart/form-data" novalidate>
			
			<div class="row">
				<div class="col-md-6">
				<div class="form-group form-group-default">
				<label>First name</label>
				<input type="text" id="first_name" value="{{$employee->user->first_name}}"   class="form-control" name="first_name"  placeholder="First name" required>
				</div>
				</div>
				 <div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Last name</label>
				<input type="text"  id="last_name" value="{{@$employee->user->last_name}}" class="form-control" name="last_name" placeholder="Last name">
				</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Email</label>
				<input type="email"  placeholder="Email" value="{{$employee->user->email}}" class="form-control" id="email" name="email" required>
				</div>
				</div>
				 <div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Phone</label>
				<input type="text" class="form-control" value="{{$employee->user->phone}}"   placeholder="Phone" id="phone" name="phone" required>
				</div>
				</div>
			</div>

			 

			<div class="row">
				<div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Managed By</label>
				 <select name="managed_by" id="managed_by" class="select2 form-control">
                    <option value="" selected>Select managed by</option>
                    @foreach($managers as $manager)
                        <option value="{{$manager->id}}"
                        	{{$employee->managed_by == $manager->id ? 'selected' : ''}}>{{$manager->first_name.' '.$manager->last_name.'('.$manager->roles->first()->name.')'}}</option>
                    @endforeach
			     </select>
				</div>
				</div>
				 <div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Select Role/Position</label>
				<select name="role" class="select2 form-control"> 
	       			 <option value="" selected>Select Role/Position</option>
	               @foreach($roles as $role)
                    <option value="{{$role->id}}"
                    {{@$employee->user->roles->first()->id == $role->id ? 'selected' : ''}}>{{$role->name}}</option>
                @endforeach
    			</select>
				</div>
				</div>
			</div>
			

			<div class="row">
				<div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Date of Birth</label> 
				<input type="text" value="<?php echo date('m/d/Y', strtotime($employee->user->dob)); ?>" autocomplete="off"   class="form-control"  class="date dob_date" id="dob" name="dob_date" required>
				</div>
				</div>
				 <div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Date of Hiring</label> 
				<input type="text" value="<?php echo date('m/d/Y', strtotime($employee->hire_date)); ?>" autocomplete="off" id="hire_date" class="form-control" name="hire_date" required>
				</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Pay type</label> 
				<select name="pay_type" class="select2 form-control" required>
                    <option value="" selected>Pay type</option>
                    @foreach(payTypes() as $key=>$type)
                    <option value="{{$key}}" {{$employee->pay_type == $key ? 'selected' : ''}}>{{$type}}</option> 
                    @endforeach
            	</select>
				</div>
				</div>
				 <div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Pay Rate</label>
				 <input type="text" value="{{$employee->pay_rate}}"  placeholder="" class="form-control" id="pay_rate" name="pay_rate" required>
				</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Vocation Yearly</label>
			      <select name="vocation_yearly" class="select2 form-control">
                    <option value="" selected>Vocation Yearly</option>
                    @for($i =0; $i <=20; $i++)
                    	<option value="{{$i}}" {{$employee->vacation_yearly == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
                </select>
				</div><input type="hidden" name="id" value="{{$employee->user->id}}">
				</div>
				 <div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Sick Leaven</label>
				<select name="sick_leave" class="select2 form-control">
	                    <option value="" selected>Sick leave</option>
	                     @for($i =0; $i <=20; $i++)
                        	<option value="{{$i}}" {{$employee->sick_leave == $i ? 'selected' : ''}}>{{$i}}</option>
                        @endfor
            	</select>
				</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Emergency Contact Name</label> 
				<input type="text" value="{{$employee->emergency_contact_name}}" class="form-control" id="emergency_name" name="emergency_name">
				</div>
				</div>
				 <div class="col-md-6">
				<div class="form-group form-group-default">
				<label>Emergency Contact No</label> 
				<input type="text" value="{{$employee->emergency_contact_phone}}" class="form-control" id="emergency_no" name="emergency_no">
				</div>
				</div>
			</div>


			<div class="form-group  form-group-default">
			<label>Home Address</label>
			<textarea name="address" id="address" class="form-control" placeholder="Home Address">{{$employee->address}}</textarea>
			</div>
			<div class="form-group  form-group-default">
			<label>Choose Image</label> 
            <input type="file" name="files" id="filer_input">
			</div>

			@if(!empty($employee->user->picture))
			<div class="j-span6 j-unit">

				<div class="jFiler-items jFiler-row hide-div">
					<ul class="jFiler-items-list jFiler-items-grid">
						<li class="jFiler-item" data-jfiler-index="1" style="">     <div class="jFiler-item-container">
								<div class="jFiler-item-inner">
									<div class="jFiler-item-thumb">
										<div class="jFiler-item-status"></div>
										{{-- <div class="jFiler-item-info">
											<span class="jFiler-item-title">
												<b title="avatar-4.jpg">avatar-4.jpg</b>
											</span>
											<span class="jFiler-item-others">2.97 KB</span>
										</div> --}}
										<div class="jFiler-item-thumb-image"><img class="img-responsive" src="{{route('img_file',$employee->user->picture)}}" draggable="false"></div>
									</div>
									<div class="jFiler-item-assets jFiler-row">
										{{-- <ul class="list-inline pull-left">
											<li>
												<div class="jFiler-jProgressBar" style="display: none;">
													<div class="bar" style="width: 100%;"></div>
												</div>
												<div class="jFiler-item-others text-error" style=""><i class="icon-jfi-minus-circle"></i> Error</div>
											</li>
										</ul> --}}
										<ul class="list-inline pull-right">
											<li><a href="javascript:void(0)" class="icon-jfi-trash jFiler-item-trash-action fa fa-trash delete-img"></a></li>
										</ul>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<input type="hidden" name="img_del" class="img_del" value="0">
			@endif
			<div class="row">
				
			<div class="col-sm-12">
				<div class="error_msg_e_c"></div>
				<div class="pull-right">
				<button type="submit" class="btn btn-primary btn-employee-add">Update</button>
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
$(".form-employee-update").on('submit',function(e){
e.preventDefault();
var formData = new FormData(this); 
	$.ajax({
          type: "POST",
          url: "{{route('employee.update')}}",
          data:formData,
	      cache:false,
	      contentType: false,
	      processData: false,
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            	responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");
          }
          },
          error: function(jqXHR, exception){

            var html_error = '<div  class="alert " style="background-color:#e67070; color:white;"><ul>';
            $.each(jqXHR.responseJSON.errors, function (key, value)
            {
                html_error +='<li class="padding-top-10">'+value+'</li>';
            })
             html_error += "</ul></div>";
          $('.error_msg_e_c').html(html_error);
          setTimeout(function(){
                $(".error_msg_e_c").html('');
          },5000);
        }
      });
});
$('.delete-img').on('click',function(){
	$(".hide-div").hide();
	$(".img_del").val(1);
});

$(".footer").css("position","relative");
@endsection