@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			<div class="inner">
				{{ Breadcrumbs::render('shopaholic') }}
			</div>
		</div>
	</div>
	<div class=" container-fluid   container-fixed-lg bg-white">
		<div class="row">

			<div class="col-lg-12">
				<div class="col-md-12">
					<br>
					<div class="card card-transparent ">
						<ul class="nav nav-tabs storage nav-tabs-fillup" data-init-reponsive-tabs="dropdownfx">
							<li class="nav-item ">
								<a href="javascript:void(0)" class="active" onclick ="tabs_render('{{ route('consolidation.shipment.getConsolidatePackage','ordinary') }}','preparing')" data-toggle="tab" data-target="#slide1">
									<i class="fa fa-hdd-o fa-lg m-r-10" aria-hidden="true"></i>Preparing
								</a>
							</li>
							 
							<li class="nav-item ">
								<a href="javascript:void(0)" onclick ="tabs_render('{{ route('consolidation.shipment.get_pickup_pool') }}','pickup')" data-toggle="tab" data-target="#slide1">
									<i class="fa fa-truck fa_custom fa-lg m-r-10"></i>PickUp Pool
								</a>
							</li>
							<li class="nav-item ">
								<a href="javascript:void(0)" data-toggle="tab" onclick ="tabs_render('{{route("consolidation.shipment.getpendingpayment")}}','pending')"  data-target="#slide1">
									<img src="{{asset('images/delivered.png')}}" style="width: 16px" class="img-fluid m-r-10">Pending Payment
								</a>
							</li>
							<li class="nav-item ">
								<a href="javascript:void(0)" onclick ="tabs_render('{{route("consolidation.shipment.get_processing")}}','processing')" data-toggle="tab" data-target="#slide1">
									<img src="{{asset('images/delivered.png')}}" style="width: 16px" class="img-fluid m-r-10">Processing
								</a>
							</li>
							<li class="nav-item ">
								<a href="javascript:void(0)" data-toggle="tab" data-target="#slide1">
									<img src="{{asset('images/delivered.png')}}" style="width: 16px" class="img-fluid m-r-10">Shipped
								</a>
							</li>
							<li class="nav-item ">
								<a href="javascript:void(0)" onclick ="tabs_render('{{route("consolidation.shipment.get_on_hold")}}','onHold')" data-toggle="tab" data-target="#slide1">
									<img src="{{asset('images/delivered.png')}}" style="width: 16px" class="img-fluid m-r-10">On Hold
								</a>
							</li>
							<li class="nav-item ">
								<a href="javascript:void(0)" data-toggle="tab" data-target="#slide1">
									<img src="{{asset('images/delivered.png')}}" style="width: 16px" class="img-fluid m-r-10">SMSA
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane slide-left active" id="slide1">
								<div class="row column-seperation">

									<div class="col-lg-12">
										<div class="card-body table-border">
											<div class="top_button_generic_class">
												<div class="btn-group sm-m-t-10 top_button">
													<button type="button" data-toggle="modal" data-target="#consolidate_package_modal" class="btn btn-primary btn-cons btn-sm m-b-10">
														<i class="fa  fa-chain fa-lg"></i> Consolidate
													</button> 
													<button class="btn btn-success btn-cons m-b-10 btn-sm" type="button">
														<i class="fa fa-cloud-upload"></i> 
														<span class="">Upload</span>
													</button>
													<button class="btn btn-info pickup_btn btn-cons m-b-10 btn-sm" type="button" >
														<i class="fa fa-paper-plane"></i> 
														<span class="">MOVE IN PICKUP POOL</span>
													</button>
													<button class="btn btn-danger btn-cons m-b-10 btn-sm" type="button"  data-toggle="modal" data-target="#add_assign_employee_model">
														<i class="fa fa-warning"></i>
														<span class="">ASSIGN</span>
													</button>
												</div>
												<div class="btn-group sm-m-t-10 top_button_pickup">
													
													<button class="btn btn-primary out_pickup_btn btn-cons m-b-10 btn-sm" type="button" >
														<i class="fa fa-paper-plane"></i> 
														<span class="">MOVE OUT PICKUP POOL</span>
													</button>
													<button class="btn btn-danger btn-cons m-b-10 btn-sm" type="button"  data-toggle="modal" data-target="#add_assign_employee_model">
														<i class="fa fa-warning"></i>
														<span class="">ASSIGN</span>
													</button>
												</div>
												<div class="btn-group sm-m-t-10 top_button_processing">
													<button class="btn btn-primary out_pickup_btn btn-cons m-b-10 btn-sm" type="button" >
														<i class="fa fa-paper-plane"></i> 
														<span class="">INVOIVES</span>
													</button>
													<button class="btn btn-complete btn-cons m-b-10 btn-sm btn_label_generation" type="button"  >
														<i class="fa fa-warning"></i>
														<span class="">LABEL</span>
													</button>
													<button class="btn btn-info btn-cons m-b-10 btn-sm" type="button">
														<i class="fa fa-warning"></i>
														<span class="">COMBINE AIRBINEX SHIPMENTS</span>
													</button>
													<button class="btn btn-danger btn-cons m-b-10 btn-sm" type="button">
														<i class="fa fa-warning"></i>
														<span class="">REPORT</span>
													</button>
													<button class="btn btn-success btn-cons m-b-10 btn-sm" type="button">
														<i class="fa fa-warning"></i>
														<span class="">LABEL</span>
													</button>
													<button class="btn btn-complete btn-cons m-b-10 btn-sm" type="button">
														<i class="fa fa-warning"></i>
														<span class="">INVOICES</span>
													</button>
												</div>
												<div class="top_button">
													<hr width="100%" />
												</div>
											</div>
											
											<table class="table table-hover demo-table-search table-responsive-block table-responsive datatable img_cell" id="">
												<thead>
												    <tr>
												        <th><i class="fa fa-tablet fa-lg"></i></th>
												        <th>Request ID</th>
												        <th>Shopaholic</th>
												        <th>Tracking no</th>
												        <th>No Of Pkgs</th>
												        <th>Assign To</th>
												        <th>Actual Amount</th>
												        <th>Final Weight</th>
												        <th>Carrier</th>
												        <th>Submitted Date</th>
												        <th>Status</th>
												        <th>Action</th>
												    </tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.datatables')
@include('revox-theme.js-css-blades.classie')
@include('revox-theme.js-css-blades.select2')
@include('consolidation.ship.add-actual-weight')
@include('consolidation.ship.edit-actual-weight')
@include('consolidation.ship.preparing.assign-model')
@endsection
@section('styles')
@parent
<style type="text/css">
	th.sorting{
		width:auto !important;
	}
	th.sorting_asc{
		width:auto !important;
	}
	th.sorting_desc{
		width:auto !important;
	}
	th.sorting_disabled{
		width:auto !important;
	}
</style>
@endsection
@section('script')
@parent
<script type="text/javascript">
var datatbl;
var sThisVal = [];
$(document).ready(function() {

	$('.select2').select2();
   	$(".datatable").css('width','100%');
    var id = 0;
    datatbl = $('.datatable').DataTable({
		dom: 'Bfrtip',
		buttons:[],
	    processing: true,
	    serverSide: true,
	    ajax: '{{ route('consolidation.shipment.getConsolidatePackage','ordinary') }}',
	    columns: [
	        {data: 'checkBox',"orderable": false,"searchable": false,"className": "text-center"},
	        {data: 'unique_key',"orderable": false,"className": "text-center"},
	        {data: 'name',"className": "text-center"},
	        {data: 'tracking_number',"className": "text-center", "name" :'tracking_number'},
	        {data: 'no_of_pkgs',"className": "text-center"},
	        {data: 'assigned_to',"className": "text-center"},
	        {data: 'actual_amount',"className": "text-center"},
	        {data: 'final_weight',"className": "text-center"},
	        {data: 'courier_id',"className": "text-center"},
	        {data: 'created_at',"className": "text-center"},
	        {data: 'status',"className": "text-center"},
	        {data: 'action',"className": "text-center"},
	    ],
	     order: [[ 2, "desc" ]],
    });
    
    // if(datatbl.recordsTotal == 0){
    // 	$('.top_button_generic_class').hide();
    // }
 
	datatbl.button().add( 0, {
                    text: 'Ordinary',
                    className: 'btn btn-tag btn-click-bold btn-primary hide-p packages-btn',
                    action: function(e, dt, node, config) {
                            datatbl.ajax.url('{{ route('consolidation.shipment.getConsolidatePackage','ordinary') }}').draw();
                           $(dt.buttons('.btn-primary').nodes()).removeClass('btn-primary');
                           $('.packages-btn').addClass('btn-primary');
                           $('.top_button_generic_class').children().hide();
                        }
			});
	datatbl.button().add( 1, {
            text: 'Corporate',
            className: 'btn  btn-tag-right btn-click-bold hide-p consolidated-btn',
            action: function(e, dt, node, config) {
                  datatbl.ajax.url('{{ route('consolidation.shipment.getConsolidatePackage','corporate') }}').draw();
                  $(dt.buttons('.btn-primary').nodes()).removeClass('btn-primary');
                  $('.consolidated-btn').addClass('btn-primary');
                  $('.top_button_generic_class').children().hide();
                }
	});
    datatbl.column(3).visible(false);
    datatbl.column(8).visible(false);
    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});

    $('.pickup_btn').on('click',function(){
    	sThisVal = [];
    	selectedRequest();
	  	$.ajax({
	      type: "POST",
	      url: "{{route('consolidation.shipment.pickup_pool')}}",
	      data: {'ids':sThisVal},
	      dataType: "JSON",
	      success: function (response) {
	      if(response.status == 1)
	      {
	        responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
	          $('#add_assign_employee_model').modal('hide');
	          $('.top_button_generic_class').children().hide();
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
	          $('.error_add_assign_employee').html(html_error);
	       }
	      }
	    });
    });
    $('.out_pickup_btn').on('click',function(){
    	sThisVal = [];
    	selectedRequest();
	  	$.ajax({
	      type: "POST",
	      url: "{{route('consolidation.shipment.out_pickup_pool')}}",
	      data: {'ids':sThisVal},
	      dataType: "JSON",
	      success: function (response) {
	      if(response.status == 1)
	      {
	          responseMsg("insert",'{{asset('images/icons8-ok-filled-480.png')}}');
	          $('#add_assign_employee_model').modal('hide');
	          $('.top_button_generic_class').children().hide();
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
	          $('.error_add_assign_employee').html(html_error);
	       }
	      }
	    });
    });
    $(document).on('click','.btn_label_generation',function(){
    		$.each($("input[name='checkBox']:checked"),function(index){
    			var url = $(this).next('.label_url').val();
    			var win = window.open(url, '_blank');
  				win.focus();
    		});
    })
});
 function checkBoxTable(checkbox_class,top_btn_class,processing = '',e= ''){
   	if($(checkbox_class).is(":checked")){
   		$('.top_button_generic_class').show();
  		$(top_btn_class).show();
  	}else{
  		$('.top_button_generic_class').hide();
		$(top_btn_class).hide();
	}
	if(processing == 'processing'){
		if($(checkbox_class).is(":checked")){
			$(checkbox_class).hide();
		}else{
			$(checkbox_class).show();
		}
		$(e).show();
	}

  }
 function tabs_render(url,tab_name){
 		$('.top_button_generic_class').children().hide();
        datatbl.ajax.url(url).draw();
        if(tab_name == 'preparing'){
        	$('.hide-p').show();
        	datatbl.column(3).visible(false);
    		datatbl.column(8).visible(false);
        }
        if(tab_name == 'pending' || tab_name == 'pickup' || tab_name == 'onHold'){
        	$('.hide-p').hide();
        	datatbl.column(3).visible(true);
    		datatbl.column(8).visible(true);
        } 
        if(tab_name == 'processing'){
        	$('.hide-p').hide();
        	datatbl.column(3).visible(true);
    		datatbl.column(8).visible(true);
        }     
 }

 function onHold(id){
    swal({
        title: "You want to Hold the Request",
        text: '',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: 'Hold',
        cancelButtonText: "No, cancel please!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {
             $.ajax({
                    type: "POST",
                    url: "{{URL::route('consolidation.shipment.on_hold_request')}}",
                    data: {'id':id},
                    dataType: "JSON",
                    success: function (response) {
                      if(response.status == 1)
                      {
                        swal("Success", "Status Updated :)", "success");
                        $('.datatable').DataTable().draw();
                      }
                  },
                  error: function (jqXHR, exception) {
                      
                    }
            });
           }else {
            swal("Cancelled", "Your Request can't processed)", "error");
          }
    });
 }

  function reOpen(id){
    swal({
        title: "You want to ReOpen the Request",
        text: '',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: 'ReOpen',
        cancelButtonText: "No, cancel please!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {
             $.ajax({
                    type: "POST",
                    url: "{{URL::route('consolidation.shipment.re_open_request')}}",
                    data: {'id':id},
                    dataType: "JSON",
                    success: function (response) {
                      if(response.status == 1)
                      {
                        swal("Success", "Status Updated :)", "success");
                        $('.datatable').DataTable().draw();
                      }
                  },
                  error: function (jqXHR, exception) {
                      
                    }
            });
           }else {
            swal("Cancelled", "Your Request can't processed)", "error");
          }
    });
 }

function deleteById(rec_id,action_flag="")
      {
        //alert((window).del_url);

           swal({
                title: "Reason Why use Delete the Request.",
                text: '',
                type: "input",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
              	if (isConfirm === false){
              		swal("Cancelled", "Your data is safe :)", "error");
              		return false;
              	} 
                if (isConfirm === "") {
                	 swal.showInputError("You need to write something!");
                	 return false;
                }else{
                	 $.ajax({
                            type: "POST",
                            url:  (gs_window).del_url,
                            data: {'id' : rec_id,'reason':isConfirm},
                            dataType: "JSON",
                            success: function (data) {
                            if(data.status == 1)
                            {
                              swal("Success", "Deleted :)", "success");
                              if(action_flag=='refresh')
                                location.reload();
                              else
                              $('.datatable').DataTable().draw();
                            }
                            if(data.status == 0)
                            {
                              swal("Cancelled", "Somethign went wrong:)", "error");
                            }
                            },
                            error: function (jqXHR, exception) {
                            }
                          });         // submitting the form when user press yes
                } 
        });
      }
 
</script>
@endsection