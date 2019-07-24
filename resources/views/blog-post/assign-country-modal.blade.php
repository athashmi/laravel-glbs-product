
<div class="modal fade  stick-up" id="assign_country_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Assign Country to Updates</h4>
        <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST"  action="javascript:;" id="assign_country_updates" accept-charset="UTF-8" novalidate="">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label>Please Choose Country</label>
            <select class="form-control full-width select2country" name="country[]" multiple="multiple">
              @foreach($countries as $country)
              <option value="{{$country->id}}">{{$country->name}}</option>
              @endforeach
            </select>
          </div>
          <input type="hidden" id="assign_id_country_modal" name="id">
          <div class="error_msg_a_c_update" ></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-update" onclick="assignCountry(this)" >Assign</button>
        </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">
    $(document).ready(function(){
    $('#assign_country_modal').on('shown.bs.modal', function (e) {
      var id = $(e.relatedTarget).data('id');
      $("#assign_id_country_modal").val(id);
      $.ajax({
        type: "post",
        url: '{{URL::route("blog_post.assigneditpost")}}' ,
        dataType: "JSON",
        data:{'id':id,'type':'country'},
        success: function (response) {
        if(response.status == 1)
        {
          $('.select2country').val(response.country_id).select2();
        }
        },
        error: function (jqXHR, exception) {
        }
      });
    });
  });


  function assignCountry(e) {
      $.ajax({
        type: "POST",
        url: "{{URL::route('blog_post.assignpost','country')}}",
        data: $('#assign_country_updates').serialize(),
        dataType: "JSON",
        success: function (response) {
          if(response.status == 1)
          {          
            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
            $('#assign_country_modal').modal('hide');
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
              $('.error_msg_a_c_update').html(html_error);
            }
        }
      });
  }
  </script>
@endsection