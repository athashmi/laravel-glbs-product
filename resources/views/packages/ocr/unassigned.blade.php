@extends('revox-theme.layout.main')
@section('content')

<div class="content">
	<div class="jumbotron" data-pages="parallax">
	    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
	      <div class="inner">
	        {{ Breadcrumbs::render('packages') }}
	      </div>
	    </div>
	  </div>
	<div class="container-fluid   container-fixed-lg bg-white">
	    <div class="card border-none">
	        <div class="card-body">
	        	@if($package_exists)
	        	<div class="row m-t-10">
		            <div class="col-md-6">
		                <form class="form-inline" method="post"  enctype="multipart/form-data" action="{{route('package.unassigned.import_tracking_numbers')}}">
		                	@csrf
		                    <div class="form-group border-all m-r-5">
		                        <div class="file-upload-wrapper p-8">
							      	<input name="excelSheet" type="file" class="file-upload-field" value="">
									
							      </div>

		                    </div>
		                    <div class="form-group">
		                        <input type="submit" value="Upload File" class="p-12 btn btn-primary">
		                    </div>

		                    @if ($errors->any())
							    @if($errors->has('excelSheet'))  
							    <br/>	
									<div class="alert alert-danger">{{$errors->first('excelSheet')}}</div>
							    @endif  	
							@endif
		                </form>
		            </div>
		            <div class="col-md-6">
		                <form class="pull-right form-inline" method="post" action="" enctype="multipart/form-data" >
		                    <div class="form-group pull-right">
		                        <input type="submit" class="pull-right btn btn-success" value="Generate Report">
		                    </div>
		                </form>
		            </div>
					<div class="col-lg-12">
		        	<form method="post" action="{{route('package.unassigned.assign_package')}}" method="post" onsubmit="return validateForm()">
		          		@csrf
		          		<input type="hidden" name="pkg_location" value="{{$item->location}}">
			            <div class="col-md-12 border-all p-12 m-t-5 m-b-5">
			            	<div class="col-lg-6 pull-left"> UNASSIGNED PACKAGES - <b>{{$unassigned_package->currentPage()}}</b> OUT OF <b>{{$unassigned_package->total()}}</b></div>

			            	<div class="col-lg-6 pull-right"> 
			            		<div class="dataTables_wrapper">
			            			<div class="pagination-div pull-right dataTables_paginate paging_simple_numbers">
				            		
				            			{{$unassigned_package->links()}}
				            		</div>
				            	</div>
			            	</div>
			            	<div class="clearfix"></div>
			            </div> 
						
						
			                <div class="col-lg-4 pull-left p-l-0">
			                	<div class="card">
			                		<div class="card-body">
					                    <div class="form-group ">
					                    	<h4 class="p-5">
					                    		Shopaholics
					                    	</h4>
					                    	@php
					                    		$users_col = collect($users);
					                    		
					                    	@endphp
											<div class="radio radio-primary">
						                    	@foreach($users_col as $user)
						                    	@if($user)
							                    	<input type="radio" name="shopaholic_select" class="shopaholic_radio_btn m-l-5 p-5 m-r-5" value="{{$user->shopaholic->id}}" id="shp-{{$user->shopaholic->id}}" @if(old('shopaholic_select') == $user->shopaholic->id) checked @endif>
							                    		<label for="shp-{{$user->shopaholic->id}}">{{$user->first_name}} {{$user->last_name}} 
							                    		<b>({{strtoupper($user->shopaholic->sn)}})</b></label>
							                    	<br>
							                    @endif
						                    	@endforeach
						                    </div>
					                        <label for="inputfile" class="p-5 m-l-5">
					                        	Enter Shopaholic ID :
					                        </label>
					                        <select id="shopaholic_select" name="shopaholic_select" class="shopaholic_select form-control m-l-5 col-lg-12">
					                        	
					                        </select>

					                         @if ($errors->any())
							      				@if($errors->has('shopaholic_select'))
							      				 <br/>	
											    	<div class="alert alert-danger">{{$errors->first('shopaholic_select')}}</div>
									      		@endif
											@endif
					                        <hr width="100%" />
					                    </div>
					                    <input type="hidden" name="img_url" value="{{$item->label_url}}">
					                    <input type="hidden" name="ocr_data_id" value="{{$item->id}}">
					                    <div class="form-group ">
					                    	<h4 class="p-5">
					                    		Tracking Number
					                    	</h4>
					                        <div class="radio radio-primary">
						                    	@foreach($tracking_numbers as $t_n)
						                    	
							                    	<input type="radio" name="tracking_radio_input" class="tracking_radio_input m-l-5 p-5 m-r-5" value="{{$t_n}}" id="t_n-{{$t_n}}" @if(old('tracking_radio_input') == $t_n) checked @endif>
							                    		<label for="t_n-{{$t_n}}">{{$t_n}}</label>
							                    	<br>
							                    	
						                    	@endforeach
						                    </div>
					                        <label for="inputfile" class="p-5 m-l-5">
					                        	Enter Tracking Number :
					                        </label>
					                        <input type="text" name="tracking_number_input" id ="tracking_number_search" class="tracking_number_input p-5 m-l-5 form-control" value="{{old('tracking_number_input')}}">
					                        @if ($errors->any())
							      				@if($errors->has('tracking_number_input'))
							      				 <br/>	
											    	<div class="alert alert-danger">{{$errors->first('tracking_number_input')}}</div>
									      		@endif
											@endif
					                    </div>
					                    <div class="form-group">
					                    	<input type="submit" value="ASSIGN"  class="btn btn-primary pull-right m-b-10">  
					                	</div>
					                </div>
				                </div>
			                </div>
			                <div class="col-lg-8 pull-right no-padding">
								{{--@foreach($unassigned_package->items() as $item)--}}
								<div class="card">
			                		<div class="card-body">
			                		<img class="package_img img-fluid" src="{{$item->label_url}}" data-largesrc="{{$item->label_url}}"  /> 
			                	</div>
			                	</div>
			                   {{-- @endforeach --}}
			                	<div class="clearfix"></div>
			            	</div>
							<div class="clearfix"></div>
			            	<div class="col-lg-12 border-all p-12 m-t-5 m-b-5"> 
			            		<div class="dataTables_wrapper">
			            			<div class="pagination-div pull-right dataTables_paginate paging_simple_numbers">
				            		
				            			{{$unassigned_package->links()}}
				            		</div>
				            	</div>
				            	<div class="clearfix"></div>
			            	</div>
			            
		            </form>	
		            </div>

		        </div>
				@else
				 No Data Found.
				 @endif
	    	</div>
		</div>
	</div>
</div>


@endsection
@section('styles')
@parent
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection


@section('script')
@parent
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@endsection
@section('style')
@parent
.dataTables_wrapper .dataTables_paginate {
    margin-top: 0px !important; 
}
.dataTables_wrapper .pagination {
    margin-bottom: 0px !important; 
}
.pagination-div {
     padding: 0; 
}
ui-autocomplete-loading {
    background: white url("{{asset('images/ui-anim_basic_16x16.gif')}}") right center no-repeat;
  }
@endsection




@section('document_ready')
@parent

	$('.tracking_radio_input').change(function(){
		$('.tracking_number_input').val('');
	});
	$('.tracking_number_input').keyup(function(){
		$('.tracking_radio_input').prop('checked',false);
	});

	$('.shopaholic_radio_btn').change(function(){
		$('.shopaholic_select').val('').change();
	});
	$('.shopaholic_select').change(function(){
		if($(this).val() != null){
			$('.shopaholic_radio_btn').prop('checked',false);
		}
		
	});
	

	$('.package_img').zoomio({
		scale:5
	});

	$('.pagination').addClass('pagination-la');
	$('span.page-link').addClass('current').removeClass('page-link');
	$('a.current').parent().addClass('active');

	$('#shopaholic_select').select2({
	width: '100%',
	placeholder: 'Search Shopaholic by SN #, First/Last name',
		  ajax: {
		    url: '{{route("package.unassigned.get_shopaholic_for_ocr")}}',
		    dataType: 'json',
		    processResults: function (data) {
		        return {
		        	results: data
		      	};
		    }
		  }
		});

$('#tracking_number_search').autocomplete({
      source: function( request, response ) {
        $.ajax( {
        	type: "POST",
          url: "{{route('package.unassigned.trac_num_auto_complete')}}",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data);
          }
        } );
      },
      minLength: 4,
      select: function( event, ui ) {
        //console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
      }
    } );	
@endsection
@section('script')
@parent
<script type="text/javascript">

	@if(Session::has('msg'))
	    $(document).ready(function(){
	    	responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}","Package assigned successfully.");
	    @php 
	    	session()->forget('msg');
	    @endphp
	    });
	@endif
</script>

@endsection
@include('revox-theme.js-css-blades.zoomio')
@include('revox-theme.js-css-blades.select2')


