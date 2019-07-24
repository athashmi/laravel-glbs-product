<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Detail</button>
<div class="dropdown-menu dropdown-menu-right b-none contact-menu">
	 	 
	<input type="hidden" name="outgoing_cons_req_id" value="{{$result->id}}">
	<a class="dropdown-item" href="#!" data-toggle="modal" data-id="{{$result->id}}"   id="review_out_con_req" data-target="#{{$review_modal_id}}"><i class="icofont icofont-tasks-alt"></i>Review Request</a> 
	<a class="dropdown-item" href="#!" data-toggle="modal" data-id="{{$result->id}}"   data-target="#{{$custom_dec_model_id}}"><i class="icofont icofont-tasks-alt"></i>Custom Declaration</a>
	@if($result->status == 'payment_pending')
		<a class="dropdown-item" target="_blank" href="{{route('frontend.consolidate.get_checkout',$result->id)}}" data-id="{{$result->id}}"><i class="icofont icofont-tasks-alt"></i>Checkout</a>
	@endif
</div>