@extends('revox-theme.layout.main')
@section('content')
<div class="content">
  <div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      <div class="inner">
        {{ Breadcrumbs::render('shopaholic') }}
      </div>
    </div>
  </div>
  <div class="container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="card-body ">
        <div class="row">
          <div class="col-lg-3">
         
            @if(!empty($shopaholic->user->picture))
             @php $img = route('img_file',$shopaholic->user->picture); @endphp
            @else
             @php $img = asset('images/social/profile.jpg'); @endphp
            @endif   
            <img class="img-thumbnail" src="{{$img}}" alt="Theme-Logo" />
            {{-- <span class="m-l-5 color">
              <b> {{@$shopaholic->user->last_name}} </b>
            </span> --}}
            <div class="card social-card width-auto margin-top-10 share">
              <div class="card-header ">
                <h5 class="text-complete pull-left fs-12">{{@$shopaholic->user->first_name}} {{@$shopaholic->user->last_name}} </h5>
                <div class="pull-right small hint-text">
                  <b>{{strtoupper($shopaholic->sn)}}</b>
                  {{-- <i class="fa fa-pencil"></i> --}}
                </div>
                
              </div>
              <div class="card-description no-padding">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <span class="bold">First Name :</span>
                    <span class="pull-right"> {{@$shopaholic->user->first_name}}</span>
                  </li>
                  <li class="list-group-item">
                    <span class="bold">Last Name :</span>
                    <span class="pull-right"> {{@$shopaholic->user->last_name}}</span>
                  </li>
                  
                  <li class="list-group-item">
                    <span class="bold">Gender :</span>
                    <span class="pull-right"> {{@$shopaholic->user->gender}}</span>
                  </li>
                  <li class="list-group-item">
                    <span class="bold">Birth Date :</span>
                    <span class="pull-right"> {{($shopaholic->user->dob)?Helper::formatDate(@$shopaholic->user->dob):'NULL'}}</span>
                  </li>
                  <li class="list-group-item">
                    <span class="bold">Email :</span>
                    <span class="pull-right"> {{@$shopaholic->user->email}}</span>
                  </li>
                  <li class="list-group-item">
                    <span class="bold">Address :</span>
                    <span class="pull-right">
                      @if($shopaholic->primaryAddress)
                      
                      {{@$shopaholic->primaryAddress->street.', '.@$shopaholic->primaryAddress->city.', '.@$shopaholic->primaryAddress->state.', '.@$shopaholic->primaryAddress->zip_code.', '.@$shopaholic->user->country->name}}
                      
                      @else
                      Null
                      @endif
                    </span>
                  </li>
                </ul>
              </div>
              <div class="card-footer clearfix">
                
                <div class="pull-right hint-text">
                  <button class="btn btn-primary btn-edit-primary-info" data-id = "{{@$shopaholic->id}}" data-toggle="modal"   id="edit_id" data-target="#edit_primary_info_model"><i class="fa fa-edit "></i> Edit</button>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-9 card no-padding">
            <div class="col-lg-12 m-t-10">
              <ul class="nav nav-pills nav-fill m-b-10">
                <li class="nav-item">
                  <a href="#" class="nav-link active" data-toggle="tab" data-target="#addresses"><span>Addresses</span></a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link" data-toggle="tab" data-target="#wallet"><span>Wallet</span></a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link" data-toggle="tab" data-target="#packages"><span>Packages</span></a>
                </li>
              </ul>
              
              <div class="tab-content">
                <div class="tab-pane active" id="addresses">

                  {{-- @include('shopaholics.user-profile.partial.addresses') --}}
                
                <div class="row">
                 <!--  <div class="col-lg-12 no-padding m-b-10"> -->
                    <div class="col-lg-12 m-b-10 m-t-10">
                        <div class="form-group form-group-default">
                                        <label>Search Address</label>
                                        <input type="search"  type="search" id="search-address" class="form-control" >
                                      </div>
                    <!-- </div> -->
                   </div>
                </div>
                
                <div class="address_render">
                </div>
                <div class="dataTables_wrapper">

                  <div class="col-ms-12 pagination-div pull-right dataTables_paginate paging_simple_numbers">
                    <ul class="pagination pagination-la "></ul>
                    <div class="clearfix"></div>
                  </div>
                </div>
                </div>
                <div class="tab-pane" id="wallet">
                  <div class="row">
                    <div class="col-lg-12">
                      
                      <div class="col-lg-4 pull-right no-padding m-t-30">
                        <div class="m-l-0 m-t-10">
                          <div class="col-lg-12 bg-white b-a b-grey padding-10 text-center">
                            <h4 class="semi-bold">Available Balance</h4>
                            
                            {!! Helper::h3AmountWithDollarAsSup($balance) !!}
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3 no-padding m-b-10 pull-left">
                <canvas id="myChart" width="250" height="250"></canvas>
          </div>
                      
                      <!-- <div class="col-lg-3 pull-left no-padding">
                        <div class="row m-l-0 m-t-10">
                          <div class="col-1 no-padding ">
                            <div class="bg-success p-t-30 p-b-11"></div>
                            <div class="bg-danger  p-t-30 p-b-11"></div>
                            <div class="bg-warning p-t-30 p-b-11"></div>
                          </div>
                          <div class="col-10 bg-white b-a b-grey padding-10">
                            <p class="no-margin text-black bold text-uppercase fs-12">Deposit</p>
                            <p class="p-t-20 no-margin text-black bold text-uppercase fs-12">Withdrawal</p>
                            
                            <p class="p-t-20 no-margin text-black bold text-uppercase fs-12">Refunded</p>
                            
                          </div>
                        </div>
                      </div> -->
                    </div>
                    <div class="col-lg-12 clear-fix">
                      <hr>
                    </div>
                    
                    <div class="col-lg-12 ">
                      @include('shopaholics.user-profile.partial.wallet-info')
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="packages">
                  <div class="row">
                    <div class="col-lg-12">
                      <h3>Follow us &amp; get updated!</h3>
                      <p>Instantly connect to what's most important to you. Follow your friends, experts, favorite celebrities, and breaking news.</p>
                      <br>
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
</div>

@include('shopaholics.user-profile.partial.edit-address-modal')
@include('shopaholics.user-profile.partial.edit-primary-info-modal')
@include('revox-theme.js-css-blades.datepicker')
@include('revox-theme.js-css-blades.select2')
@include('revox-theme.js-css-blades.pagination')
@include('revox-theme.js-css-blades.datatables')
@endsection



@section('document_ready')
@parent



  ajaxaddress('{{route("shopaholic.ajaxaddress")}}');



$('#search-address').on('keyup',function(){
  var query = $(this).val();
  $.ajax({
    type: "get",
    url: '{{URL::route("shopaholic.ajaxaddress")}}',
    data: {'text': query,'shopaholic_id':{{$shopaholic->id}} },
    dataType: "JSON",
      success: function (response) {
        if(response.status == 1 && response.data != ""){
            contentAddress(response,1);
        }else{
          noAddressFound();
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status == 422) {
        }
      }
  });
});

$(document).on('click','.page-link-href',function(e){
e.preventDefault();
  var link = $(this).data('href');
  //$('.page_href_add').removeClass('background');
  //$(this).addClass('background');
  ajaxaddress(link);
}); 

 template = Handlebars.compile($("#addresses-json").html());


//var ctx = document.getElementById('myChart');
     new Chart('myChart', {
    type: 'doughnut',
     data:{
              datasets: [{
                  data: [{{$deposits}}, {{$withdrawals}},{{$refunds}}],
                  backgroundColor: [
                '#10cfbd',
                '#f55753',
                '#f8d053']
              }],

              labels: [
                  'Deposits: ${{$deposits}}',
                  'Withdreawals: ${{$withdrawals}}',
                  'Refunds: ${{$refunds}}'
              ]
          },
          options: {
        responsive: true,
         legend: {
            display: true,
            position:'top',
           
            
        },
        tooltips: {
        enabled:false
      }
      }
  });

@endsection
@section('script')
@parent

<script>
var template ='';
</script>


<script src="{{URL::asset('js/masonry.pkgd.min.js')}}"></script>
<script id="addresses-json" type="text/x-handlebars-template">
    <div class="col-lg-4 addr">
      <div id="card-linear-color" class="card card-default card-address">
        <div class="card-header  ">
            <div class="card-title">Address</div>
            <div class="card-controls">
              <ul>
                <li>
                 <div class="btn-group sm-m-t-10"> 
                  <button type="button" class="btn btn-default btn-group-custom-pad" data-id="@{{id}}" data-toggle = "modal" data-target = "#edit_address_model"><i class="fa fa-pencil"></i>
                  </button>
                  
                </div>
                </li>
              </ul>
            </div>
            <hr class="m-b-0 m-t-10"/>
        </div>
        <div class="card-body">
            <div class="col-sm-height sm-no-padding">
                <h3>
                <span class="semi-bold">@{{name}}</span></h3>

                <address>
                <strong> @{{#if street}}
                            @{{street}}
                          @{{else}}

                        @{{/if}}</strong>
                <br>
                @{{#if city}}
                 @{{city}}
                @{{/if}},
                @{{#if state}}
                  @{{state}}
                @{{/if}}<br>

                @{{#if zip_code}}
                  @{{zip_code}}
                @{{/if}}
               ,

               @{{#if country}}
                  @{{country.name}}
                @{{/if}}
                <br/>
                <abbr title="Phone">P:</abbr>
                 @{{#if phone}}
                  @{{phone}}
                @{{/if}}
                </address>
                </div>
        </div>
      </div>
    </div>


</script>


<script>
  var check = 1; 
  var contentAddress = function(response,p){

   var html = '<div class="row address_cards">';

                $.each(response.data.data,function(index,value){
                  html += template(value);
                });
              html +='</div><hr/><div class="clearfix"></div>';

              $(".address_render").html(html);

              var grid = document.querySelector('.address_cards');

              var msnry = new Masonry(grid, {
                // options...
                itemSelector: '.addr',
                //columnWidth: 200
              });

              if(check == 1 && response.data.data !=""){
                //console.log('ooo---'+response.data.data);
                 paginate(response.data.total,response.data.per_page);
                 check++;
               }
               if(p == 1){
                if(response.data.data != ""){
               // console.log('ooo---'+response.data.data.total);

                  $('.pagination-la').show();
                 paginate(response.data.total,response.data.per_page);
                }else{
                  $('.pagination-la').hide();
                }
               }
  }
  var ajaxaddress = function(href){
    //console.log(href);
    $.ajax({
    type: "GET",
    url: href,
    data: {'shopaholic_id':"{{$shopaholic->id}}" ,'text' : $('.serach-address').val()},
    dataType: "JSON",
      success: function (response) {
        if(response.status == 1){
          //contentAddress(response);    

           if(response.data.data != ""){
              contentAddress(response);
            }
            else
            {
              noAddressFound();
            }

            
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status == 422) {
          
        }
      }
    });
  }
  var noAddressFound = function(){
     var html = `<div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text text-center">No result found.</h5>
                            </div>
                            <div class="card-block revision-block">
                            </div>
                        </div>
                      </div>`;
     $(".address_render").html(html);
  }

  var paginate = function(total,per_page){
    
     $('.pagination-la').pagination({
        items: total,
        itemsOnPage: per_page,
        //cssStyle: 'light-theme',
        hrefTextPrefix:'?page=',
        listStyle: 'paginate_button',
        prevText: '<',
        nextText: '>',
        
        onPageClick: function(pageNumber, event) {
          ajaxaddress('{{route("shopaholic.ajaxaddress")}}?page='+pageNumber);
          // Callback triggered when a page is clicked
          // Page number is given as an optional parameter
        },
        onInit:function(){
          $('.page-link-href').parent().addClass('paginate_button');
         
          $('a.current').parent().addClass('active');

        }
    });

    
  }
 
</script>
@endsection

