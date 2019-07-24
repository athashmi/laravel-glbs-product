@extends('layout.main')
@section('content')
<!-- Page-header start -->
<div class="col-md-12">
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Basic Form Inputs</h4>
                    <span>Lorem ipsum dolor sit <code>amet</code>, consectetur adipisicing elit</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Form Components</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Form Components</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div> 
<form action="{{route('employee.store')}}" method="post" class="j-pro form-employee-add" id="" enctype="multipart/form-data" novalidate style="border:none; background-color: white;">
	@csrf
            <div class="container">
                <!-- start name -->
                <div class="row">
	                <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
	                    <label class="j-label">First Name</label>
	                    <div class="j-input">
	                        <label class="j-icon-left" for="first_name">
	                            <i class="icofont icofont-ui-user"></i>
	                        </label>
	                        <input type="text" id="e_first_name" name="e_first_name" class="{{ $errors->has('e_first_name') ? ' is-invalid' : '' }}" placeholder="">
	                    </div>
	                    @if ($errors->has('e_first_name'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('e_first_name') }}</strong>
	                            </span>
	                 @endif
	                </div>
	                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	                    <label class="j-label">Last Name</label>
	                    <div class="j-input">
	                        <label class="j-icon-left" for="last_name">
	                            <i class="icofont icofont-ui-user"></i>
	                        </label>
	                        <input type="text" id="e_last_name" name="e_last_name" class="{{ $errors->has('e_last_name') ? ' is-invalid' : '' }}" placeholder="">
	                    </div>
	                    @if ($errors->has('e_last_name'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('e_last_name') }}</strong>
	                            </span>
	                 @endif
	                </div>
            	</div>
            	<div class="row">
	                <div class="col-sm-5 col-md-5 col-lg-5 col-xs-12">
	                     <label class="j-label">Email</label>
	                    <div class="j-input">
	                        <label class="j-icon-left" for="email">
	                            <i class="icofont icofont-envelope"></i>
	                        </label>
	                        <input type="email" class="{{ $errors->has('e_last_name') ? ' is-invalid' : '' }}" placeholder="" id="e_email" name="e_email">
	                    </div>
	                    @if ($errors->has('e_email'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('e_email') }}</strong>
	                            </span>
	                 @endif
	                </div>
	                <div class="col-sm-5 col-md-5 col-lg-5 col-xs-12">
	                    <label class="j-label">Phone No</label>
	                    <div class="j-input">
	                        <label class="j-icon-left" for="phone">
	                            <i class="icofont icofont-phone"></i>
	                        </label>
	                        <input type="text" class="{{ $errors->has('e_phone') ? ' is-invalid' : '' }}" placeholder="" id="e_phone" name="e_phone">
	                    </div>
	                    @if ($errors->has('e_phone'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('e_phone') }}</strong>
	                            </span>
	                 @endif
	                </div>
            	</div>
            	<div class="row">
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Password</label>
	                    <div class="j-input">
	                        <label class="j-icon-left" for="email">
	                            <i class="icofont icofont-lock"></i>
	                        </label>
	                        <input type="password" class="{{ $errors->has('e_phone') ? ' is-invalid' : '' }}" placeholder="" id="e_password" name="e_password">
	                    </div>
	                    @if ($errors->has('e_password'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('e_password') }}</strong>
	                            </span>
	                 @endif
	                </div>
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Re-Password</label>
	                    <div class="j-input">
	                        <label class="j-icon-left" for="email">
	                            <i class="icofont icofont-lock"></i>
	                        </label>
	                        <input type="password" placeholder="" id="r_e_password" name="password_confirmation">
	                    </div>
	                </div>
            	</div>
            	<div class="row">
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Managed By</label>
	                    <label class="j-input">
	                        <select name="managed_by">
	                            <option value="" selected>Select managed by</option>
	                            <option value="Australia">Australia</option>
	                            <option value="Austria">Austria</option>
	                        </select>
	                        <i></i>
	                    </label>
	                </div>
	                  <div class="j-span6 j-unit">
	                    <label class="j-label">Role/Position</label>
	                    <label class="j-input">
	                        <select name="role">
	                            <option value="" selected>Select Role/Position</option>
	                            @foreach($roles as $role)
	                                <option value="{{$role->id}}">{{$role->name}}</option>
	                            @endforeach
	                        </select>
	                        <i></i>
	                    </label>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Date of Birth</label>
	                        <div class="j-input">
	                        <label class="j-icon-left" for="dob_date">
	                        <i class="icofont icofont-ui-calendar"></i>
	                        </label>
	                        <input type="text" class="date" id="dob_date"  name="dob_date" readonly="">
	               		 </div>
	           		 </div>
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Date of Hiring</label>
	                    <div class="j-input">
	                        <label class="j-icon-left" for="hire_date">
	                            <i class="icofont icofont-ui-calendar"></i>
	                          </label>
	                            <input type="text"  class="date" id="hire_date" name="hire_date" readonly="">
	                    </div>
	                </div>
            </div>
                <div class="row">
	                
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Pay Type</label>
	                    <label class="j-input">
	                        <select name="pay_type">
	                            <option value="" selected>Pay type</option>
	                            <option value="Australia">Hourly</option>
	                            <option value="Austria">monthly</option>
	                            <option value="Austria">contract</option>
	                        </select>
	                        <i></i>
	                    </label>
	                </div>
            	</div>
            	<div class="row">
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Pay Rate</label>
	                        <div class="j-input">
	                            <label class="j-icon-left" for="phone">
	                                <i class="icofont icofont-phone"></i>
	                            </label>
	                            <input type="text" placeholder="" id="pay_rate" name="pay_rate">
	                        </div>
	                </div>
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Vocation yearly</label>
	                    <label class="j-input">
	                        <select name="vocation_yearly">
	                            <option value="" selected>Vocation Yearly</option>
	                            <option value="Australia">0</option>
	                            <option value="Austria">1</option>
	                            <option value="Austria">2</option>
	                        </select>
	                        <i></i>
	                    </label>
	                </div>
            	</div>
            	<div class="row">
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Sick leave</label>
	                    <label class="j-input">
	                        <select name="sick_leave">
	                            <option value="" selected>Sick leave</option>
	                            <option value="Australia">0</option>
	                            <option value="Austria">1</option>
	                            <option value="Austria">2</option>
	                        </select>
	                        <i></i>
	                    </label>
	                </div>
	                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	                    <label class="j-label">Emergency Contact Name</label>
	                        <div class="j-input">
	                            <label class="j-icon-left" for="email">
	                                <i class="icofont icofont-ui-user"></i>
	                            </label>
	                            <input type="text" placeholder="" id="emergency_name" name="emergency_name">
	                        </div>
	                </div>
            	</div>
            	<div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                     <label class="j-label">Emergency Contact No</label>
                <div class="j-input">
                            <label class="j-icon-left" for="email">
                                <i class="icofont icofont-phone"></i>
                            </label>
                            <input type="text" class="form-control" placeholder="Emergency Contact Number" id="emergency_no" name="emergency_no">
                </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                    <label class="j-label">Image Upload</label>
                        <div class="j-input j-append-small-btn">
                            <div class="j-file-button">
                                Browse
                                <input type="file" name="fileImage" onchange="document.getElementById('file1_input').value = this.value;">
                            </div>
                            <input type="text" id="file1_input" readonly="" placeholder="add your CV">
                            <span class="j-hint">Only: doc / docx / xls /xlsx, less 1Mb</span>
                        </div>
                </div>
                </div>
                <div class="row">
                <div class="j-unit">
                    <label class="j-label">Home Address</label>
                    <label class="j-input j-select">
                        <textarea name="e_address" id="e_address" placeholder="Home Address"></textarea>
                        <i></i>
                    </label>
                </div>
        		<input type="submit" class="btn btn-primary" id="btn-employee-add" value="Create">
                <div class="j-response"></div>
            </div>
    </div>
    <span id="error_msgs1"></span>
</form>
    
    @include('js-css-blades.pnotify')
    @include('js-css-blades.datatables')
    @include('js-css-blades.sweetalert')
    @include('js-css-blades.form')

    @include('js-css-blades.form-wizard')
@endsection

