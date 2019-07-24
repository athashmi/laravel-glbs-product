@extends('revox-theme.layout.main')
@section('content')
<div class="content">
  <div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      <div class="inner">
        {{ Breadcrumbs::render('warehouse_shelves') }}
      </div>
    </div>
  </div>
  <div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="card-header ">
        <div class="card-title">Shelves Listing
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <button type="button" class="btn btn-primary float-sm-right" data-toggle = "modal" data-target = "#create_shelf_model"><i class="fa fa-plus"></i> Add Shelf</button>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <table class="table table-hover demo-table-search table-responsive-block datatable" id="">
          <thead>
            <tr>
              <th>Name</th>
              <th>Warehouse Name</th>
              <th>Color</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@include('warehouses.shelves.add-shelf-modal')
@include('warehouses.shelves.edit-shelf-modal')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.datatables')
@include('revox-theme.js-css-blades.select2')
@endsection
@section('script')
@parent
<script type="text/javascript">
$(document).ready(function() {
    $('.select2').val([]).select2();
    $(".datatable").css('width', '100%');
    var id = 0;
    var datatbl = $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [{
                    text: 'Packages',
                    className: 'btn btn-tag btn-click-bold btn-primary packages-btn',
                    action: function(e, dt, node, config) {
                            datatbl.ajax.url('{{route("warehouse.shelves.getshelves","package")}}').draw();


                            $(dt.buttons('.btn-primary').nodes()).removeClass('btn-primary');

                           $('.packages-btn').addClass('btn-primary');
                          datatbl.column(2).visible(false);
                          datatbl.column(3).visible(true);
                        }
                  },
                  {
                    text: 'Consolidated',
                    className: 'btn  btn-tag-right btn-click-bold consolidated-btn',
                    action: function(e, dt, node, config) {
                          datatbl.ajax.url('{{route("warehouse.shelves.getshelves","consolidated")}}').draw();
                           $(dt.buttons('.btn-primary').nodes()).removeClass('btn-primary');
                          $('.consolidated-btn').addClass('btn-primary');

                          datatbl.column(2).visible(true);
                          datatbl.column(3).visible(false);
                        }
                  },
        ],
        processing: true,
        serverSide: true,
        ajax: '{{ route("warehouse.shelves.getshelves","package") }}',
        columns: [{
            data: 'name',
            "className": "text-center"
        }, {
            data: 'warehouse_name',
            "className": "text-center"
        }, {
            data: 'color',
            "className": "text-center"
        }, {
            data: 'status',
            "className": "text-center"
        }, {
            data: 'action',
            orderable: false,
            searchable: false,
            "className": "text-center"
        }],
        'rowCallback': function(row, data, index) {

        }

    });
    $('#DataTables_Table_0_wrapper').css("margin-top", "10px");
    $('.dt-buttons').addClass('col-sm-6 pull-left');
    $('.dataTables_filter').addClass('col-sm-6 pull-right');
    $("div.dataTables_length").parent().css({
        "flex-direction": "row"
    });
    $("div.dataTables_info").parent().css({
        "flex-direction": "row"
    });
    $(".btn-click-bold").click(function() {
        $('.btn-click-bold').removeClass('clr-btn-bold');
        $(this).addClass('clr-btn-bold');
    });

    datatbl.column(2).visible(false);
   
});
function statusChangesShelf(status,id)
{
  
  if(status == 'full'){
     swal({
                title: "You want to Partially Full the Status",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Partial Full',
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
                if (isConfirm) {
                     $.ajax({
                            type: "POST",
                            url: "{{URL::route('warehouse.shelves.updatestatus')}}",
                            data: {'id':id,'status':'partially_full'},
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
 if(status == 'partially_full'){
     swal({
                title: "You want to Full the Status",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Full Shelf',
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                            type: "POST",
                            url: "{{URL::route('warehouse.shelves.updatestatus')}}",
                            data: {'id':id,'status':'full'},
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