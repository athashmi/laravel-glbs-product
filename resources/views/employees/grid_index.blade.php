@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('grid') }}
{{-- <ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Data Tables</li>
</ol> --}}

 
</div>
</div>
</div>



<div class=" container-fluid   container-fixed-lg bg-white">
<div class="card card-transparent">
<div class="card-header ">
<div class="card-title">Employees Grid
</div>
<div class="pull-right">
<div class="col-xs-12">
<a href="{{route('employee.create')}}"  class="btn btn-primary btn-cons"><i class="fa fa-plus"></i>Add Employee</a>

 

</div>
</div>

 
<div class="clearfix"></div>
</div>
<div class="card-body">
<div class="row simple-cards users-card col-sm-12">
	@foreach($employees as $employee)
	<div class="col-md-12 col-xl-4">
		<div class="card user-card">
			<div class="card-header-img">
				@if($employee->user->picture)
				<img class="img-fluid img-radius" src="{{URL::route("img_file", $employee->user->picture)}}" alt="card-img">
				@else
				<img class="img-fluid img-radius" src="{{asset('images/user2-160x160.jpg')}}" alt="card-img">
				@endif
				<h4>{{$employee->user->first_name.' '. $employee->user->last_name}}</h4>
				<h5><i class="fa fa-envelope"></i>  <a href="javascrit:void(0)" class="__cf_email__" data-cfemail="">{{$employee->user->email}}</a></h5>
				<h6>{{$employee->user->roles->first()->name}}</h6>
			</div>
			<p>Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.</p>
			<div>
				{{-- <button type="button" class="btn btn-primary waves-effect waves-light m-r-15"><i class="icofont icofont-plus m-r-5"></i>Follow</button> --}}
				<button type="button" class="btn btn-success waves-effect waves-light"><i class="fa fa-user "></i> Profile</button>
			</div>
		</div>
	</div>
	@endforeach
</div>
</div>
</div>

</div>
</div>


@endsection
 