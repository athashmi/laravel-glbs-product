<div class="modal fade stick-up" id="edit_shelf_model"  role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title pull-left" id="myModalLabel">Edit Shelf</h4>
				<button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<form method="POST" id="form_shelf_update" action="javascript:;" accept-charset="UTF-8">
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input placeholder="Name" value="{{old('name')}}" class="form-control" name="name" id="e_name" type="text">
					</div>
					<input type="hidden" name="id" id="u_id">
					<div class="form-group form-group-default ">
						<label>Warehouses</label>
						<select name="warehouse" id="e_warehouse" class="select2 full-width form-control">
							<option value="" selected>Select Warehouse</option>
							@foreach($warehouses as $warehouse)
							<option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group form-group-default">
			            <label>Type</label>
			            <select name="type" class="select2 shelf-edit-usage-type shelf-usage-type full-width form-control">
			              <option value="" selected>Select Type</option> 
			              <option value="package">Package</option>
			              <option value="consolidated">Consolidated</option>
			            </select>
			          </div>
			          <div class="form-group consolidated-shelf-color form-group-default display-none">
			            <label>Color</label>
			            <select name="color" class="select2 edit-shelf-con-color full-width form-control">
			              <option value="" selected>Select Color</option> 
			              <option value="orange">Orange</option>
			              <option value="red">Red</option>
			              <option value="green">Green</option>
			              <option value="purple">Purple</option>
			              <option value="black">Black</option>
			              <option value="pink">Pink</option>
			              <option value="yellow">Yellow</option>
			              <option value="blue">Blue</option>
			              <option value="brown">Brown</option>
			              <option value="white">White</option> 
			            </select>
			          </div>
					<div class="error_msg_s_U" ></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" onclick="updateShelf()">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--- Model create for permission  ---->
@section('script')
@parent
<script>
	$(document).ready(function(){
$('#edit_shelf_model').on('shown.bs.modal', function (e) {
	$('.error_msg_s_U').html('');
var id = $(e.relatedTarget).data('id');
$("#update_role_id").val(id);
$.ajax({
type: "post",
url: '{{URL::route("warehouse.shelves.editshelf")}}' ,
dataType: "JSON",
data:'id='+id,
success: function (response) {
if(response.status == 1)
{
$("#u_id").val(response.data.id);
$("#e_name").val(response.data.name);
if(response.data.usage_type == 'consolidated'){
$('.consolidated-shelf-color').removeClass('display-none');
$('.edit-shelf-con-color').val(response.data.color).select2();
}else{
$('.consolidated-shelf-color').addClass('display-none');
}
$('.shelf-edit-usage-type').val(response.data.usage_type).select2();
$('#e_warehouse').val(response.data.warehouse_id).select2();
}
},
error: function (jqXHR, exception) {
}
});
});
});
function updateShelf() {
$.ajax({
type: "POST",
url: "{{route('warehouse.shelves.updateshelf')}}",
data: $('#form_shelf_update').serialize(),
dataType: "JSON",
success: function (response) {
if(response.status == 1)
{
responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");
$('#edit_shelf_model').modal('hide');
$('.datatable').DataTable().draw();
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
$('.error_msg_s_U').html(html_error);
}
}
});
}
</script>
@endsection