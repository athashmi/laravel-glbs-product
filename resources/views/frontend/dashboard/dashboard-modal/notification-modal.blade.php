<div class="modal fade slide-up disable-scroll" id="modalFillIn" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog modal-lg modal-noti">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close color-black" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close fs-14"></i>
					</button>
					<h2 class="title_html">
						
					</h2>
				</div>
				<div class="modal-body modal-body-noti">
					<form role="form">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12 html_body">
									<div class="form-group form-group-default">
										<label>Company Name</label>
										<input type="email" class="form-control">
									</div>
								</div>
							</div>
							
						</div>
					</form>
					<div class="row">
						<div class="col-md-8">
							<div class="p-t-20 clearfix p-l-10 p-r-10">
								
							</div>
						</div>
						 
					</div>
				</div>
				<div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
			</div>
		</div>
	</div>
</div>

@section('script')
@parent
<script>
  

    $(document).ready(function(){
    $('#modalFillIn').on('shown.bs.modal', function (e) {
       var id = $(e.relatedTarget).data('id');

        $.get('{{URL::route("frontend.post.getpost")}}',{'id':id},function(response) {
 

           if(response.status == 1)
            {
              $(".title_html").html(response.data.title);
              $(".html_body").html(response.body);  
            }

        },"json");
    });
  });
</script>
@endsection