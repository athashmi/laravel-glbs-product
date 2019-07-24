@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('courier') }}
</div>
</div>
</div>



<div class=" container-fluid   container-fixed-lg bg-white">
<div class="card card-transparent">
<div class="card-header ">
<div class="card-title">Couriers Services
</div>
<div class="pull-right">
<div class="col-xs-12">
<button type="button" class="btn btn-primary float-sm-right" data-toggle = "modal" data-target = "#AddCourierModel"><i class="fa fa-plus"></i> Add Courier Service</button>

 

</div>
</div>
 
<div class="clearfix"></div>
</div>
<div class="card-body">
<table class="table table-hover demo-table-search table-responsive-block datatable" id="">
<thead>
 <tr>
    <th>Name</th>
    <th>Title</th>
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
@include('courier-manipulation.courier.add-courier-modal')
@include('courier-manipulation.courier.edit-courier-modal')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.datatables')
@endsection
@section('document_ready')
@parent
$(".datatable").css('width','100%');
  var datatbl = $('.datatable').DataTable({
  processing: true,
  serverSide: true,
  ajax: {"url" : "{{ route('courier.getcourier') }}"
  ,"data" : function(data){
  }
  },
  columns: [
  {data: 'name',"className": "text-center"},
  {data: 'title',"className": "text-center"},
  {data: 'action',orderable: false, searchable: false,"className": "text-center"}
  ],
  order: [[ 0, "asc" ]]
  });
   $("div.dataTables_length").parent().css({"flex-direction": "row"});
  $("div.dataTables_info").parent().css({"flex-direction": "row"});
@endsection

@section('scripts')
@parent
<script type="text/javascript">
  function deleteById(id){
    alert(id);
  }
</script>
@endsection
