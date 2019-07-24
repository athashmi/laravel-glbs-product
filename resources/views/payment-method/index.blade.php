@extends('revox-theme.layout.main')
@section('content')
<div class="content">
  <div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      <div class="inner">
        {{ Breadcrumbs::render('package_services') }}
      </div>
    </div>
  </div>
  <div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="card-header ">
        <div class="card-title">Payment Method
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <button type="button" class="btn btn-primary float-sm-right" data-toggle = "modal" data-target = "#add_payment_model"><i class="fa fa-plus"></i> Add Payment Method</button>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <table class="table table-hover demo-table-search table-responsive-block datatable" id="">
          <thead>
            <tr>
              <th>Title</th>
              <th>Charges</th>
              <th>Charges Type</th>
              <th>Applicable Module</th>
              <th>Image</th>
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
@include('payment-method.add-payment-model')
@include('payment-method.edit-payment-model')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.datatables')
@include('revox-theme.js-css-blades.select2')
@endsection
@section('script')
@parent
<script type="text/javascript">
$(document).ready(function(){
		$('.select2').select2();
	    $(".datatable").css('width', '100%');
	    var id = 0;
	    var datatbl = $('.datatable').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{{route("payment.get_payment_methods")}}',
	        columns: [{
	            data: 'name',
	            "className": "text-center"
	        }, {
	            data: 'charges',
	            "className": "text-center"
	        }, {
	            data: 'charges_type',
	            "className": "text-center"
	        }, {
	            data: 'applicable_module',
	            "className": "text-center"
	        }, {
	            data: 'image_name',
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

function statusChanges(status,id){
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
                        url: "{{URL::route('payment.update_status')}}",
                        data: {'id':id,'status':'in_active'},
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
	if(status == 'in_active'){
	    swal({
	                title: "You want to Active the Status",
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
	                            url: "{{URL::route('payment.update_status')}}",
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