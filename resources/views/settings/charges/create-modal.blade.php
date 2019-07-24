    <div class="modal fade  stick-up" id="create_charges_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Add Charge</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create" action="javascript:;" accept-charset="UTF-8" novalidate="">
      <div class="modal-body">
        <div class="form-group">
            <label>Title</label>
            <input placeholder="Title" value="{{old('title')}}"   class="form-control" name="title" type="text"> 
        </div>
       
        <div class="form-group">
            <label>Amount</label>
            <input placeholder="Amount" value="{{old('amount')}}"  class="form-control" name="amount" type="number"> 
        </div>
        <div class="form-group">
            <label>Applicable Module</label>
           <div class="checkbox check-primary ">
				<input type="checkbox" name="applicable_module[]" value="package" id="checkbox1">
				<label for="checkbox1">Package fee</label>
			</div>
			<div class="checkbox check-primary ">
				<input type="checkbox" name="applicable_module[]" value="consolidation" id="checkbox2">
				<label for="checkbox2">consolidation fee</label>
			</div> 
        </div>
      	<span class = "error_msg_c_c_a"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="createCharges()">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
<script>
  function createCharges() {
      $.ajax({
          type: "POST",
          url: "{{route('setting.charges.store')}}",
          data: $('#formid_create').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
              $('#create_charges_model').modal('hide');
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
              $('.error_msg_c_c_a').html(html_error);
              
            }
        }
      });
    }
    $(document).ready(function(){
    $('#create_charges_model').on('shown.bs.modal', function (e) {
       $('.error_msg_c_c_a').html('');
    });
  });
</script>
@endsection