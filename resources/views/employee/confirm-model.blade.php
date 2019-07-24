 <div class="modal fade  stick-up" id="confirm_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Confirm Modal</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="confirm_model_form" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
                <div class="form-group">
                    <b>Any difficulty or delay was experienced during this task??</b> 
                </div>
                <div class="radio radio-primary">
					<input type="radio" value="yes" name="radion_agree" id="yes">
					<label for="yes">Yes</label>
					<input type="radio" checked="checked" value="no" name="radion_agree" id="no">
					<label for="no">No</label>
				</div>
               <span class = "error_msg_c_c" ></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="postTaskUpload('{{route('employee.upload')}}','#upload_package_employee','upload')">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('script')
@parent
<script>
    $(document).ready(function(){
    $('#confirm_model').on('shown.bs.modal', function (e) {
       $('.error_msg_c_c').html('');
    });
  });
</script>
@endsection