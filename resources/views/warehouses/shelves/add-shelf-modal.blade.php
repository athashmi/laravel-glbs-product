<div class="modal fade stick-up" id="create_shelf_model"  role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Create Shelf</h4>
        <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" id="form_shelf_create" action="javascript:;" accept-charset="UTF-8">
        <div class="modal-body">
          <div class="form-group">
            <label>Name</label>
            <input placeholder="Name" value="{{old('name')}}" class="form-control" name="name" type="text">
          </div>
          <div class="form-group form-group-default ">
            <label>Warehouses</label>
            <select name="warehouse" class="select2 full-width form-control">
              <option value="" selected>Select Warehouse</option>
              @foreach($warehouses as $warehouse)
              <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group form-group-default">
            <label>Type</label>
            <select name="type" class="select2 shelf-usage-type full-width form-control">
              <option value="" selected>Select Type</option> 
              <option value="package">Package</option>
              <option value="consolidated">Consolidated</option>
            </select>
          </div>
          <div class="form-group consolidated-shelf-color form-group-default display-none">
            <label>Color</label>
            <select name="color" class="select2 full-width form-control">
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
          <div class="error_msg_s_i" ></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" onclick="createShelf()">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--- Model create for permission  ---->
@section('script')
@parent
<script>
function createShelf() {
$.ajax({
type: "POST",
url: "{{route('warehouse.shelves.insertshelf')}}",
data: $('#form_shelf_create').serialize(),
dataType: "JSON",
success: function (response) {
if(response.status == 1)
{
responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
$('#create_shelf_model').modal('hide');
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
$('.error_msg_s_i').html(html_error);
}
}
});
}


$(document).ready(function(){
    $('#create_shelf_model').on('shown.bs.modal', function (e) {
       $('.error_msg_s_i').html('');
    });
    $('.shelf-usage-type').on('change',function(){
      if($(this).val() == 'consolidated'){
        $('.consolidated-shelf-color').removeClass('display-none');
      }else{
        $('.consolidated-shelf-color').addClass('display-none');
      }
    });
  });
</script>
@endsection