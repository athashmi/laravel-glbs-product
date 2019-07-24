<div class="btn-group dropdown-split-primary">
<td class="dropdown">
<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
<div class="dropdown-menu dropdown-menu-right b-none contact-menu">

<a class="dropdown-item"href="javascript:void(0)"  data-toggle="modal" data-id="{{$result->id}}"   id="edit_id" data-target="#{{$modal_id}}"><i class="icofont icofont-edit"></i>Edit</a>
<a class="dropdown-item" href="javascript:void(0)"  data-id="{{$result->id}}" id="delete_id{{$result->id}}" onclick=deleteById("{{$result->id}}") ><i class="icofont icofont-ui-delete"></i>Delete</a>


{{-- <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
<a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
<a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
<a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
<a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a> --}}


</div>
</td>
</div>