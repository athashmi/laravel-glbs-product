@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			
		</div>
	</div>
	<div class="bg-white">
		<div class="card card-transparent">
			<div class="card-header ">
				<div class="card-title">
				</div>
				<div class="pull-right">
					
				</div>
				
				<div class="clearfix"></div>
			</div>
			<div class="card-body">
				 {!! html_entity_decode($blog_post->body) !!}
			</div>
		</div>
		
	</div>
</div>


	



@endsection
