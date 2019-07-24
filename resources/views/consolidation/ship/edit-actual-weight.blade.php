<!-- Model for create Country -->
    <div class="modal fade slide-right" id="edit_actual_weight_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Edit Box Detail Form</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
        <form method="POST" id="formid_create_edit" action="javascript:;" accept-charset="UTF-8">
      <div class="modal-body p-b-0">
                <div class="row row-sm-height paid_service form-group-default input-group padding-custom m-t-20 ma">
                	<div class="col-md-9 col-sm-height padding-20">
                		<button type="button" class="cross_btn hide-cross">×</button>
	                	<div class="btn-group btn-group-justified row w-100">
	                		<div class="btn-group col-5 p-l-10">
	                			<div class="form-group form-group-default"><label>Width</label> 
	                				<input type="number" name="arr[0][width]" class="form-control width width_edit field_c_class_edit">
	                			</div>
	                		</div>
	                		<div class="btn-group col-5 p-l-10">
	                			<div class="form-group form-group-default"><label>Height</label>
	                			  <input type="number" name="arr[0][height]" class="form-control height height_edit field_c_class_edit" >
	                			</div>
	                		</div>
	                		<div class="btn-group col-5 p-l-10">
	                			<div class="form-group form-group-default"><label>Length</label> 
	                				<input type="number" name="arr[0][lenght]" class="form-control lenght lenght_edit field_c_class_edit">
	                			</div>
	                		</div>
	                		<div class="btn-group col-5 p-l-10">
	                			<div class="form-group form-group-default"><label>Actual Weight</label> 
	                				<input type="number" name="arr[0][actual_weight]" class="form-control actual_weight actual_weight_edit field_c_class_edit">
	                			</div>
	                		</div>
	                		<input type="hidden" name="arr[0][dimensional_weight]" class="dimensional_weight_hidden_edit dimensional_weight_hidden">

	                	</div>

                	</div>
                	<div class="col-md-3 d-flex flex-column bg-master-lighter">
                		<h5 class="text-primary m-l-10 m-t-20">
                			Dimensional Weight
                			<br /> 
                			<b ><p class="m-t-10 dimensional_weight_edit dimensional_weight"> $ 0.00</p></b>
                		</h5>
                	</div>
            	</div>
				<div class="box_add_more_div_edit">
            	 
            	</div>
            	<button class="btn btn-primary m-t-15 add_more_box_edit"><i class="fa fa-plus"></i>Add More</button> 
    			<div class="form-group form-group-default m-t-10"><label>Choose Location</label> 
    				 <select name="location" class="select2 edit_select2 form-control full-width">
                        <option value="" selected>Choose at least one location</option>
                        @foreach($consolidation_locations as $location)
                        	<option value="{{$location->id}}">{{$location->name .'-'.$location->color}}</option>
                        @endforeach
                    </select>
    			</div>
    			<div class="col-md-12">
					<b></b>
					<div class="clearfix"></div>
					<input type="hidden" name="request_id" class="request_id_edit">
					<div class="goods_descriptions_edit"> 
					
					 
					</div>
					
				</div>
            <span class = "error_msg_c_c_update" ></span>
           <hr width="100%" />
            <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary btn-box-detail" onclick="updateBoxDetailSubmit()">Update</button>
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
  var html_edit;
    $(document).ready(function(){

    	html_edit = $('.paid_service').clone(true);
    	$(document).on('keyup','.field_c_class_edit',function(){
	    	dynamicCalculation($(this),'.paid_service');
	    });
	    $('.add_more_box_edit').on('click',function(){
	    	renderCustomBox('.box_add_more_div_edit',html_edit);
	    });
	    $('#edit_actual_weight_model').on('shown.bs.modal', function (e) {
    	  var quantity_input;
          var select_catgry;
          var width = [];
          var height = [];
          var lenght = [];
          var actual_weight = [];
          var dimensional_weight = [];
	      var id = $(e.relatedTarget).data('id');
	      $('.lenght').val('');
	      $('.height').val('');
	      $('.width').val('');
	      $('.actual_weight').val('');
	      $('.dimensional_weight_edit').html('$ 0.00');
	      $('.request_id_edit').val(id);
	      $('.box_add_more_div_edit').html('');
	      $('.error_msg_c_c_update').html('');
	       $.get('{{route('consolidation.shipment.edit_actual_weight')}}',{'id':id},function(response) {
	           if(response.status == 1){
	           	    var le = response.data.box_detail.length;
	           		if(le > 0){
	           			$.each(response.data.box_detail,function(key,value){
			              	width.push(value.width);
			               	height.push(value.height); 
			               	lenght.push(value.length);
			               	actual_weight.push(value.actual_weight);
			               	dimensional_weight.push(value.dimensional_weight);
			              	if(key < le-1){
			              		renderCustomBox('.box_add_more_div_edit',html_edit);
			              	}
	              		});
	           		
		           		
		           	  var widthi = $('.width_edit');
		              var heighti = $('.height_edit');
		              var lenghti  = $('.lenght_edit');
		              var actual_weighti  = $('.actual_weight_edit');

		              
		              $(widthi).each(function(key){
		              	$(this).val(width[key]);
		              });
		              $(heighti).each(function(key){ 
		              	 $(this).val(height[key]);
		              });
		              $(lenghti).each(function(key){
		              	$(this).val(lenght[key]);
		              });
		              $(actual_weighti).each(function(key){
		              	$(this).val(actual_weight[key]);
		              });
		              $('.dimensional_weight_edit').each(function(key){
		              	$(this).html("$ "+dimensional_weight[key]);
		              });
		              $('.dimensional_weight_hidden_edit').each(function(key){
		              	$(this).val(dimensional_weight[key]);
		              });
	              }
	              if(response.data.fetch_location){
	              	$('.edit_select2').val(response.data.fetch_location.consolidation_location_id).change();
	              }
	              
	              var goods_description = '';
	              var checked = '';
	              $.each(response.goods_description,function(key,value){
	              checked = '';
	              	if($.inArray( value.id, response.data.goods_description_ids ) >= 0){
	              		checked = 'checked';
	              	}else{
	              		checked = '';
	              	}
	              	goods_description += `<div class="input-group-prepend ">
						<input type="checkbox" `+checked+` name="goods_des[]" value="`+value.id+`" class=" m-t-10 m-r-10" >
						<p class="m-b-0 m-t-5">
						`+value.title+`	
						</p>
					</div>`;
	              });
	              $('.goods_descriptions_edit').html(goods_description);
	             }
	        },"json");
	    });
    });
    function updateBoxDetailSubmit(){
	    	$.ajax({
			      type: "POST",
			      url: "{{route('consolidation.shipment.update_actual_weight')}}",
			      data: $('#formid_create_edit').serialize(),
			      dataType: "JSON",
			      success: function (response) {
			      if(response.status == 1)
			      {
			      	  
			        responseMsg("update",'{{asset('images/icons8-ok-filled-480.png')}}');
			        $('.datatable').DataTable().draw();
			        $('#edit_actual_weight_model').modal('hide');
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
		              $('.error_msg_c_c_update').html(html_error);
		            }
		          
		        }
			});
    }
</script>
@endsection