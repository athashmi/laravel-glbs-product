<div class="modal fade stick-up" id="create_service_model"  role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Create Service</h4>
        <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" id="add-service-form" action="javascript:;" accept-charset="UTF-8">
        <div class="modal-body">
          <div class="form-group form-group-default">
            <label>Title</label>
            <input placeholder="Title" value="{{old('title')}}" class="form-control" name="title" type="text">
          </div>
          <div class="form-group form-group-default ">
            <label>Description</label>
             <textarea name="description" class="form-control" value="{{old('description')}}"></textarea>
          </div>
          <div class="form-group form-group-default">
            <label>Type</label>
            <select name="type" class="select2 add-service-packg full-width form-control">
              <option value="" selected>Select Type</option> 
              <option value="free">Free</option>
              <option value="paid">Paid</option>
            </select>
          </div>
          
	        <div class="form-group add-service-packg-amount display-none form-group-default input-group">
			<div class="form-input-group">
			<label>Amount</label>
			<input type="decimal" class="form-control"  name="amount">
			</div>
			<div class="input-group-append ">
			<span class="input-group-text">USD
			</span>
			</div>
			</div>
          <div class="error_msg_a_s_p" ></div>
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
url: "{{route('package.services.store')}}",
data: $('#add-service-form').serialize(),
dataType: "JSON",
success: function (response) {
if(response.status == 1)
{
responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
$('#create_service_model').modal('hide');
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
$('.error_msg_a_s_p').html(html_error);
}
}
});
}


$(document).ready(function(){
	$('.select2').select2();

    $('#create_shelf_model').on('shown.bs.modal', function (e) {
       $('.error_msg_a_s_p').html('');
    });
    $('.add-service-packg').on('change',function(){
      if($(this).val() == 'paid'){
        $('.add-service-packg-amount').removeClass('display-none');
      }else{
        $('.add-service-packg-amount').addClass('display-none');
      }
    });
  });
</script>
@endsection