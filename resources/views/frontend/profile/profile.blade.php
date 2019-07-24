@extends('revox-theme.layout.main')
  @section('content')

<div class="content" id="profile-vue">

    <div class="jumbotron" data-pages="parallax">
        <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                {{ Breadcrumbs::render('shopaholic_profile') }}
                
            </div>
        </div>
    </div>
    <div class="container-fluid   container-fixed-lg bg-white">
        <div class="card card-transparent">
            <div class="card-body ">
                <div class="row">

                    <div class="col-lg-3">
                        @php
                        if($user->picture !=''):

                        if(strpos($user->picture,'https:'))
                          {
                            $img = $user->picture;
                          }
                        else
                          $img = route('img_file',$user->picture);
                        else:
                          $img = asset('images/social/profile.jpg');
                        endif;
                        @endphp

                         <img class="img-thumbnail" src="{{$img}}" alt="profile" />

                        <div class="card social-card width-auto margin-top-10 share">
                            <div class="card-header ">
                                <h5 class="text-complete pull-left fs-12">Primary Info</h5>
                                <div class="pull-right small hint-text">
                                    {{-- <i class="fa fa-pencil"></i> --}}
                                </div>
                                
                            </div>
                            <div class="card-description no-padding">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <span class="bold">First Name :</span>
                                        <span class="pull-right"> {{$user->first_name}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="bold">Last Name :</span>
                                        <span class="pull-right"> {{$user->last_name}}</span>
                                    </li>
                                    
                                    <li class="list-group-item">
                                        <span class="bold">Gender :</span>
                                        <span class="pull-right"> {{$user->gender}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="bold">Birth Date :</span>
                                        <span class="pull-right"> {{Helper::formatDate($user->dob)}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="bold">Email :</span>
                                        <span class="pull-right"> {{$user->email}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="bold">Address :</span>
                                        <span class="pull-right">
                                            @if($user->shopaholic->primaryAddress)
                                            @if($user->shopaholic->primaryAddress->city =='' && $user->shopaholic->primaryAddress->state =='' && $user->shopaholic->primaryAddress->street =='' && $user->shopaholic->primaryAddress->zip =='')
                                            {{'NULL'}}
                                            @else
                                            
                                            {{$user->shopaholic->primaryAddress->street.', '.$user->shopaholic->primaryAddress->city.', '.$user->shopaholic->primaryAddress->state.', '.$user->shopaholic->primaryAddress->zip_code.', '.$user->country->name}}
                                            @endif
                                            @else
                                            {{'NULL'}}
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer clearfix">
                                
                                <div class="pull-right hint-text">
                                    <button class="btn btn-primary" class="dropdown-item " data-toggle = "modal" data-target = "#edit_primary_info_model" ><i class="fa fa-edit"></i> Edit</button>
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
                              <a href="#" class="nav-link" data-toggle="tab" data-target="#tab1"><span>Tab1</span></a>
                            </li>
                            <li class="nav-item">
                              <a href="#" class="nav-link" data-toggle="tab" data-target="#tab2"><span>Tab2</span></a>
                            </li>
                            
                          </ul>
                          
                          <div class="tab-content">
                            <div class="tab-pane active" id="addresses">
                            

                              <div class="row">
                               <!--  <div class="col-lg-12 no-padding m-b-10"> -->


                                  <div class="col-lg-12 m-b-10 m-t-10">
                                    <div class="form-group form-group-default">
                                        <label>Search Address</label>
                                        <input type="search"  id="search-address" class="form-control" >
                                    </div>
                                  </div>

                                <div class="col-lg-12 no-padding m-b-10">
                                  <div class="col-lg-3 pull-right">
                                        <button id="edit-btn" type="button" data-toggle = "modal" data-target = "#add_address_model" class="btn btn-sm btn-primary waves-effect waves-light pull-right">
                                        Add New Address
                                        </button>
                                   </div> 
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
                           

                           <div class="tab-pane" id="tab1">
                           
                            </div>

                            <div class="tab-pane" id="tab2">
                           
                            </div>
                           
                          </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

  
</div>

@include('revox-theme.js-css-blades.pagination')
@include('frontend.profile.edit-primary-info-modal')  
@include('frontend.profile.add-address-modal')

@include('frontend.profile.edit-address-modal')
@include('revox-theme.js-css-blades.datepicker')
@include('revox-theme.js-css-blades.datatables')


@include('revox-theme.js-css-blades.select2')
@include('revox-theme.js-css-blades.sweetalert')



@endsection

<div class="btn-toolbar flex-wrap" role="toolbar">
  <div class="btn-group sm-m-t-10">
    <button type="button" class="btn btn-default"><i class="fa fa-save"></i>
    </button>
    <button type="button" class="btn btn-default active"><i class="fa fa-copy"></i>
    </button>
    <button type="button" class="btn btn-default"><i class="fa fa-clipboard"></i>
    </button>
    <button type="button" class="btn btn-default"><i class="fa fa-paperclip"></i>
    </button>
  </div>
</div>

@section('script')
@parent
<script src="{{URL::asset('js/masonry.pkgd.min.js')}}"></script>


<script id="addresses-json" type="text/x-handlebars-template">
    <div class="col-lg-4 addr">
      <div id="card-linear-color" class="card card-default card-address">
        <div class="card-header  ">
            <div class="card-title">Address
            </div>
            <div class="card-controls">
              <ul>
                <li>
                 <div class="btn-group sm-m-t-10"> 
                  <button type="button" class="btn btn-default btn-sm" data-id="@{{id}}" data-toggle = "modal" data-target = "#edit_address_model"><i class="fa fa-pencil"></i>
                  </button>
                  <button type="button" class="btn btn-default" data-id="@{{id}}" id="delete_id@{{id}}" onclick=deleteById("@{{id}}",'refresh')  class="card-close" data-toggle="close"><i class="fa fa-trash"></i>
                  </button>
                </div>
                </li>
              </ul>
            </div>
            <hr class="m-b-0"/>
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
var template ='';



var ajaxaddress = function(href){
    //console.log(href);
    $.ajax({
    type: "GET",
    url: href,
    data: {'shopaholic_id':"{{$user->shopaholic->id}}" ,'text' : $('#search-address').val()},
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
          ajaxaddress('{{route("profile.ajaxaddress")}}?page='+pageNumber);
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


  @section('document_ready')
  @parent

   $('.select').select2();

    $('#btn-update-profile').on('click', function() {
       
           $.ajax({
                  type: "POST",
                  url: "{{route('profile.primary.info.update')}}",
                  data: $('#user_profile').serialize(),
                  dataType: "JSON",
                  success: function (response) {
                  if(response.status == 1)
                  {
                    responseMsg("update","Information has been inserted successfully...");
                      $('#create_permission_model').modal('hide');
                     
                     
                  }
                  },
                  error: function(jqXHR, exception){
                    
                    var html_error = '<div  class="alert " style="background-color:#e67070; color:white;"><ul>';
                    $.each(jqXHR.responseJSON.errors, function (key, value) 
                    {
                        html_error +='<li>'+value+'</li>';
                    })
                     html_error += "</ul></div>";
                  $('#error_msgs1').html(html_error);
                  setTimeout(function(){
                        $("#error_msgs1").html('');
                  },2000);
                }
              });
      });

  ajaxaddress('{{route("profile.ajaxaddress")}}');






$('#search-address').on('keyup',function(){
  var query = $(this).val();
  $.ajax({
    type: "get",
    url: '{{URL::route("profile.ajaxaddress")}}',
    data: {'text': query,'shopaholic_id':{{$user->shopaholic->id}} },
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


@endsection