@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('list') }}
{{-- <ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Data Tables</li>
</ol> --}}

 
</div>
</div>
</div>



<div class=" container-fluid   container-fixed-lg bg-white">
<div class="card card-transparent">
<div class="card-header ">
<div class="card-title">Employees Listing
</div>
<div class="pull-right">
<div class="col-xs-12">
<a href="{{route('employee.create')}}"  class="btn btn-primary btn-cons"><i class="fa fa-plus"></i>Add Employee</a>

 

</div>
</div>

 
<div class="clearfix"></div>
</div>
<div class="card-body">
<table class="table table-hover demo-table-search table-responsive-block datatable">
<thead>
    <tr>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Date of Birth</th>
    <th>Picture</th>
    <th>Role</th>
    <th>Created_at</th>
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
@include('revox-theme.js-css-blades.select2')
 @include('revox-theme.js-css-blades.sweetalert')
@endsection
@section('script')

 
@parent

<script type="text/javascript">
$(document).ready(function() {
     $(".datatable").css('width','100%');
	var datatbl = $('.datatable').DataTable({
	processing: true,
	serverSide: true,
	ajax: '{{ route('employee.getemployee') }}',
	columns: [
	{data: 'full_name'},
    {data: 'email'},
	{data: 'phone'},
    {data: 'dob'},
    {data: 'picture'},
    {data: 'role'},
    {data: 'created_at'},
	{data: 'action',orderable: false, searchable: false, "className": "text-center"}
	]
	});

    //  datatbl.on( 'draw', function () {
    //     $("select.input-sm").select2({
    //       containerCssClass : "dt-select"
    //     });
    // });
     $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
});
</script>
@endsection