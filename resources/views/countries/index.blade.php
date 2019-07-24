@extends('revox-theme.layout.main')
@section('content')
<div class="content">
  <div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      <div class="inner">
        {{ Breadcrumbs::render('country') }}
      </div>
    </div>
  </div>
  <div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="card-header ">
        <div class="card-title">Countries Listing
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <button type="button" class="btn btn-primary float-sm-right" data-toggle = "modal" data-target = "#create_country_model"><i class="fa fa-plus"></i> Add Country</button>
            
          </div>
        </div>
        
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <table class="table table-hover demo-table-search table-responsive-block datatable img_cell" id="">
          <thead>
            <tr>
              <th>Flag</th>
              <th>Name</th>
              <th>ISO</th>
              <th>Num Code</th>
              <th>Phone Code</th>
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
@include('countries.create_modal')
@include('countries.edit_modal')
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
    ajax: '{{ route('country.getcountries') }}',
    columns: [
        {data: 'flag',orderable: false, searchable: false,"className": "text-center"},
        {data: 'name',"className": "text-center"},
        {data: 'iso',"className": "text-center"},
        {data: 'num_code',"className": "text-center"},
        {data: 'phone_code',"className": "text-center"},
        {data: 'action',orderable: false, searchable: false,"className": "text-center"}
    ],


    order: [[ 1, "asc" ]]
    });

    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
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
                            url: "{{URL::route('country.update_status')}}",
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
                            url: "{{URL::route('country.update_status')}}",
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