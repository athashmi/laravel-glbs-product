@extends('revox-theme.layout.main')
@section('content')
<div class="content">
  <div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      <div class="inner">
        {{ Breadcrumbs::render('courier_zone') }}
      </div>
    </div>
  </div>
  <div class="card card-transparent">
    

    <div class="card-header ">
      <div class="card-title">Courier Zones
      </div>

    </div>
    <div class="card-body no-padding">
     
        <div class="col-xl-11">
          <div class="card card-transparent flex-row ">
            <!-- <div class="collapse navbar-collapse"> -->
              <!-- <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                  <span class="navbar-toggler-icon"></span>
                </button>
              </nav> -->
          <ul class="nav nav-tabs nav-tabs-simple nav-tabs-left bg-white courier_ p-t-20" id="collapsibleNavbar" role="tablist">
             
              @foreach($couriers as $courier)
              <li class="nav-item">
                <a href="javascript:void(0);" data-name="{{$courier->name}}"  data-toggle="tab" role="tab" data-target="#tab" class="pills-ul-li-a" >{{$courier->title}} 
                 </a>
                 <input type="hidden" name="courier_id" value="{{$courier->id}}" id="courier_id">
              </li>
              
              @endforeach
            </ul>

           <!--  </div> -->

             
            <div class="tab-content bg-white col-md-11">
              <div class="tab-pane" id="tab4hellowWorld">
                <div class="row column-seperation">
                </div>
              </div>
              <div class="tab-pane active view-port clearfix" id="tab">
                
                  <div class="bg-white">
                    <div class="card card-transparent">
                      <div class="card-header">
                        <div class="card-title" id="zone-title">Courier Zone Listing
                        </div>
                        <div class="pull-right">
                            <div class="col-xs-12">
                            <button type="button" class="btn btn-primary float-sm-right" data-toggle = "modal" data-target = "#AddCourierZoneModel"><i class="fa fa-plus"></i> Add Zone</button>
                            </div>
                          </div>
                        <div class="clearfix"></div>
                      </div>
                      <div class="card-body">
                        <table class="table table-hover demo-table-search table-responsive-block datatable" id="">
                          <thead>
                            <tr>
                              <th>Zone Name</th>
                              <th>Countries</th>
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
            </div>
          </div>
        </div>
     
    </div>
  </div>


</div>
  @include('courier-manipulation.zone.edit-courier-modal')
   @include('courier-manipulation.zone.import-rate-modal')
  @include('courier-manipulation.zone.add-courier-modal')
  @include('revox-theme.js-css-blades.sweetalert')
  @include('revox-theme.js-css-blades.datatables')
  @include('revox-theme.js-css-blades.select2')
  @endsection

  @section('document_ready')
  @parent

   setTimeout(function() {
      $("ul.courier_ :first-child").find('a').trigger( "click" );
    },10);

      $(".datatable").css('width', '100%');

     var  datatbl = $('.datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              "url": "{{ route('courier.zone.getcouriers') }}",
              "data": function(data) {}
          },
          columns: [{
              data: 'title',
              "className": "text-center"
          }, {
              data: 'country_ids',"width": "100%"
          }, {
              data: 'status',
              "className": "text-center"
          }, {
              data: 'action',
              orderable: false,
              searchable: false,
              "className": "text-center"
          }],
          order: [
              [1, "asc"]
          ]
      });
      $("div.dataTables_length").parent().css({
          "flex-direction": "row"
      });
      $("div.dataTables_info").parent().css({
          "flex-direction": "row"
      });
      
      $('.form-group').addClass('form-group-default');
      $('.add_courier_zone').val([]).select2();
      $('.country_assign').val([]).select2();
      var id = 0;
      $("div.dataTables_length").parent().css({
          "flex-direction": "row"
      });
      $("div.dataTables_info").parent().css({
          "flex-direction": "row"
      });



      $('.pills-ul-li-a').on('click',function(e){
        let name = $(this).data('name');


      $('.view_cls').attr('id','view_'+name);

        $('.pills-ul-li-a').removeClass('active');


        var url_ = "{{route('courier.zone.getcouriers')}}";
        var url_full = url_ + '?courier_name=' + name;
        
        datatbl.ajax.url(url_full).draw();
       
        $(this).addClass('active');
        
        $('#zone-title').text(name.replace('_',' ')+' Zones');

        
      });



  @endsection

  @section('script')
  @parent
  <script type="text/javascript">
  var arr = [];
  //var datatbl;
  

   
  function statusChanges(status, id) {
      if (status == 1) {
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
              function(isConfirm) {
                  if (isConfirm) {
                      $.ajax({
                          type: "POST",
                          url: "{{URL::route('country.update_status')}}",
                          data: {
                              'id': id,
                              'isK': 0
                          },
                          dataType: "JSON",
                          success: function(response) {
                              if (response.status == 1) {
                                  swal("Success", "Status Updated :)", "success");
                                  $('.datatable').DataTable().draw();
                              }
                          },
                          error: function(jqXHR, exception) {}
                      });
                  } else {
                      swal("Cancelled", "Your Status can't update)", "error");
                  }
              });
      }
      if (status == 0) {
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
              function(isConfirm) {
                  if (isConfirm) {
                      $.ajax({
                          type: "POST",
                          url: "{{URL::route('country.update_status')}}",
                          data: {
                              'id': id,
                              'isK': 1
                          },
                          dataType: "JSON",
                          success: function(response) {
                              if (response.status == 1) {
                                  swal("Success", "Status Updated :)", "success");
                                  $('.datatable').DataTable().draw();
                              }
                          },
                          error: function(jqXHR, exception) {}
                      });
                  } else {
                      swal("Cancelled", "Your Status can't update)", "error");
                  }
              });
      }
  }

  function deleteCountry(country_id, primary_id) {
      swal({
              title: "You want to remove country in this zone",
              text: '',
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: 'Remove',
              cancelButtonText: "No, cancel please!",
              closeOnConfirm: false,
              closeOnCancel: false
          },
          function(isConfirm) {
              if (isConfirm) {
                  $.ajax({
                      type: "POST",
                      url: "{{URL::route('courier.zone.deletecountry')}}",
                      data: {
                          'id': primary_id,
                          'country_id': country_id
                      },
                      dataType: "JSON",
                      success: function(response) {
                          if (response.status == 1) {
                              swal("Success", "Remove Country  :)", "success");
                              $('.datatable').DataTable().draw();
                          }
                          if (response.status == 0) {
                              swal("Cancelled", "Some thing went Wrong :)", "error");
                              $('.datatable').DataTable().draw();
                          }
                      },
                      error: function(jqXHR, exception) {

                      }
                  });
              } else {
                  swal("Cancelled", "Your Data is safe)", "error");
              }
          });
  }

  
  </script>
  @endsection