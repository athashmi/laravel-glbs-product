{{-- <div class="btn-group dropdown-split-primary">
	<button type="button" class="btn btn-primary">Actions</button>
	<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	<span class="sr-only">Toggle primary</span>
	</button>
	<div class="dropdown-menu">
		<a class="dropdown-item waves-effect waves-light" href="{{route('employee.edit',$employee->id)}}">Edit</a>
		<a class="dropdown-item waves-effect waves-light" href="javascript:void(0)"  data-id="{{$employee->user->id}}" id="delete_id{{$employee->user->id}}" onclick=deleteById("{{$employee->user->id}}") >Delete</a>
	</div>
</div> --}}
<div class="btn-group dropdown-split-primary">
	<td class="dropdown">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
		<div class="dropdown-menu dropdown-menu-right b-none contact-menu">
			<a class="dropdown-item" href="{{route('employee.edit',$employee->id)}}"><i class="icofont icofont-edit"></i>Edit</a>
			<a class="dropdown-item"href="javascript:void(0)"  data-id="{{$employee->user->id}}" id="delete_id{{$employee->user->id}}" onclick=deleteById("{{$employee->user->id}}")  ><i class="icofont icofont-ui-delete"></i>Delete</a>
			{{-- <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
			<a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
			<a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
			<a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
			<a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a> --}}
		</div>
	</td>
</div>