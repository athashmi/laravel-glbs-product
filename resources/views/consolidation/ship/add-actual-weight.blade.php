<!-- Model for create Country -->
    <div class="modal fade slide-right" id="actual_weight_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Box Detail Form</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body p-b-0">
                <div class="row row-sm-height paid_services form-group-default input-group padding-custom m-t-20 ma">
                	<div class="col-md-9 col-sm-height padding-20">
                		<button type="button" class="cross_btn hide-cross">×</button>
	                	<div class="btn-group btn-group-justified row w-100">
	                		<div class="btn-group col-5 p-l-10">
	                			<div class="form-group form-group-default"><label>Width</label> 
	                				<input type="number" name="arr[0][width]" class="form-control width field_c_class">
	                			</div>
	                		</div>
	                		<div class="btn-group col-5 p-l-10">
	                			<div class="form-group form-group-default"><label>Height</label>
	                			  <input type="number" name="arr[0][height]" class="form-control height field_c_class" >
	                			</div>
	                		</div>
	                		<div class="btn-group col-5 p-l-10">
	                			<div class="form-group form-group-default"><label>Length</label> 
	                				<input type="number" name="arr[0][lenght]" class="form-control lenght field_c_class">
	                			</div>
	                		</div>
	                		<div class="btn-group col-5 p-l-10">
	                			<div class="form-group form-group-default"><label>Actual Weight</label> 
	                				<input type="number" name="arr[0][actual_weight]" class="form-control actual_weight field_c_class">
	                			</div>
	                		</div>
	                		<input type="hidden" name="arr[0][dimensional_weight]" class="dimensional_weight_hidden">

	                	</div>

                	</div>
                	<div class="col-md-3 d-flex flex-column bg-master-lighter">
                		<h5 class="text-primary m-l-10 m-t-20">
                			Dimensional Weight
                			<br /> 
                			<b ><p class="m-t-10 dimensional_weight"> $ 0.00</p></b>
                		</h5>
                	</div>
            	</div>
				<div class="box_add_more_div">
            	 
            	</div>
            	<button class="btn btn-primary m-t-15 add_more_box"><i class="fa fa-plus"></i>Add More</button> 
    			<div class="form-group form-group-default m-t-10"><label>Choose Location</label> 
    				 <select name="location" class="select2 form-control full-width">
                        <option value="" selected>Choose at least one location</option>
                        @foreach($consolidation_locations as $location)
                        	<option value="{{$location->id}}">{{$location->name .'-'.$location->color}}</option>
                        @endforeach
                    </select>
    			</div>
    			<div class="col-md-12">
					<b></b>
					<div class="clearfix"></div>
					<input type="hidden" name="request_id" class="request_id">
					@foreach($goods_descriptions as $goods)
					
					<div class="input-group-prepend ">
						<input type="checkbox"  name="goods_des[]" value="{{$goods->id}}" class=" m-t-10 m-r-10 add_check_box" >
						<p class="m-b-0 m-t-5">
							{{$goods->title}}
						</p>
					</div>
					@endforeach
					
				</div>
            <span class = "error_msg_c_c" ></span>
           <hr width="100%" />
            <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary btn-box-detail" onclick="boxDetailSubmit()">Create</button>
	      </div>
      </div>
     
      </form>
    </div>
  </div>
</div>

<!--- Model create for Country  ---->

@section('script')
@parent
<script>
  var i = 1;
  var html;
    $(document).ready(function(){
    	html = $('.paid_services').clone(true);
	    $('#actual_weight_model').on('shown.bs.modal', function (e) {
	      var id = $(e.relatedTarget).data('id');
	      $('.lenght').val('');
	      $('.height').val('');
	      $('.width').val('');
	      $('.actual_weight').val('');
	      $('.dimensional_weight').html('$ 0.00');
	      $('.request_id').val(id);
	      $('.box_add_more_div').html('');
	      $('.error_msg_c_c').html('');
	      $('.add_check_box').prop('checked',false);
	    });
	    $('.add_more_box').on('click',function(){
	    	renderCustomBox('.box_add_more_div',html);
	    });
	    $(document).on('click','.cross_btn',function(){
	    	$(this).parent().parent().remove();
	    });
	    $(document).on('keyup','.field_c_class',function(){
	    	dynamicCalculation($(this),'.paid_services');
	    });

		
	  
    });
    function boxDetailSubmit(){
	    	$.ajax({
			      type: "POST",
			      url: "{{route('consolidation.shipment.add_actual_weight')}}",
			      data: $('#formid_create').serialize(),
			      dataType: "JSON",
			      success: function (response) {
			      if(response.status == 1)
			      {
			      	  
			        responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
			        $('.datatable').DataTable().draw();
			        $('#actual_weight_model').modal('hide');
			      }
			      },
			      error: function (jqXHR, exception) {
		           if (jqXHR.status == 422) {
		              var html_error = '';
		              $.each(jqXHR.responseJSON.errors, function (key, value)
		              {
		                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger "><button type="button" class="close m-t-15" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
		              })
		              html_error += "</ul></div>";
		              $('.error_msg_c_c').html(html_error);
		            }
		          
		        }
			});
    }
    function renderCustomBox(class_name,html){
    	var newaddress= html.clone(true);
	    	newaddress.find('input').each(function() {
    			this.name = this.name.replace('[0]', '['+i+']');
			});
			i++;
	    	$(class_name).append(newaddress);
	    	$(class_name).find('.hide-cross').removeClass('hide-cross');
    }
    function dynamicCalculation(e,clas_name){
    	var length = $(e).parent().parent().parent().find('.lenght').val();
    	var height = $(e).parent().parent().parent().find('.height').val();
    	var width  = $(e).parent().parent().parent().find('.width').val();
    	var weight = $(e).parent().parent().parent().find('.actual_weight').val();
     	var dimensional_weight = (length*width*height)/138.4;
    	var diff =  parseFloat(dimensional_weight) - parseFloat(weight);
        if(diff>0){
            if(diff < 16){
            }else if(diff > 15 && diff < 25){
               dimensional_weight = (length*width*height)/166;
            }else if(diff > 24){
               dimensional_weight = (length*width*height)/194;
            }
        }
        $(e).closest(clas_name).find('.dimensional_weight_hidden').val(dimensional_weight.toFixed(2));
    	$(e).closest(clas_name).find(".dimensional_weight").html('$ '+dimensional_weight.toFixed(2));
    }
</script>
@endsection