
@if($result->status != 'processed')
<div class="btn-group dropdown-split-primary">
<td class="dropdown">
<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
<div class="dropdown-menu dropdown-menu-right b-none contact-menu">


@if($result->status == 'pending')
<a class="dropdown-item" href="javascript:void(0)"  data-id="{{$result->id}}" id="" onclick=requestApprovedType("process","{{$result->id}}") >Process</a>
<a class="dropdown-item" href="javascript:void(0)"  data-id="{{$result->id}}" id="" onclick=requestApprovedType("reject","{{$result->id}}") >Reject</a>
@endif

@if($result->status == 'rejected')
	<a class="dropdown-item" href="javascript:void(0)"  data-id="{{$result->id}}" id="" onclick=requestApprovedType("process","{{$result->id}}") >Process</a>
@endif
</div>
</td>
</div>
@endif

