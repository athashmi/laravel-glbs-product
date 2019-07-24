<!-- Model for Edit permission -->
    <div class="modal fade  stick-up" id="EditCountryModel" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Edit Country</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST"  action="javascript:;" id="update_country" accept-charset="UTF-8" novalidate="">
        @csrf
      <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input placeholder="Name"  id="e_name_edit" class="form-control" name="name" type="text"> 
                </div>
              
                <div class="form-group">
                    <label>ISO</label>
                    <input placeholder="ISO"  id="e_iso" class="form-control" name="iso" type="text"> 
                </div>
              
                <div class="form-group">
                    <label>Num Code</label>
                    <input placeholder="Num Code"  id="e_num_code" class="form-control" name="num_code" type="number"> 
                </div>
                 <div class="form-group">
                    <label>Phone Code</label>
                    <input type="hidden" id="id" name="id">
                    <input placeholder="Phone Code"  id="e_phone_code" class="form-control" name="phone_code" type="number"> 
                </div>
                <div class="error_msg_c_u" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-update-country" onclick="update(this)" >Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">

  $(document).ready(function(){
  $('#EditCountryModel').on('shown.bs.modal', function (e) {
       $('.error_msg_c_u').html('');
        var id = $(e.relatedTarget).data('id');


        $.get('{{URL::route("country.edit")}}',{'id':id},function(response) {
           if(response.status == 1)
            {
              $("#id").val(id);
              $("#e_name_edit").val(response.data.name);
              $("#e_nice_name").val(response.data.nice_name);
              $("#e_iso").val(response.data.iso);
              $("#e_iso3").val(response.data.iso3);
              $("#e_num_code").val(response.data.num_code);
              $("#e_phone_code").val(response.data.phone_code);
            }

        },"json");

      });
    });
  function update(e) {
     loader(e); 
      $.ajax({
        type: "POST",
        url: "{{URL::route('country.update')}}",
        data: $('#update_country').serialize(),
        dataType: "JSON",
        success: function (response) {
          if(response.status == 1)
          {          
            responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");
            $('#EditCountryModel').modal('hide');
            $(e).addClass('display-block');
            $('.loader-gif').addClass('display-none');
            $('.datatable').DataTable().draw();
          }
      },
      error: function (jqXHR, exception) {
           if (jqXHR.status == 422) {
              var html_error = '';
              $.each(jqXHR.responseJSON.errors, function (key, value)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
              })
              html_error += "</ul></div>";
              $('.error_msg_c_u').html(html_error);
            }
          $('.btn-update-country').addClass('display-block');
          $('.loader-gif').addClass('display-none');
        }
      });
  }
  </script>
@endsection