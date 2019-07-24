@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('roles') }}
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
<div class="card-title">Roles Listing
</div>
<div class="pull-right">
<div class="col-xs-12">
<button id="show-modal" data-toggle = "modal" data-target = "#CreateRoleModel" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Add Role
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


@include('acl.roles.edit_modal')
@include('acl.roles.create_modal')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.datatables')
@include('revox-theme.js-css-blades.select2')
@endsection
@section('script')
@parent
<script type="text/javascript">
$(document).ready(function() {

  /**************************************
          thst thing is used to configure select 2 with mode
  ***************************************/
  // $(".permission_assign").select2({
  //   multiple: true,
  //   dropdownParent: $('#CreateRoleModel'),
  //   tags:true,
  //   allowClear:true,
  //   placeholder: 'Please choose permissions'
  // });
  $('.permission_assign').val([]).select2({
    placeholder: "Select permissons",
     
       
  });
  $('.permission_assign_edit').val([]).select2();
  // $(".permission_assign_edit").select2({
  //   multiple: true,
  //   dropdownParent: $('#EditRoleModel'),
  //   tags:true,
  //   allowClear:true,
  //   placeholder: 'Please choose permissions'
  // });
  //var id = 0;
   $(".datatable").css('width','100%');
  var datatbl = $('.datatable').DataTable({
  processing: true,
  serverSide: true,
  ajax: '{{ route('role.getroles') }}',
  columns: [
    {data: 'display_name'},
    {data: 'name'},
    {data: 'description'},
    {data: 'created_at'},
    {data: 'action',orderable: false, searchable: false, "className": "text-center"}
  ]
  });
// datatbl.on( 'draw', function () {
//     $("select.input-sm").select2({
//           containerCssClass : "dt-select"
//         });
// } );


  /** validate username **/
   $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
  var regexname="^[a-zA-Z0-9_.]*$";
      $('#e_name').on('keyup',function(){
             if ($(this).val().match(regexname)) {
             }
           else{
              var strng = $(this).val();
        $("#error_msg").html('<p class="alert alert-danger error_message">Special character and space not allowed...</p>');
        setTimeout(function(){
            $("#error_msg").html('');
        },2000);
                $(this).val(strng.substring(0,strng.length-1));
               }
         });

      var regexname="^[a-zA-Z0-9_.]*$";
      $('#e_name_create').on('keyup',function(){
             if ($(this).val().match(regexname)) {
             }
           else{
              var strng = $(this).val();
        $("#error_msg_create").html('<p class="alert alert-danger error_message">Special character and space not allowed...</p>');
        setTimeout(function(){
            $("#error_msg_create").html('');
        },2000);
                $(this).val(strng.substring(0,strng.length-1));
               }
         });

});
function getPermission(){
  var url = $("#get_permission_11").val();
  $.ajax({
      type: "get",
      url: url,
      dataType: "JSON",
      success: function (response) {
      if(response.status == 1)
      {
         var htmls = '<label>Permission</label>';
        $.each(response.permissions, function(key,item) {

            htmls += '<option value="'+item.id+'">'+item.display_name+'<option>';

        });
         $('.permission_assign').html(htmls);
      }
      if(response.status == 0)
      {
        $('.permission_here').html('');
      }
      },
      error: function (jqXHR, exception) {
      }
    });

}
</script>
@endsection