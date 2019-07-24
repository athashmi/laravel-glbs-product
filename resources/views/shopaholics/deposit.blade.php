
    <div class="modal fade" id="deposit_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Deposit Money</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
      	<div class="row">
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Transaction Id</label>
                    <input placeholder="Name" id="name" class="form-control" name="name" type="text">
                </div>
               
                <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                    <label>Teansaction Amount</label>
                    <input placeholder="$20" id="email" class="form-control" name="email" type="text">
                    <span id="error_msg"></span>
                </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="createCountry()">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('script')
@parent
<script>
  function createCountry() {
      $.ajax({
          type: "POST",
          url: "",
          data: $('#formid_create').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("update","Information has been inserted successfully...");
              $('#create_warehouse_model').modal('hide');
              $('.datatable').DataTable().draw();
          }
          },
          error: function(jqXHR, exception){
            
            var html_error = '<div  class="alert " style="background-color:#e67070; color:white;"><ul>';
            $.each(jqXHR.responseJSON.errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
             html_error += "</ul></div>";
          $('#error_msgs1').html(html_error);
          setTimeout(function(){
                $("#error_msgs1").html('');
          },2000);
        }
      });
    }
</script>
@endsection