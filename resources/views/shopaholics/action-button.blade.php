<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
<div class="dropdown-menu dropdown-menu-right b-none contact-menu">
	{{-- <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a> --}}
	 	 
		<input type="hidden" name="id" value="{{$result->shp_id}}">

	
		<a class="dropdown-item profile-url" href="{{route('shopaholic.shopaholic-profile',$result->shp_id)}}" ><i class="icofont icofont-eye-alt"></i>View</a> 
	<a class="dropdown-item" href="#!" data-toggle="modal" data-id="{{$result->user_id}}"   id="edit_id" data-target="#{{$modal_id}}"><i class="icofont icofont-tasks-alt"></i>Update Wallet</a>

	{{-- <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Deposit in-wallet</a> --}}
	<a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
	{{-- <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a> --}}

	<a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
</div>
