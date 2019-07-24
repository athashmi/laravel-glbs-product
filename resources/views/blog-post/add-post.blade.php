@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			<div class="inner">
				{{ Breadcrumbs::render('add_post') }}
			</div>
		</div>
	</div>
	<div class=" container-fluid   container-fixed-lg bg-white">
		<div class="card card-transparent">
			<div class="card-header ">
				<div class="card-title">
				</div>
				
				
				<div class="clearfix"></div>
			</div>
			<div class="container-fluid   container-fixed-lg" >
				<div class="card card-default">
					<div class="card-header ">
						<div class="card-title">Create Post
						</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
							<a class="config" data-toggle="modal" href="#grid-config"></a>
							<a class="reload" href="javascript:;"></a>
							<a class="remove" href="javascript:;"></a>
						</div>
					</div>
					<div class="card-body  no-scroll card-toolbar" >
						<form action="{{route('blog_post.store')}}" method="post" class="form_createpost"  enctype="multipart/form-data" novalidate role="form">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group form-group-default">
											<label>Title</label>
											<textarea class="form-control" id="title" name="title"></textarea>
										</div>
									</div>
									<div class="col-md-6">
									<div class="row">
									<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Type</label>
												<select name="type" id="type" class="select2 form-control">
													<option value="" selected>Select Type</option> 
													<option value="notification">Notification</option> 
													<option value="alert">Alert</option>
													<option value="update">Update</option>
													<option value="news">News</option> 
												</select>
											</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default form-group-default-select2">
											<label>Status</label>
											<select name="status" id="status" class="select2 form-control">
												<option value="" selected>Choose Status</option> 
												<option value="active">Active</option> 
												<option value="inactive">Inctive</option> 
											</select>
										</div>
									</div>
									</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-default form-group-default-select2">
								            <label>Please Choose Group</label>
								            <select class="form-control full-width select2" name="shopaholic_group[]" id="lll" multiple="multiple">
								              @foreach($group_shopaholics as $group_shopaholic)
								              <option value="{{$group_shopaholic->id}}">{{$group_shopaholic->name}}</option>
								              @endforeach
								            </select>
								        </div>
								    </div>

								    <div class="col-md-4">
										<div class="form-group form-group-default form-group-default-select2">
								            <label>Please Choose Shopaholics</label>
								            <select class="form-control full-width select2user" name="shopaholics[]" multiple="multiple">
								              
								            </select>
								        </div>
								    </div>


								    <div class="col-md-4">
										<div class="form-group form-group-default form-group-default-select2">
								            <label>Please Choose Country</label>
								            <select class="form-control full-width select2" name="country[]" multiple="multiple">
								              @foreach($countries as $country)
								              <option value="{{$country->id}}">{{$country->name}}</option>
								              @endforeach
								            </select>
								        </div>
								    </div>
							    </div>

								<div class="row">
									

										<div class="col-md-12">
										<div class="form-group form-group-default">
											<label>Summary</label>
											<textarea  class="height-1 form-control" id="summary" name="summary"></textarea>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group  form-group-default">
										<label>Choose Image</label>
										<input type="file" name="file" id="filer_input">
									</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
											<div class="form-group form-group-default">
												<label>Description</label>
												<textarea id="summernote" style="display: none"></textarea>
											</div>
									</div>
								</div>
								<div class="row pt-4">
										<div class="col-sm-12">
											<div class="error_msg_e_c"></div>
											<div class="pull-right">
												<button type="reset" class="btn btn-default m-r-20">Reset</button>
												<button type="submit" class="btn btn-primary btn-employee-add" >Send</button>
											</div>
										</div>
									</div>
									
							</form>
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
@include('revox-theme.js-css-blades.summernote')
@include('revox-theme.js-css-blades.select2')
@include('revox-theme.js-css-blades.image-upload')
@endsection
 @section('script')
 @parent
 <script type="text/javascript">
  function sendFile(file, editor, welEditable) {

		data = new FormData();
	    data.append("file", file);
	    $.ajax({
	        data: data,
	        type: 'POST',
	        url: "{{route('blog_post.imgstore')}}",
	        cache: false,
	        dataType: "JSON",
	        contentType: false,
	        processData: false,
	        success: function(response) {
	        	if(response.status == 1){
	        		editor.insertImage(welEditable, response.url);
	        	}
	            
	        }
	    });
}


 
 </script> 
 @endsection
@section('document_ready')
@parent

$('.select2').select2();
$('.select2-container').css('z-index','0');
$('#summernote').summernote({
    height: 200,
    onfocus: function(e) {
        $('body').addClass('overlay-disabled');
    },
    onblur: function(e) {
        $('body').removeClass('overlay-disabled');
    },	 
	onImageUpload: function(files, editor, welEditable) {
        sendFile(files[0], editor, welEditable);
    }, 
             
});


$(".form_createpost").on('submit',function(e){
e.preventDefault();
	var formData = new FormData(this); 
	formData.append('body',$("#summernote").code());

	 $.ajax({
          type: "POST",
          url: "{{route('blog_post.store')}}",
          data: formData,
          dataType: "JSON",
          cache: false,
   		  contentType: false,
   		  processData: false,
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
             setTimeout(function() { 
		    	window.location.replace("{{route('blog_post.index')}}");
		    }, 2000);
          }
          },
          error: function(jqXHR, exception){
            
            if (jqXHR.status == 422) {
              var html_error = '';
              $.each(jqXHR.responseJSON.errors, function (key, value)
              {
                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger" style="max-width:100%"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
              })
              html_error += "</ul></div>";
              $('.error_msg_e_c').html(html_error);
            }
        }
      }); 
});




$(".select2user").select2({
	    closeOnSelect: false,
	    placeholder: 'Search Shopaholic by SN, First/Last name or Email',
	    ajax: {
	        url: "{{route('blog_post.searchuser')}}",
	        dataType: 'json',
	        delay: 250,
	        data: function (params) {
	            
	            return {
	                q: params.term, // search term
	                page: 10
	            };
	        },
	        processResults: function (data, page) {
	        
	            return {
	                results: data
	            };
	        },
	        cache: true
	    },
	    escapeMarkup: function (markup) {
	        return markup;
	    }, // let our custom formatter work
	    minimumInputLength: 1,
	    templateResult: function(repo){
	    	if (repo.loading) return repo.text;

	    	return '<div class="clearfix">' +
        			'<div class="col-sm-12">' + repo.user.first_name +' '+repo.user.last_name+ '<b> ('+ repo.sn +')</b></div>'+
        			'<div class="col-sm-12"><b> ('+ repo.user.email +')</b></div></div>';
		},
	    templateSelection: function(repo){
	    	return repo.user.first_name+' ('+ repo.sn +')';
	}
	});

@endsection

