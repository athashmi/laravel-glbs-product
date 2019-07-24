@extends('revox-theme.layout.main')
@section('content')
<div class="content">
  <div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      <div class="inner">
        {{ Breadcrumbs::render('failed_transaction') }}        
      </div>
    </div>
  </div>
  <div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="card-header ">
        <div class="card-title">Failed Transaction Listing
        </div>
        <div class="pull-right">

        </div>
        
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <table class="table table-hover demo-table-search table-responsive-block datatable" id="">
          <thead>
            <tr>
              <th>Name</th>
              <th>Error Code</th>
              <th>Error Message</th>
              <th>Payment GateWay</th>
              <th>Created_at</th>
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
@section('script')
@parent
<script type="text/javascript">
$(document).ready(function() {
     $(".datatable").css('width','100%');
    var id = 0;
    var datatbl = $('.datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('shopaholic.get_failed_transaction') }}',
    columns: [
        
        {data: 'name',"className": "text-center"},
        {data: 'error_code',"className": "text-center"},
        {data: 'error_msg',"className": "text-center"},
        {data: 'payment_gateway',"className": "text-center"},
        {data: 'created_at',"className": "text-center"},
    ],
    "order": [[ 4, "desc" ]]
    }); 
    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
 
});

</script>
@endsection