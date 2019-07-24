    <div class="modal fade stick-up" id="AddCourierZoneModel" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Add Courier Zone</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" action="javascript:;" id="insert_courier_zone" accept-charset="UTF-8">
        @csrf
      <div class="modal-body">
                <div class="form-group">
                    <label>Courier Name</label>
                    <input placeholder="Courier Name"  id="c_name_add" class="form-control color-black" name="c_name" type="text" disabled="true">
                    <span id="error_msg"></span>
                </div>
              
                <div class="form-group">
                  <input type="hidden" name="courier_id" id="courier_id_zone_insert">
                    <label>Zone Name</label>
                    <input placeholder="Zone Name"  id="i_title" class="form-control" name="z_title" type="text">
                    <span id="error_msg"></span>
                </div>
                <input type="hidden" name="id" id="id-zone">
                <div class="form-group form-group-default">
                    <label>Countries</label>
                   <select class="form-control full-width add_courier_zone" name="country[]" id="country" multiple="multiple" >
                   @foreach($countries as $country) 
                   		<option value="{{$country->id}}">{{$country->name}}</option>
                   @endforeach
                  </select>
                    <span id="error_msg"></span>
                </div>
                <div class="error_msg_c_a" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="addCourierZone()" >Add Courier</button>
      </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">
  $(document).ready(function(){
    $('#AddCourierZoneModel').on('shown.bs.modal', function (e) {
      $('.error_msg_c_a').html('');
      var a = $('.courier_ li a.active').html(); 
      $('#c_name_add').val(a);
      var courier_id = $('.courier_ li a.active').closest('a').siblings('input:hidden').val();
      $("#courier_id_zone_insert").val(courier_id);
      $('.add_courier_zone').val([]).select2();
    });
  });
  
  function addCourierZone() {
    console.log($('#insert_courier_zone').serialize());
      $.ajax({
        type: "POST",
        url: "{{URL::route('courier.zone.insert')}}",
        data: $('#insert_courier_zone').serialize(),
        dataType: "JSON",
        success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
            $('#AddCourierZoneModel').modal('hide');
            $('.datatable').DataTable().draw();
          }
           if(response.status == 0)
          {
            responseMsg("error",'{{asset('images/error.png')}}');
            $('#AddCourierZoneModel').modal('hide');
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
              $('.error_msg_c_a').html(html_error);
              
            }
          }
        });
  }
  </script>
@endsection