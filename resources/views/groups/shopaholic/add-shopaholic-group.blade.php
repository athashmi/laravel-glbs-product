@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			<div class="inner">
				{{ Breadcrumbs::render('shopaholic_group') }}
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
				<div class="row">
					<div class="col-md-12">
						<div class="card card-default">
							<div class="card-header ">
								<div class="card-title">Create Shopaholic Group
								</div>
							</div>
							<div class="card-body  no-scroll card-toolbar" >
								<form action="{{route('blog_post.store')}}" method="post" class="form_create_shopaholic_group"  enctype="multipart/form-data" novalidate role="form">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Title</label>
												<textarea class="form-control" id="title" name="title"></textarea>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Name</label>
												<textarea class="form-control" id="name" name="name"></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Shopaholic Group</label>
												<select name="select_type_shopaholic" class="select2type form-control select_type_shopaholic">
													<option value="">Please Choose type</option>
													<option value="1">Individual Shopaholic</option>
													<option value="2">Shopaholic with filtration</option>
												</select>
											</div>
										</div>
									</div>
									
									<div class="row filter-b">
										<div class="col-md-12">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Shopaholic</label>
												<select name="shopaholic[]" id="select2shopaholic" class=" form-control full-width" multiple="">
												</select>
											</div>
										</div>
									</div>
									
									<div class="card filter-c col-md-6">
										<div class="card-header">
											Shopaholics
											<hr>
										</div>
										<div class="card-body">
											<div class="col-md-12">
												<div class="radio radio-primary" style="margin-top: -5px">
													<input type="radio" value="all"  name="shopaholics"  id="yes">
													<label for="yes">All</label>
												</div>
												
												<!-- <input type="checkbox">
												<label class="m-l-10"> All Shopaholic</label>-->
												
												<hr />
											</div>
											<div class="clearfix"></div>
											
											<div class="col-md-12">
												
												
												<div class="radio radio-primary" style="margin-top: -5px">
													<input type="radio" value="filtered"  name="shopaholics"  id="yess">
													<label for="yess">Select Filteration</label>
												</div>
											</div>

										<input type="hidden" name="mn">
										<input type="hidden" name="no_select">
											<div class="col-md-10 offset-md-1">

												<div class="form-group-default input-group padding-custom">
													<div class="input-group-prepend ">

														<span class="input-group-text">
															<input type="checkbox" name="gender_select" value="yes" class="m-r-5"> Gender
														</span>
													</div>
													

													<div class="form-check form-check-inline m-l-15">
														  <input class="form-check-input"  value="male" name="gender" id="male" type="radio">
														  <label for="male">Male</label>
														</div>
														<div class="form-check form-check-inline m-l-10">
														  <input class="form-check-input"  value="female" name="gender" id="female" type="radio">
														  <label for="female">Female</label>
														</div>
													
													
												</div>
											</div>

											<div class="col-md-10 offset-md-1 m-t-15">

												<div class="form-group-default input-group padding-custom">
													<div class="input-group-prepend ">

														<span class="input-group-text">
															<input type="checkbox" name="age_select" value="yes" class="m-r-5"> Age
														</span>
													</div>
													
														<input type="text" name="min"  placeholder="Min" class="form-control col-md-4 min-height-36">

														<b class="line-height-36 col-md-1"> - </b>

														<input type="text" name="max" placeholder="Max" class="form-control col-md-4 min-height-36">
													
													
												</div>
											</div>


											<div class="col-md-10 offset-md-1 m-t-15">

												<div class="form-group-default input-group padding-custom">
													<div class="input-group-prepend ">

														<span class="input-group-text">
															<input type="checkbox" name="type_select" value="yes" class="m-r-5"> Type
														</span>
													</div>
													
													<select class="select2  width-80 form-control" name="shopaholic_type" >
														 
														@foreach($shopaholic_types as $shopaholic_type)

														<option value="{{$shopaholic_type->type}}">{{ucwords($shopaholic_type->type)}}</option>
														@endforeach
													</select>
													
													
												</div>
											</div>
										<!-- Age -->

											<!-- End Age -->
											
											<!-- End Gender -->
											<!-- Countries -->
											
												
												<div class="col-md-10 offset-md-1 m-t-15">
													<input type="hidden" name="er">
													<div class="row ">
														<div class="col-md-12">
															<label> <input type="checkbox" name="countries_select" value="yes" class="m-r-5"> Countries </label>
														</div>
														<div class="col-md-12">
															<select class="select2 full-width form-control" name="countries[]" multiple="ture">
																<option value="">Please Choose country</option>
																@foreach($countries as $country)
																<option value="{{$country->id}}">{{$country->name}}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>
											
											<!-- End Countries -->
											
											
										</div>
									</div>
								</div>
								<div class="error_msg_w_c col-md-12"></div>
								<div class="row pt-4">
									<div class="col-sm-12">
										
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
				{{-- <div class="col-md-4">
					<div class="card card-default">
						<div class="card-header ">
							<div class="card-title">Filtration
							</div>
						</div>
						<div class="card-body  no-scroll card-toolbar" >
							<form action="{{route('blog_post.store')}}" method="post" class="form_createpost"  enctype="multipart/form-data" novalidate role="form">
								<div class="row">
									<div class="col-md-12">
										<label> Shopaholics</label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
										<div class="radio radio-primary">
											<input type="radio" value="yes" name="optionyes" id="shopaholic">
											<label for="shopaholic">All Shopaholic</label>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-12">
												<label> Age</label>
											</div>
											<div class="col-5 ">
												<div class="radio radio-primary col-2 pull-left " style="margin-top : -12px; margin-left: 18px; margin-right: 10px;">
													<input type="radio"  value="no" name="optionyes" id="nddo">
													<label for="nddo"></label>
												</div>
												<div class="col-7 pull-left">
													
													<input type="text"  placeholder="Min" class="form-control pull-left">
												</div>
											</div>
											<div class=" col-1 pull-left"><b style="line-height: 36px"> -</b></div>
											<div class="col-5">
												
												<div class="col-7 pull-left">
													
													<input type="text" placeholder="Max" class="form-control pull-left">
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-12">
										<div class="row ">
											<div class="col-12">
												<label> Gender </label>
											</div>
											
											<div class="col-3 radio radio-primary" style="margin-top : 7px">
												<input type="radio" value="yes"  name="optionyes" id="yes">
												<label for="yes">Male</label>
											</div>
											<div class="col-3 radio radio-primary" style="margin-top:9px">
												<input type="radio"  value="no" name="optionyes" id="no">
												<label for="no">Female</label>
											</div>
											
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-12">
										<div class="row ">
											<div class="col-12">
												<label> Countries </label>
											</div>
											<div class="col-12">
												<select class="select2 full-width form-control" multiple="ture">
													<option value="">Please Choose country</option>
													@foreach($countries as $country)
													<option value="{{$country->id}}">{{$country->name}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> --}}
			</div>
		</div>
	</div>
</div>
</div>
@include('revox-theme.js-css-blades.summernote')
@include('revox-theme.js-css-blades.select2')
@endsection
@section('document_ready')
@parent
$('.select2').select2({
placeholder: 'Please choose country'
});
$('.select2type').select2({
placeholder: 'Please select shopaholics based on country/zone'
});
$("#select2shopaholic").select2({
placeholder: 'Please choose  ',
closeOnSelect: false,
ajax: {
url: "{{route('blog_post.searchuser')}}",
dataType: 'json',
delay: 250,
data: function (params) {
return {
q: params.term,
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
},
minimumInputLength: 1,
templateResult: formatRepo,
templateSelection: formatRepoSelection
});
$(".select_type_shopaholic").change(function(){
if($(this).val() == 1){
$('.filter-b').show();
$('.filter-c').hide();
}
if($(this).val() == 2){
$('.filter-c').show();
$('.filter-b').hide();
}
});
$('.form_create_shopaholic_group').on('submit',function(e){
e.preventDefault();
$.ajax({
type: "POST",
url: "{{route('group.shopaholic.store')}}",
data: $('.form_create_shopaholic_group').serialize(),
dataType: "JSON",
success: function (response) {
if(response.status == 1)
{
responseMsg("insert","{{asset('images/icons8-ok-filled-480.png')}}");
$('.error_msg_w_c').html('');
setTimeout(function() {
window.location.href = "{{route('group.shopaholic.index')}}";
}, 2000);
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
$('.error_msg_w_c').html(html_error);
}
}
});
});
@endsection
@section('script')
@parent
<script>
function formatRepo(repo) {
if (repo.loading) return repo.text;
var markup = '<div class="clearfix">' +
'<div class="col-sm-6">' + repo.user.first_name +' '+repo.user.last_name+ '<b> ('+ repo.sn +')</b></div></div>';
return markup;
}
function formatRepoSelection(repo) {
		return repo.user.first_name+' ('+ repo.sn +')';
}
</script>
@endsection