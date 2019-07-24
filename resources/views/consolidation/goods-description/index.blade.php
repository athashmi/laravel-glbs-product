@extends('revox-theme.layout.main')
@section('content')
<div class="content">
  <div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      <div class="inner">
        {{ Breadcrumbs::render('goods_description') }}
      </div>
    </div>
  </div>
  <div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="card-header ">
        <div class="card-title">Goods Description Listing
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <button type="button" class="btn btn-primary float-sm-right" data-toggle = "modal" data-target = "#create_goods_description_model"><i class="fa fa-plus"></i> Add Good</button>
          </div>
        </div>
        
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <table class="table table-hover demo-table-search table-responsive-block datatable" id="">
          <thead>
            <tr>
              <th>Title</th>
              <th>Description</th>
              <th>Amount</th>
              <th>Carrier</th>
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
@include('consolidation.goods-description.create_modal')
@include('consolidation.goods-description.edit_modal')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.datatables')
@include('revox-theme.js-css-blades.select2')
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
    ajax: '{{ route('consolidation.goods_description.getgoodsdescription') }}',
    columns: [
        {data: 'title',"className": "text-center"},
        {data: 'description',"className": "text-center"},
        {data: 'amount',"className": "text-center"},
        {data: 'allowed_carriers',"className": "text-center"},
        {data: 'action',orderable: false, searchable: false,"className": "text-center"}
    ]
    });

    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
    $('.select2').select2();
});
 

</script>
@endsection