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

				<div class="col-md-12">
					<br>
					<div class="card card-transparent ">
						<ul class="nav nav-tabs storage nav-tabs-fillup" data-init-reponsive-tabs="dropdownfx">
							<li class="nav-item col-md-2">
								<a href="javascript:void(0)" class="active package-ul-li-a" data-toggle="tab" data-target="#mystorage" data-type="my_storage" onclick="uuu('storage')">
									<i class="fa fa-hdd-o fa-lg m-r-10" aria-hidden="true"></i> MyStorage
								</a>
							</li>
							<li class="nav-item col-md-2">
								<a href="javascript:void(0)" class="package-ul-li-a" data-toggle="tab" data-target="#outgoing" data-type="outgoing" onclick="uuu('out')">
									<i class="fa fa-external-link fa-lg m-r-10"></i> OutGoing
								</a>
							</li>
							<li class="nav-item col-md-2">
								<a href="javascript:void(0)" class="package-ul-li-a" data-toggle="tab" data-target="#slide3">
									<i class="fa fa-truck fa_custom fa-lg m-r-10"></i> Shipped
								</a>
							</li>
							<li class="nav-item col-md-2">
								<a href="javascript:void(0)" class="package-ul-li-a" data-toggle="tab" data-target="#slide4">
									<img src="{{asset('images/delivered.png')}}" style="width: 16px" class="img-fluid m-r-10">Delivered
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane slide-left active" id="mystorage">
								<div class="row column-seperation">
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<!-- <div class="card-body table-border"> -->
											<div class="btn-group sm-m-t-10 top_button">
												<button type="button" data-toggle="modal" data-target="#consolidate_package_modal" class="btn btn-primary m-2"><i class="fa  fa-chain fa-lg"></i> Consolidate
												</button> 
												<button type="button" class="btn btn-default m-2"><i class="fa fa-copy fa-lg"></i>
												</button>
												<button type="button" class="btn btn-default m-2"><i class="fa fa-clipboard fa-lg"></i>
												</button>
												<button type="button" class="btn btn-default m-2"><i class="fa fa-paperclip fa-lg"></i>
												</button>
												<div class="clearfix"></div>
												
											</div>
											<hr style="width: 100%" />
											@if($layout == 'list')

												@include('frontend.dashboard.storage-ship.list')
											@else 

												@include('frontend.dashboard.storage-ship.grid')
											@endif
										<!-- </div> -->
									</div>
								</div>
							</div>
							<div class="tab-pane slide-left" id="outgoing">
								<!-- <div class="row"> -->
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<div class="btn-group sm-m-t-10 top_button">
											<button type="button" data-toggle="modal" data-target="#consolidate_package_modal" class="btn btn-primary m-2"><i class="fa  fa-chain fa-lg"></i> Consolidate
											</button> 
											<button type="button" class="btn btn-default m-2"><i class="fa fa-copy fa-lg"></i>
											</button>
											<button type="button" class="btn btn-default m-2"><i class="fa fa-clipboard fa-lg"></i>
											</button>
											<button type="button" class="btn btn-default m-2"><i class="fa fa-paperclip fa-lg"></i>
											</button>
											<div class="clearfix"></div>
										</div>
										<hr style="width: 100%" />
										<table class="table table-hover demo-table-search table-responsive-block datatable img_cell ship-storage" id="">
											<thead>
											    <tr>
											       <th>REQ-ID</th>
											       <th>Tracking #</th>
											       <th>Additional Info</th>
											       <th>Date Created</th>
											       <th>Delivery Address</th>
											       <th>Status</th>
											       <th>Action</th>
											    </tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								<!-- </div> -->
							</div>
							<div class="tab-pane slide-left" id="slide3">
								<div class="row">
									<div class="col-lg-12">
										<h3>Follow us &amp; get updated!</h3>
										<p>Instantly connect to what's most important to you. Follow your friends, experts, favorite celebrities, and breaking news.</p>
										<br>
									</div>
								</div>
							</div>
							<div class="tab-pane slide-left" id="slide4">
								<div class="row">
									<div class="col-lg-12">
										<h3>Follow us &amp; get updated!</h3>
										<p>Instantly connect to what's most important to you. Follow your friends, experts, favorite celebrities, and breaking news.</p>
										<br>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			
		</div>
	</div>
</div>

@include('frontend.dashboard.storage-ship.detail-modal')
@include('frontend.dashboard.storage-ship.outgoing.review-request')
@include('frontend.dashboard.storage-ship.outgoing.complete-custom-value')
@include('frontend.dashboard.storage-ship.outgoing-detail-modal')
@include('frontend.dashboard.storage-ship.split-modal')
@include('frontend.dashboard.storage-ship.custom-value')
@include('frontend.dashboard.storage-ship.consolidate')
@include('frontend.dashboard.storage-ship.return-package-modal')

@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.datatables')
@include('revox-theme.js-css-blades.classie')
@include('revox-theme.js-css-blades.select2')

@include('revox-theme.js-css-blades.pagination')
@endsection


@section('styles')
@parent
	<link href="{{URL::asset('css/package-list.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('script')
@parent
<script type="text/javascript">
	var out_free_ser = <?=json_encode($free_services); ?>;
	var package_outgoing_tbl ;
$(document).ready(function() {
	$(".top_button").hide();
	@php
		if(Session::get('status') == 1 && Session::get('paypal_res') == 1){
	@endphp
		responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}",'Payment sucscessfully processed...');
	@php
		}
	@endphp
	@php
		if(Session::get('status') == 0 && Session::get('paypal_res') == 1){
	@endphp
		responseMsg("error","{{asset('images/icons8-ok-filled-480.png')}}",'Something went wrong...');
	@php
		}
	@endphp

	$(".datatable").css('width','100%');
    //var id = 0;
     //var groupColumn = 4;

    

   $('.package-ul-li-a').on('click',function(e){
   	//console.log($(this).data('type'));
   		 e.preventDefault();
   
 		$('.package-ul-li-a').removeClass('active');
        let type = $(this).data('type');

          $(this).tab('show');
       
        $(this).addClass('active');

       /* if(type != 'my_storage')
        consolidateDataTablesInitiate(type);*/
        $('.ship-storage').DataTable().draw();

        
        //$('#zone-title').text(name.replace('_',' ')+' Zones');

        
      });


   $('.ship-storage').DataTable({
    processing: true,
    serverSide: true,
    retrieve: true,
    responsive: true,
    ajax: gs_window.getConRequests+'/outgoing',
    columns: [
        {data: 'unique_key',"className": "text-center"},
        {data: 'tracking_number',"className": "text-center","orderable": false},
        {data: 'additional_info',"orderable": false},
        {data: 'created_at',"className": "text-center"},
        {data: 'address',"orderable": false},
        {data: 'show_status',"className": "text-center","orderable": false},
        {data: 'action',"className": "text-center","orderable": false}
    ],
    
     order: [[ 2, "desc" ]],
         "drawCallback": function ( settings ) {
            var api = this.api();
            
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            $(rows).each(function(i,row){
            	var row_data = api.row(row).data();

            	var pay_pend_class ='';
            	var preparing_class = 'active';

            	var processing_class ='';
            	

            	if(row_data.status=='payment_pending')
            	{
            		pay_pend_class = 'active';
            		preparing_class = 'active done';
            	}

            	if(row_data.status=='processing')
            	{
            		processing_class = 'active';
            		preparing_class = 'active done';
            		pay_pend_class = 'active done';
            	}

            	
            	var html =`<tr class="b-l-r-2" >
							<td colspan="7">
            				<div class="md-stepper-horizontal orange">
							    <div class="md-step `+preparing_class+`">
							      <div class="md-step-circle"><span>1</span></div>
							      <div class="md-step-title">Preparing</div>
							      <div class="md-step-bar-left"></div>
							      <div class="md-step-bar-right"></div>
							    </div>
							    <div class="md-step `+pay_pend_class+`">
							      <div class="md-step-circle"><span>2</span></div>
							      <div class="md-step-title">Payment Pending</div>
							      <div class="md-step-optional">Optional</div>
							      <div class="md-step-bar-left"></div>
							      <div class="md-step-bar-right"></div>
							    </div>
							    <div class="md-step `+processing_class+`">
							      <div class="md-step-circle"><span>3</span></div>
							      <div class="md-step-title">Processing</div>
							      <div class="md-step-bar-left"></div>
							      <div class="md-step-bar-right"></div>
							    </div>
							    
							  </div>
							  </td>
							  </tr>
							<tr class="b-l-r-2 b-b-2 m-b-0-imp">
								<td class = "custom_package_listing`+i+`" colspan="7"></td>
							</tr>

							  <tr><td colspan="7" class="b-b-none"></td></tr>`;



				$(row).after(html);

				var b_l_r_2 =' b-l-r-2 b-t-2 m-b-0-imp ';

 				$(row).addClass(b_l_r_2);

 				$(row).children().addClass('b-b-none');

 				packageRender(row_data.packages,i);

            });
       }
    });

   
    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"}); 
    
});
 $(document).on("click", function () {
       
      	if($(".checkbox_package").is(":checked")){
      		$('.top_button').show();
      	}else{
    		$('.top_button').hide();
    	}
  });

 function uuu(e)
 {
 	console.log(e);
 }
 

	function packageRender(response,p){
		var sum = 0;
		var html = ``;
		var temp = ``;
		var i = 1; 
		var a = ''; 
		$.each(response,function(key,value){
			sum = 0;
			if(value.package_custom_detail.length > 0){
				temp = ``;
		 		temp += `<table class="table table-hover">
					<tbody>`;
					$.each(value.package_custom_detail,function(k,ite){
						temp += `<tr>
						<td class="font-montserrat all-caps fs-12 w-50">Item</td>
						<td class="font-montserrat all-caps fs-12 w-50"><b>Category:</b> `+ite.category.title+`</td>
						 <td class="w-25">
						<span class="font-montserrat fs-18"><b>Qty:</b> `+ite.quantity+`</span>
						</td>
						<td class="w-25">
						<span class="font-montserrat fs-18"><b>Value:</b> $`+ite.value+`</span>
						</td>
					</tr>`;
					sum = parseFloat(ite.value) + parseFloat(sum);
					});
				temp += `</tbody>
				</table>`;
		 	}else{
		 		temp = `<div class="list-group-item col-md-12 clearfix m-b-5">		
					<span class="pull-left">No Any Custom Value...</span>
				</div>`;
		 	}
			html += `<div class="col-lg-12 flex-row-custom pack`+value.id+`">
										<div data-pages="card" class="card card-default card-collapsed flex-row-custom" id="card-basic ">
											<div class="card-header p-b-0 m-b-0 ">
												<div class="row">
													<div class="col-md-1 col-sm-6 col-xs-6 pull-left">
														<b class="pull-left">Package </b>
													</div>
													<div class="col-md-3 col-sm-6 col-xs-6 pull-left">
														<b>Tracking : </b><span>`+value.tracking_number+`</span>
													</div>
													<div class="col-md-3">
														<b>ID : </b><span>`+value.package_id+`</span>
													</div>
													<div class="col-md-2">
														<b>Location : </b><span>`;
														if(value.warehouse_shelf){
															html += value.warehouse_shelf.name ;
														}else{
															html += 'NULL';
														}
														html +=`</span>
													</div>
													<div class="col-md-2">
														<button type="button" data-toggle="modal" data-id = "`+value.id+`" data-target="#return_custom_value_modal" class="btn  btn-primary btn-cons  pull-right from-top"><span>Custom Value</span></button>
													</div>
													<div class="col-md-1 ">
														<a data-toggle="collapse" class="card-collapse pg-ar-show pull-right " href="#"><i class="pg-arrow_maximize"></i></a>
													</div>
												</div>
											</div>
											<hr width="100%" class="m-0 p-0" />
											<div class="row card-body card-body-h" style="display:none">
											<div class="col-md-4 m-l-5 m-b-10">
												<div class="list-group-item col-md-12 clearfix m-b-5">		
													<span class="bold pull-left">Total custom Value :</span>
													<span class="pull-right">
														 <span class="color-normal sum_cus">$ `+parseFloat(sum).toFixed(2)+`</span>
													</span>
												</div>
												<div class="list-group-item col-md-12  clearfix m-b-5">
													<span class="bold pull-left">Package Uploaded At :</span>
													<span class="pull-right"> `+ value.created_at+` </span>
												</div>
												<div class="list-group-item col-md-12 clearfix m-b-5">
													<span class="bold pull-left">Storage Left :</span>
													<span class="pull-right value_custom_detail_page">`;
													var today = new Date();
												    var diff  = new Date(today - new Date(value.created_at));
												    var days  = diff/1000/60/60/24;
												    days = 180-parseInt(days);
												    if(days < 0){
												    	html += parseInt(days)+' Days';
												    }else{
												    	html += parseInt(days)+' Days';
												    }
												    
													html += `</span>
												</div>
												
											</div>
											<div class="col-md-3">
												<b>Package Image</b>
												<img src="`;
												if(value.primary_thumbnail){
													html += value.primary_thumbnail.image_name;
												}
												html += `" class="img-fluid m-t-10 img-thumbnail">
											</div>
											<div class="col-md-4">
												<b>Package Custom Value</b>
												 <div class="row m-t-10 m-l-5">
												 	 `;
												  
												 	html += temp;
														
														html += `</div>
												  
											</div>
											<div class="col-md-12">
												<hr width="100%"  />
											</div>
											<div class="col-md-4 m-l-10 m-b-10">
												<b>Paid Services </b>
												<div class="clearfix"></div>
												<div class="btn-group btn-group-justified row w-100 m-t-10 m-l-5 paid_append">
												`;
												if(value.paid_service.length > 0){
												$.each(value.paid_service,function(ind,valuee){
													html += `<div class="btn-group  col-5 p-l-10 m-b-10 m-r-10">

													
														<button type="button" class="backgroud-clr split_btn btn btn-default btni`+value.id+` my-checkfield my-checkfield-selected">
														<span class="p-t-5 p-b-5">
																<i class="fa fa-star fs-15"></i>
														</span>
														<br>
														<span class="fs-11 font-montserrat text-uppercase"><b>`+valuee.services.title+`</b></span>
														</button>
														
													</div>`;
												});
											}else{
												html += `<div class="list-group-item col-md-12 clearfix m-b-5">		
															<span class="pull-left">No Any Paid Service selected...</span>
														</div>`;
											}
											html +=`
												
													 
													 

													 
												</div>
											</div>
											
											<div class="col-md-4 m-b-10">
												<b>Free Services </b>
														<div class="clearfix"></div>
															`;
														//console.log(value.free_services);
														//if(value.free_services!= null && value.free_services.length > 0){
															$.each(out_free_ser, function(ind,valu){
																if($.inArray(valu.id.toString(),value.free_services) != '-1'){
																		a = 'checked';
																	}else{
																		a = '';
																	}

																	html +=`<div class="btn-group  col-12 p-l-10 m-b-10 m-r-10">

													
														<button type="button" class="backgroud-clr split_btn btn btn-default my-checkfield my-checkfield-selected">
														<span class="p-t-5 p-b-5">
																<i class="fa fa-star fs-15"></i>
														</span>
														<br>
														<span class="fs-11 font-montserrat text-uppercase"><b>`+valu.title+`</b></span>
														</button>
														
													</div>`;
															});
														 //}
												
											html += `</div>
											<!--  <div style="border-left:1px solid #e6e6e6;height:auto" class="m-b-10"></div> -->
											</div>
											</div>
										</div>
									</div>`;
			i++;
		});
		$('.custom_package_listing'+p).html(html);
	}

	$(document).on("click",'.pg-ar-show',function(){
			var el = $(this).find('i.pg-arrow_maximize');
			if(el.length > 0){
				el.addClass('pg-arrow_minimize');
				el.removeClass('pg-arrow_maximize');
				$(this).parent().parent().parent().parent().find('.card-body-h').show();
			}else{
				var pl = $(this).find('i.pg-arrow_minimize');
				pl.addClass('pg-arrow_maximize');
				pl.removeClass('pg-arrow_minimize');
				$(this).parent().parent().parent().parent().find('.card-body-h').hide();
			}
		});

</script>
@endsection