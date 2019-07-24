@extends('revox-theme.layout.main')
@section('content')
<div class="content">
  <div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      <div class="inner">
        {{ Breadcrumbs::render('group') }}
      </div>
    </div>
  </div>
  <div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="card-header ">
        <div class="card-title">Shopaholic Group Listning
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <a type="button" class="btn btn-primary float-sm-right" href="{{route('group.shopaholic.create')}}" ><i class ="fa fa-plus" ></i> Add Sopaholic Group</a>
            
          </div>
        </div>
        
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <table class="table  shopaholic_group demo-table-search table-responsive-block datatable" id="">
          <thead>
            <tr>
              <th colspan="1"></th>
              <th>Title</th>
              <th>Name</th>
              <th>Type</th>
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
@include('revox-theme.js-css-blades.select2')
@endsection
@section('script')
<script id="details-template" type="text/x-handlebars-template">
<div class="row justify-content-md-center">
  <div class="col-md-8 ">
    <div class="card card-default hover-stroke">
      <div class="card-body no-padding">
        <div class="container-sm-height">
          <div class="row row-sm-height">

             <div class="col-md-3 justify-content-center d-flex flex-column bg-master-lighter">
              <h4 class="text-center text-primary no-margin">
              Filterations
              </h4>
              <h2 class="text-center text-primary no-margin"></h2>
            </div>


            <div class="col-md-9 col-sm-height padding-20 col-top flex-row">

              @{{#shopaholic_all}}   @{{/shopaholic_all}}
              @{{#shopaholic_gender}}   @{{/shopaholic_gender}}
              @{{#shopaholic_age}}   @{{/shopaholic_age}}        
              @{{#in_shopaholics}}   @{{/in_shopaholics}}
              @{{#shopaholic_type}}   @{{/shopaholic_type}}
              @{{#ctry}}   @{{/ctry}}

            </div>

            

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
       
</script>
@parent
<script type="text/javascript">


 $(document).ready(function() {
$('.select2').val([]).select2();
$(".datatable").css('width','100%');
var id = 0;
var datatbl = $('.datatable').DataTable({
  
             
processing: true,
serverSide: true,
ajax: '{{ route('group.shopaholic.getgroup') }}',
columns: [
{
  "className":      'details-control',
  "orderable":      false,
  "searchable":     false,
  "data":           null,
  "defaultContent": '<img src="{{asset('images/details_open.png')}}" class="btn-open">'
},
{data: 'title',"className": "text-center"},
{data: 'name',"className": "text-center"},
{data: 'type',"className": "text-center"},
],
 order: [[ 1, "desc" ]]
});
$('#DataTables_Table_0_wrapper').css("margin-top","10px");

$('.dataTables_filter').addClass('col-sm-6 pull-right');
$("div.dataTables_length").parent().css({"flex-direction": "row"});
$("div.dataTables_info").parent().css({"flex-direction": "row"});
$(".btn-click-bold").click(function(){
  $('.btn-click-event').removeClass('btn-click-event');
  $(this).addClass('btn-click-event');
})


  var template = Handlebars.compile($("#details-template").html());
    Handlebars.registerHelper('shopaholic_all', function(context, options) {
        if(context.data.root.details.shopaholic_option.all != 0){

            return '<div class="col-lg-3">'+
                      '<p class="bold sm-p-t-20">Shopaholics:</p>'+
                      '+<p>Yes</p> '+
                    '</p></div>';
               }
    });
   Handlebars.registerHelper('shopaholic_age', function(context, options) {
      if(context.data.root.details.shopaholic_option.age.min != "0"){

         return '<div class="col-lg-3">'+
                        '<p class="bold sm-p-t-20">Age:</p>'+
                        '<p> Min '+context.data.root.details.shopaholic_option.age.min+'</p><p> Max '+context.data.root.details.shopaholic_option.age.max+
                    '</p></div>';
      }
    });
    Handlebars.registerHelper('shopaholic_gender', function(context, options) {
      if(context.data.root.details.shopaholic_option.gender != ""){

          return '<div class="col-lg-3">'+
                        '<p class="bold sm-p-t-20">Gender:</p>'+
                        '<p> '+context.data.root.details.shopaholic_option.gender+
                    '</p></div>';
            }
    });
    Handlebars.registerHelper('ctry', function(context, options) {
      if(context.data.root.ctry != ''){

         return '<div class="col-lg-3">'+
                        '<p class="bold sm-p-t-20">Countries:</p>'+
                        '<p>'+context.data.root.ctry+
                    '</p></div>';
        }
    });
    Handlebars.registerHelper('in_shopaholics', function(context, options) {
      if(context.data.root.in_shopaholics != 'No'){

       return  '<div class="col-lg-3">'+
                        '<p class="bold sm-p-t-20">Shopaholics:</p>'+
                        '<p>'+context.data.root.in_shopaholics+
                    '</p></div>';
        }
    });

    Handlebars.registerHelper('shopaholic_type', function(context, options) {
      if(context.data.root.details.shopaholic_option.type != ''){

          return '<div class="col-lg-3">'+
                        '<p class="bold sm-p-t-20">Shopaholic Type:</p>'+
                        '<p>'+context.data.root.details.shopaholic_option.type+
                    '</p></div>';
          }
    });



    $('.shopaholic_group tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
          
        var row = datatbl.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            $(this).html('<img src="{{asset('images/details_open.png')}}" />');
            tr.removeClass('shown');
        }
        else {

            // Open this row
            row.child( template(row.data())).show();

            $(this).html('<img src="{{asset('images/details_close.png')}}" />');
            tr.addClass('shown');

             tr.next().addClass('border');
        }
    });
});
</script>
@endsection