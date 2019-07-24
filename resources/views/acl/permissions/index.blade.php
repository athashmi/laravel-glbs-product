@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('permission') }}
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
<div class="card-title">Permission Listing
</div>
<div class="pull-right">
<div class="col-xs-12">
<button id="show-modal" data-toggle = "modal" data-target = "#create_permission_model" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Add Permission
</button>

 

</div>
</div>

 
<div class="clearfix"></div>
</div>
<div class="card-body">
<table class="table table-hover demo-table-search table-responsive-block datatable" id="">
<thead>
 <tr>
    <tr>
        <th>Diplay Name</th>
        <th>Name</th>
        <th>Description</th>
        <th>Created at</th>
        <th>Action</th>
    </tr>
</tr>
</thead>
<tbody>

</tbody>
</table>
</div>
</div>

</div>



</div>


@include('acl.permissions.create_modal')
@include('acl.permissions.edit_modal')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.datatables')
@endsection
@section('script')
@parent
<script type="text/javascript">
$(document).ready(function() {
    $(".datatable").css('width','100%');
    var id = 0;
    var datatbl = $('.datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('permission.gets') }}',
    columns: [
        {data: 'display_name'},
        {data: 'name'},
        {data: 'description'},
        {data: 'created_at'},
        {data: 'action'}
    ]
    });


     
   $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
});
</script>
@endsection