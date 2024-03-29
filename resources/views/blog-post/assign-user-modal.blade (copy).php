
<div class="modal fade  stick-up" id="assign_user_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Assign Country to Updates</h4>
        <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST"  action="javascript:;" id="assign_user_updates" accept-charset="UTF-8" novalidate="">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label>Please Choose User</label>
            <select   class="form-control full-width select2user" name="user[]" multiple="multiple">
              
            </select>
          </div>
          <input type="hidden" id="assign_id_user_modal" name="id">
          <div class="error_msg_a_u_u_i" ></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-update" onclick="assignUser(this)" >Assign</button>
        </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">
    $(document).ready(function(){
    $('#assign_user_modal').on('shown.bs.modal', function (e) {
      var id = $(e.relatedTarget).data('id');
      $("#assign_id_user_modal").val(id);
      $.ajax({
        type: "post",
        url: '{{URL::route("blog_post.assigneditpost")}}' ,
        dataType: "JSON",
        data:{'id':id,'type':'user'},
        success: function (response) {
        if(response.status == 1)
        {
          
          var selected = "";
          if(response.num_of_ids != 0){
            $.each(response.users, function(index, item) {
              if(item.shopaholic != null){
                selected += '<option selected="selected" value="'+item.id+'">'+item.first_name+' ('+item.shopaholic.sn+')</option>';
              }else{
                selected += '<option selected="selected" value="'+item.id+'">'+item.first_name+'</option>';
              }
          });
            $('.select2user').html(selected);
          }else{
              var selected = '';
            $('.select2user').html(selected);
          }
         // $('.select2user').val('data', {id: '123', text: 'ddss'});
          // var newOption = new Option('Barn owl', '1', true, true);
          // $('.select2user').append(newOption).trigger('change');
          // var a = $('ul.select2-selection__rendered li').attr('title');
          // console.log(a);
          // $('.select2-selection__rendered .select2-selection__choice span').html(a);
          // console.log($('.select2-selection__rendered .select2-selection__choice span').html());
        }
        },
        error: function (jqXHR, exception) {
        }
      });
    });
  });


  function assignUser(e) {
      $.ajax({
        type: "POST",
        url: "{{URL::route('blog_post.assignpost','user')}}",
        data: $('#assign_user_updates').serialize(),
        dataType: "JSON",
        success: function (response) {
          if(response.status == 1)
          {          
            responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
            $('#assign_user_modal').modal('hide');
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
              $('.error_msg_a_u_u_i').html(html_error);
            }
        }
      });
  }


function displayResult(item) {
  console.log(item)
        return item;
    } 
    $('#demo1').typeahead({
      display: 'value',
        source: [
            {id: 1, name: 'Toronto'},
            {id: 2, name: 'Montreal'},
            {id: 3, name: 'New York'},
            {id: 4, name: 'Buffalo'},
            {id: 5, name: 'Boston'},
            {id: 6, name: 'Columbus'},
            {id: 7, name: 'Dallas'},
            {id: 8, name: 'Vancouver'},
            {id: 9, name: 'Seattle'},
            {id: 10, name: 'Los Angeles'}
        ],
        //onSelect: displayResult,
       
    }).bind('select', function(ev, suggestion) {
  console.log('Selection: ' + suggestion);
});;

    $('#demo1').bind('typeahead:select', function(ev, suggestion) {
  console.log('Selection: ' + suggestion);
});


  
  </script>
@endsection