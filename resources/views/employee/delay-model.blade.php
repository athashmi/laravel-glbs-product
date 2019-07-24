<div class="modal fade stick-up" id="delay_reason_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Please enter reason for the delay</h4>
       
      </div>
        <form method="POST" id="formid_delay_modal" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body">
                <div class="form-group">
                    <label>Enter remarks</label>
                    <textarea class="form-control" id="rere" name = "remarks" placeholder="Enter remarks..."></textarea>
                    <span id="error_msg"></span>
                </div>
                 <div class="form-group">
                    <label><b>System Logout After 5 minute automatically. If You not enter anything</b></label>
                </div>
                <div class="error_msg_delay_modl" ></div>

                <h3 class="m-t-0 pull-right"><b class="m-r-0 timer-display">00:00</b></h3>
                <div class="clear-fix"></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-delay-reason">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
    <form id="logout-form-delay" action="{{route('employee.logout')}}" method="POST" style="display: none;">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="idle_time_start" name="idle_time_start" value="">
            <input type="hidden" id="idle_time_end" name="idle_time_end" value="">
    </form>

@section('script')
@parent
<script>
  
  var num_for_logout = 0;

  $(document).ready(function(){


    $('#delay_reason_model').on('shown.bs.modal', function (e) {


    startCountDown(300,'timer-display','no');

      $('.error_msg_delay_modl').html('');
      $('#rere').val('');
      $('#rere').html('');
      timer_count_logout();
    });
    $('.btn-delay-reason').click(function(){
       $.ajax({
          type: "POST",
          url: "{{route('employee.remarks')}}",
          data: $('#formid_delay_modal').serialize()+'&delay_start_time='+localStorage.getItem('delay_start_time')+'&delay_end_time='+getCurrentDateTime(),
          dataType: "JSON",
          success: function (response) {
            if(response.status == 1)
            {
              responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
                $('#delay_reason_model').modal('hide');
                location.reload();
                remainingTimeDashboard();
                localStorage.setItem('delay_start_time',getCurrentDateTime());
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
              $('.error_msg_delay_modl').html(html_error);
            }
        }
      });
    })
  });

    function timer_count_logout(){

      if(num_for_logout < 300){
        setTimeout(function(){
            timer_count_logout();
          }, 1000);
        num_for_logout++;
        //console.log(num_for_logout);
      }else{
          LocalStorageClear();
          $('#idle_time_start').val(delay_start_time);
          $('#idle_time_end').val(getCurrentDateTime());
          $('#logout-form-delay').submit();
      }

    }
</script>
@endsection