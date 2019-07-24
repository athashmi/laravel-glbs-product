@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			<div class="inner">

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
						<div class="card-title">Edit Doc
						</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
							<a class="config" data-toggle="modal" href="#grid-config"></a>
							<a class="reload" href="javascript:;"></a>
							<a class="remove" href="javascript:;"></a>
						</div>
					</div>
					<div class="card-body  no-scroll card-toolbar" >
						<form action="{{route('docs.developers.update')}}" method="post" class="form_createdoc"  novalidate role="form">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label>Title</label>
										<textarea class="form-control" id="title" name="title">{{$docs->title}}</textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Type</label>
												<select name="type" id="type" class="select2 form-control">
													<option value="">Select Type</option>
													<option {{$docs->type == 'developers' ? 'selected' : ''}} value="developers">Developers</option>
													<option {{$docs->type == 'users' ? 'selected' : ''}} value="users">Users</option>

												</select>
											</div>
										</div>

									</div>
								</div>
                <div class="col-md-6">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Category</label>
												<select name="category" id="category" class="select2 form-control">
													<option value="">Select Type</option>
													<option {{$docs->category == 'theme' ? 'selected' : ''}} value="Theme">theme</option>

												</select>
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="row">

								<div class="col-md-12">
									<div class="form-group form-group-default">
										<label>Description</label>
										<textarea class="height-1 form-control" max="150" id="description" name="description">{{$docs->description}}</textarea>
									</div>
								</div>
							</div>

			 			   <div class="row pt-4">
								<div class="col-sm-12">
									<div class="error_msg_e_u"></div>
									<div class="pull-right">
										<button type="submit" class="btn btn-primary btn-employee-add">Update</button>
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

 $(".form_createdoc").on('submit',function(e){

e.preventDefault();
	var formData = new FormData(this);
	formData.append('id',{{$docs->id}});
	 $.ajax({
          type: "POST",
          url: "{{route('docs.developers.update')}}",
          data: formData,
          dataType: "JSON",
          cache: false,
   		  contentType: false,
   		  processData: false,
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");
            setTimeout(function() {
         window.location.replace("{{route('docs.developers.list')}}");
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
              $('.error_msg_e_u').html(html_error);
            }
        }
      });
});

@endsection
