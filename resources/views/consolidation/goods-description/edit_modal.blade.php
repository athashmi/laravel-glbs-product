    <div class="modal fade  stick-up" id="update_goods_description_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Edit Country</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST"  action="javascript:;" id="update_goods_description_form" accept-charset="UTF-8" novalidate="">
        @csrf
      <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input placeholder="Title" id="title" value="{{old('title')}}" class="form-control" name="title"type="text"> 
                </div>
                <input type="hidden" id="id_u" name="id_u">
                <div class="form-group">
                    <label>Amount</label>
                    <input placeholder="Amount" id="amount" value="{{old('amount')}}" class="form-control" name="amount" type="number"> 
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input placeholder="Description" id="description" value="{{old('description')}}"  class="form-control" name="description" type="text"> 
                </div>
               
                <div class="form-group">
                    <label>Courier</label>
                    <select name="courier[]" id="courier" class="form-control full-width select2" multiple="true">
                    	@foreach($couriers as $courier)
                    		<option value="{{$courier->id}}">{{$courier->title}}</option>
                    	@endforeach
                    </select> 
                </div>
                <span class = "error_msg_u_g_d" ></span>
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
  $('#update_goods_description_model').on('shown.bs.modal', function (e) {
       $('.error_msg_u_g_d').html('');
        var id = $(e.relatedTarget).data('id');


        $.get('{{route('consolidation.goods_description.edit')}}',{'id':id},function(response) {
           if(response.status == 1)
            {
              $("#id_u").val(id);
              $("#title").val(response.data.title);
              $("#amount").val(response.data.amount);
              $("#description").val(response.data.description);
              $("#courier").val(response.data.allowed_carriers).change(); 
            }

        },"json");

      });
    });
  function update(e) {
      $.ajax({
        type: "POST",
        url: "{{route('consolidation.goods_description.update')}}",
        data: $('#update_goods_description_form').serialize(),
        dataType: "JSON",
        success: function (response) {
          if(response.status == 1)
          {          
            responseMsg("update",'{{asset('images/icons8-ok-filled-480.png')}}');
            $('#update_goods_description_model').modal('hide');
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
              $('.error_msg_u_g_d').html(html_error);
            }
        }
      });
  }
  </script>
@endsection