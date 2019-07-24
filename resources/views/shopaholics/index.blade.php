@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('shopaholic') }}
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
<div class="card-title">Shopaholics Listing
</div>
 
<div class="clearfix"></div>
</div>
<div class="card-body">
<table class="table table-hover demo-table-search table-responsive-block datatable" id="">
<thead>
 <tr>
    <th>Serial Number</th> 
    <th>Name</th>
    <th>Email</th>
    <th>Balance</th>
    <th>User Type</th>
    <th>Member Since</th>
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



@include('shopaholics.update-wallet.update-wallet-modal')
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
    ajax: '{{ route('shopaholic.getshopaholics') }}',
   /* buttons: [
            
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],*/
    columns: [
        {data: 'sn',name:'sn',className: "text-center clickable"},
        {data: 'name',name:'name',className: "text-center clickable"},
        {data: 'user.email',name:'user.email',className: "text-center clickable"},
        {data: 'balance',"className": "text-center",name:'balance'},
        {data: 'shopaholics.type',"className": "text-center",name:'shopaholics.type'},
        {data: 'user.created_at',"className": "text-center",name:'user.created_at'},
        {data: 'action',orderable: false, searchable: false,className: "text-center actions"}
    ],
    "order": [[ 5, "desc" ]],
    search: {
        "regex": true
    }
    });
    
    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});

    datatbl.on( 'click', 'tr>td.clickable', function (e) {
           //console.log($(this).parent().attr('id'));

        window.location = $(this).closest('tr').children('td.actions').children('.dropdown-menu').children('.profile-url').attr("href");

         });
 
});


function statusChanges(status,id)
{
    if(status == 'active'){
     swal({
                title: "You want to DeActive the Status",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'DeActivate',
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
                if (isConfirm) {
                     $.ajax({
                            type: "POST",
                            url: "{{URL::route('warehouse.update_status')}}",
                            data: {'id':id,'status':'inactive'},
                            dataType: "JSON",
                            success: function (response) {
                              if(response.status == 1)
                              {
                                swal("Success", "Status Updated :)", "success");
                                $('.datatable').DataTable().draw();
                              }
                          },
                          error: function (jqXHR, exception) {
                              
                            }
                    });
                   }else {
                    swal("Cancelled", "Your Status can't update)", "error");
                  }
        });
 }
 if(status == 'inactive'){
     swal({
                title: "You want to DeActive the Status",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Activate',
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                            type: "POST",
                            url: "{{URL::route('warehouse.update_status')}}",
                            data: {'id':id,'status':'active'},
                            dataType: "JSON",
                            success: function (response) {
                              if(response.status == 1)
                              {
                                swal("Success", "Status Updated :)", "success");
                                $('.datatable').DataTable().draw();
                              }
                          },
                          error: function (jqXHR, exception) {
                              
                            }
                    });
                   }else {
                    swal("Cancelled", "Your Status can't update)", "error");
                  }
        });
 }
}




</script>
@endsection

