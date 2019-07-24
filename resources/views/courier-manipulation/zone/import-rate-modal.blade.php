    <div class="modal fade stick-up" id="Importrate" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title pull-left" id="myModalLabel">Import rate</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form method="POST" action="javascript:;" id="import_rates" accept-charset="UTF-8">
        @csrf
      <div class="modal-body">
		<div class="card card-transparent">
			<div class="card-header ">
				<div class="card-title">Import csv stylesheet format
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed" id="condensedTable">
						<thead>
							<tr>
								<th style="width:30%">weight</th>
								<th style="width:30%">amount</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="v-align-middle semi-bold">1</td>
								<td class="v-align-middle">20</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="upload-btn-wrapper">
		  <button class="btn" id="OpenImgUpload">Upload a file</button>
		  <p class="mt-10 name"></p>
		  <input type="hidden" name="courier_zone_id" id="courier_zone_id">
		  <input type="file" name="myfile" class="up" />
		</div>
		<div class="import_error"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="importXL()">Import</button>
      </div>
      </form>
    </div>
  </div>
</div>
@section('script')
@parent
 <script>
 	$('.up').hide();
 	$('#OpenImgUpload').click(function(){ $('.up').trigger('click'); });
 	$('.up').change(function() {
	  //var i = $(this).prev('p').clone();
	  	var file = $('.up')[0].files[0].name;
	  	$('.name').text(file);
	}); 
	function importXL() {
		var fileupload = new FormData();    
		fileupload.append( 'file', $('.up')[0].files[0] );
		fileupload.append('id',$("#courier_zone_id").val())

		$.ajax({
		  url: '{{route("courier.importrate")}}',
		  data: fileupload,
		  processData: false,
		  contentType: false,
		  type: 'POST',
		  dataType: "JSON",
		  success: function(data){ 
		  	if(data.status == 1)
		  	{
		  		responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
            	$('#Importrate').modal('hide');
		  	}
		   if(data.status == 0){
		   	var html_error = '<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.msg+'</div></div></ul></div>';
		   	$('.import_error').html(html_error);
		   }
		  }
		});
	}
	function parsingId(id){
    $("#courier_zone_id").val(id);
  }
 </script>
@endsection