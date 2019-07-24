<!-- Model for create Country -->
    <div class="modal fade  stick-up" id="create_goods_description_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Create Good</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create_good_description" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input placeholder="Title" value="{{old('title')}}" class="form-control title_c" name="title"type="text"> 
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input placeholder="Amount" value="{{old('amount')}}" class="form-control amount_c" name="amount" type="number"> 
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input placeholder="Description" value="{{old('description')}}"  class="form-control description_c" name="description" type="text"> 
                </div>
               
                <div class="form-group">
                    <label>Courier</label>
                    <select name="courier[]" class="form-control full-width select2 select2_C" multiple="true">
                    	@foreach($couriers as $courier)
                    		<option value="{{$courier->id}}">{{$courier->title}}</option>
                    	@endforeach
                    </select> 
                </div>
                <span class = "error_msg_c_g_d" ></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="createGood()">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('script')
@parent
<script>
  function createGood() {
      $.ajax({
          type: "POST",
          url: "{{route('consolidation.goods_description.store')}}",
          data: $('#formid_create_good_description').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
              $('#create_goods_description_model').modal('hide');
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
              $('.error_msg_c_g_d').html(html_error); 
            }
        }
      });
    }
    $(document).ready(function(){
    $('#create_goods_description_model').on('shown.bs.modal', function (e) {
       $('.error_msg_c_g_d').html('');
       $(".title_c").val('');
       $(".amount_c").val('');
       $(".description_c").val('');
       $(".select2").val('').change(); 
    });
  });
</script>
@endsection