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
				<div class="card-title">Developers Docs Listings
				</div>
				<div class="pull-right">
					<div class="col-xs-12">
						<a href="{{route('docs.developers.create')}}" class="btn btn-primary float-sm-right"><i class="fa fa-plus"></i> Add </a>

					</div>
				</div>

				<div class="clearfix"></div>
			</div>
			<div class="card-body">
				<table class="table table-hover demo-table-search table-responsive-block datatable" id="">
					<thead>
						<tr>
							<th>Title</th>
							<th>Type</th>
							<th>Category</th>
							<th>Description</th>
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

@include('revox-theme.js-css-blades.datatables')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.select2')


@endsection
@include('revox-theme.js-css-blades.typeahead')
@section('document_ready')
@parent

    $(".datatable").css('width','100%');
    var id = 0;
    var datatbl = $('.datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('docs.developers.getdocs') }}',
    columns: [
        {data: 'title',"className": "text-center"},
        {data: 'type',"className": "text-center"},
        {data: 'category',"className": "text-center"},
        {data: 'description',"className": "text-center"},
        {data: 'action',orderable: false, searchable: false,"className": "text-center"}
    ],


    order: [[ 1, "asc" ]]
    });
    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
@endsection
