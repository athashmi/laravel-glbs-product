@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			<div class="inner">
				{{ Breadcrumbs::render('add_employee') }}
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
			<div class=" container-fluid   container-fixed-lg">
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-default">
							<div class="card-header ">
								<div class="card-title">
									<h5>
									Add Package
									</h5>
								</div>
							</div>
							<div class="card-body">
								<form action="{{route('package.store')}}" method="post" class="j-pro form-employee-add"  enctype="multipart/form-data" novalidate role="form">
									@csrf
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>description </label>
												<input type="text" id="description " class="form-control" name="description" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>tracking_number</label>
												<input type="text"  id="tracking_number" class="form-control" name="tracking_number" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>status</label>
												<select name="status" class="form-control">
													<option value=""> Please Choose status</option>
													<option value="shipped">shipped</option>
													<option value="review">review</option>
													<option value="hold">hold</option>
													<option value="sorted">sorted</option>
													<option value="returned">returned</option>
													<option value="delivered">delivered</option> 
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>shopaholic_id</label>
												<input type="text" class="form-control"  placeholder="shopaholic_id" id="shopaholic_id" name="shopaholic_id" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Image Name</label>
												<input type="text" class="form-control"  placeholder="shopaholic_id" id="img_name" name="image_name" required>
											</div>
										</div>
									</div>
									<div class="row">
										
										<div class="col-sm-12">
											<div class="error_msg_e_c"></div>
											<div class="pull-right">
												<button type="submit" class="btn btn-primary btn-employee-add">Send</button>
												<button type="reset" class="btn btn-default m-r-20">Reset</button>
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
	</div>
	
 
	
	@endsection
	 

