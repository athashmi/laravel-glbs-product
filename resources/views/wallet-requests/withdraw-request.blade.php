@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('withdraw_request') }} 
</div>
</div>
</div>



<div class=" container-fluid container-fixed-lg bg-white">
<div class="card card-transparent">
<div class="card-header ">
<div class="card-title">Withdraw Request
</div>
 
<div class="clearfix"></div>
</div>
<div class="card-body">
<table class="table table-hover demo-table-search table-responsive-block datatable" id="">
<thead>
  <tr>
    <th>Name</th>
    <th>Bank Name</th>
    <th>Account No</th>
    <th>Total Withhdraw</th>
    <th>Wallet Balance</th>
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
@include('wallet-requests.withdraw-detail-modal')
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
    ajax: '{{ route('wallet_request.getwithdrawrequest') }}',
    columns: [
        {data: 'name',name:'name',"className": "text-center"},
        {data: 'details',name:'details',"className": "text-center"},
        {data: 'account_no',name:'account_no',"className": "text-center"},
        {data: 'amount',name:'wallet_balance',"className": "text-center"},
        {data: 'wallet_balance',name:'wallet_balance',"className": "text-center text-c-blue"},
        {data: 'status',name:'status',"className": "text-center"},
        {data: 'action',orderable: false, searchable: false,"className": "text-center"}
    ]
    });

 // datatbl.on( 'draw', function () {
 //      $("select.input-sm").select2({
 //          containerCssClass : "dt-select"
 //        });
 //    } );
 $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});

});



function requestApprovedType(type,rec_id)
{
        swal({
            title: "Details",
            text: "Please Provide Details if any",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "Remarks",
            closeOnCancel: false
        }, function (inputValue) {

                  
             
            if (inputValue === "") {
                swal.showInputError("You need to write something!");
                return false
            }
            if(inputValue){
            $.ajax({
                type: "POST",
                url:  (gs_window).del_url,
                data: {'id' : rec_id,'remarks':inputValue,'type':type,'_token':"<?php echo csrf_token(); ?>"},
                dataType: "JSON",
                success: function (response) {
                if(response.status == 1)
                {
                swal("Success", "User Request has been Processed", "success");
                $('.datatable').DataTable().draw();
                }
                if(response.status == 0)
                {
                  swal("Success", "User Request has been Rejected", "success");
                  $('.datatable').DataTable().draw();
                }
                },
                error: function (jqXHR, exception) {
                }
              });
            //swal("Nice!", "You wrote: " + inputValue, "success");
         }else{
            swal("Cancelled", "Your data is safe :)", "error"); 
         }
        });

}


</script>
@endsection