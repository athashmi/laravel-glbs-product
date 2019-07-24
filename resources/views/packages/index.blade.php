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
  <div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="card-header ">
        <div class="card-title">Package Listing
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <a href="{{route('package.create')}}" class="btn btn-primary float-sm-right color-white"><i class="fa fa-plus"></i> Add Package</a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <table class="table table-hover demo-table-search table-responsive-block datatable" id="">
          <thead>
            <tr>
              <th>Package Unique ID</th>
              <th>Shopaholic ID</th>
              <th>WareHouse Location</th>
              <th>Tracking Number</th>
              <th>Status</th>
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
 
@endsection

@section('document_ready')
@parent
    $(".datatable").css('width','100%');
    var id = 0;
    var datatbl = $('.datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('package.getpackagelist') }}',
    columns: [
        {data: 'package_id',"className": "text-center"},
        {data: 'shopaholic_id',"className": "text-center"},
        {data: 'warehouse_shelf_id',"className": "text-center"},
        {data: 'tracking_number',"className": "text-center"},
        {data: 'status',"className": "text-center"},
        {data: 'action',orderable: false, searchable: false,"className": "text-center"}
    ]
    }); 
    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
@endsection
 