@extends('revox-theme.layout.main')
@section('content')
<div class="content">
  <div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      <div class="inner">
        {{ Breadcrumbs::render('credit_card_info') }}
      </div>
    </div>
  </div>
  <div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="card-header ">
        <div class="card-title">Credit Card Listing
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            
          </div>
        </div>
        
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <table class="table table-hover demo-table-search table-responsive-block datatable" id="">
          <thead>
            <tr>
              <th>Name</th>
              <th>Last Digit</th>
              <th>First Transaction Amount</th>
              <th>Second Transaction Amount</th>
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
    ajax: '{{ route('creditcard.getcreditcardinfo') }}',
    columns: [
        {data: 'name',"className": "text-center"},
        {data: 'digit',"className": "text-center"},
        {data: 'first_transec_amount',"className": "text-center"},
        {data: 'second_transec_amount',"className": "text-center"},
        {data: 'status',"className": "text-center"},
        {data: 'action',orderable: false, searchable: false,"className": "text-center"}
    ],


    order: [[ 1, "asc" ]]
    });

    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
});
function VerifyCard(id){
   swal({
                title: "You want to Verify the Credit Card",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Verify',
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                            type: "POST",
                            url: "{{URL::route('creditcard.verify')}}",
                            data: {'id':id,},
                            dataType: "JSON",
                            success: function (response) {
                              if(response.status == 1)
                              {
                                swal("Success", "Verified :)", "success");
                                $('.datatable').DataTable().draw();
                              }
                          },
                          error: function (jqXHR, exception) {

                            }
                    });
                   }else {
                    swal("Cancelled", "Credit Card can't Verified :)", "error");
                  }
        });
}
function UnblockCard(id){
   swal({
                title: "You want to Unblocked the Credit Card",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Unblock',
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                            type: "POST",
                            url: "{{URL::route('creditcard.verify')}}",
                            data: {'id':id,},
                            dataType: "JSON",
                            success: function (response) {
                              if(response.status == 1)
                              {
                                swal("Success", "Unblocked :)", "success");
                                $('.datatable').DataTable().draw();
                              }
                          },
                          error: function (jqXHR, exception) {

                            }
                    });
                   }else {
                    swal("Cancelled", "Credit Card can't Unblocked :)", "error");
                  }
        });
}
function BlockCard(id)
{
   swal({
                title: "You want to Block the Credit Card",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Block',
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                            type: "POST",
                            url: "{{URL::route('creditcard.block')}}",
                            data: {'id':id,},
                            dataType: "JSON",
                            success: function (response) {
                              if(response.status == 1)
                              {
                                swal("Success", "Blocked :)", "success");
                                $('.datatable').DataTable().draw();
                              }
                          },
                          error: function (jqXHR, exception) {

                            }
                    });
                   }else {
                    swal("Cancelled", "Credit Card can't Blocked :)", "error");
                  }
        });
}

</script>
@endsection