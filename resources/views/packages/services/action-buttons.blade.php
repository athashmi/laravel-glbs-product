<div class="btn-group dropdown-split-primary">
	<td class="dropdown">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
		<div class="dropdown-menu dropdown-menu-right b-none contact-menu">
			@if($result->usage_type != 'consolidated')
			<a class="dropdown-item" href="javascript:void(0)" onclick = statusChanges("{{$result->status}}","{{$result->id}}")><i class="icofont icofont-badge"></i>
				@if($result->status == 'active')
					Deactivate
				@endif
				@if($result->status == 'in_active')
					Activate
				@endif
				 
			</a>
			@endif
			<a class="dropdown-item"href="javascript:void(0)"  data-toggle="modal" data-id="{{$result->id}}"   id="edit_id" data-target="#{{$modal_id}}"><i class="icofont icofont-edit"></i>Edit</a>
			<a class="dropdown-item" href="javascript:void(0)"  data-id="{{$result->id}}" id="delete_id{{$result->id}}" onclick=deleteById("{{$result->id}}") ><i class="icofont icofont-ui-delete"></i>Delete</a>
		</div>
	</td>
</div>