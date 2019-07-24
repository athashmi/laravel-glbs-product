<div class="modal fade stick-up" id="EditCourierZoneModel" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Edit Courier Zone</h4>
        <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" action="javascript:;" id="update_courier_zone" accept-charset="UTF-8">
        @csrf
        <div class="modal-body">
          {{-- <div class="form-group">
            <label>Courier Name</label>
            <input placeholder="Courier Type"  id="e_name" class="form-control" name="name" type="text">
            <span id="error_msg"></span>
          </div> --}}
          <div class="form-group">
            <label>Courier Title</label>
            <input placeholder="Courier Type"  id="e_c_title" class="form-control color-black" name="c_title" type="text" disabled="true">
            <span id="error_msg"></span>
          </div>
          
          <div class="form-group">
            <label>Zone Name</label>
            <input placeholder="Zone Name"  id="e_title" class="form-control" name="title" type="text">
            <span id="error_msg"></span>
          </div>
          <input type="hidden" name="id" id="id-zone">
          <div class="form-group">
            <label>Countries</label>
            <select class="form-control full-width country_assign" name="country[]" id="country" multiple="multiple">
              @foreach($countries as $country)
              <option value="{{$country->id}}">{{$country->name}}</option>
              @endforeach
            </select>
            <span id="error_msg"></span>
          </div>
          <div class="error_msg_c_u" ></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" onclick="update()" >Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">
$(document).ready(function(){
//$('.form-group').addClass('form-group-default');
$('#EditCourierZoneModel').on('shown.bs.modal', function (e) {
$('.error_msg_c_u').html('');
var id = $(e.relatedTarget).data('id');
$.get('{{URL::route("courier.zone.edit")}}',{'id':id},function(response) {
if(response.status == 1)
{
console.log(response);
  $("#id-zone").val(response.data.id);
  $("#e_name").val(response.data.courier.name);
  $("#e_c_title").val(response.data.courier.title);
  $("#e_title").val(response.data.title);
  var htmls = "";
  var selected_perms = [];  
  $('.country_assign').val(response.assigned_country).trigger('change');
}
},"json");
});
});
function update() {
$.ajax({
type: "POST",
url: "{{URL::route('courier.zone.update')}}",
data: $('#update_courier_zone').serialize(),
dataType: "JSON",
success: function (response) {
if(response.status == 1)
{
responseMsg("update",'{{asset('images/icons8-ok-filled-480.png')}}');
$('#EditCourierZoneModel').modal('hide');
$('.datatable').DataTable().draw();
}
if(response.status == 0)
{
responseMsg("error",'{{asset('images/error.png')}}');
$('#EditCourierZoneModel').modal('hide');
$('.datatable').DataTable().draw();
}
},
error: function (jqXHR,status, exception) {
  if (jqXHR.status == 422) {
var html_error = '';
$.each(jqXHR.responseJSON.errors, function (key, value)
{
html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
})
html_error += "</ul></div>";
$('.error_msg_c_u').html(html_error);

}
}
});
}
</script>
@endsection