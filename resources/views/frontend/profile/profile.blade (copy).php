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
                                        <span class="pull-right"> {{@$user->first_name}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="bold">Last Name :</span>
                                        <span class="pull-right"> {{@$user->last_name}}</span>
                                    </li>
                                    
                                    <li class="list-group-item">
                                        <span class="bold">Gender :</span>
                                        <span class="pull-right"> {{@$user->gender}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="bold">Birth Date :</span>
                                        <span class="pull-right"> {{Helper::formatDate(@$user->dob)}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="bold">Email :</span>
                                        <span class="pull-right"> {{@$user->email}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="bold">Address :</span>
                                        <span class="pull-right">
                                            @if($user->shopaholic->address)
                                            @if($user->shopaholic->address->city =='' && $user->shopaholic->address->state =='' && $user->shopaholic->address->street =='' && $user->shopaholic->address->zip =='')
                                            {{'NULL22'}}
                                            @else
                                            
                                            {{@$user->shopaholic->address->street.', '.@$user->shopaholic->address->city.', '.@$user->shopaholic->address->state.', '.@$user->shopaholic->address->zip_code.', '.@$user->country->name}}
                                            @endif
                                            @else
                                            {{dd('lll')}}
                                            //Null
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer clearfix">
                                
                                <div class="pull-right hint-text">
                                    <button class="btn btn-primary" class="dropdown-item " data-toggle = "modal" data-target = "#edit_primary_info_model" ><i class="fa fa-edit"></i> Edit</button>

                                    <button @click="itemClicked(item)">ShowMore</button>
                                </div>

                                 
                                <div class="clearfix"></div>
                            </div>
                        </div>


                        <primary-info :user="user"></primary-info>
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
                              @include('frontend.profile.addresses')
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

 @include('frontend.profile.edit-primary-info-modal')   
</div>



@include('frontend.profile.add-address-modal')

@include('frontend.profile.edit-address-modal')
@include('revox-theme.js-css-blades.datepicker')



@include('revox-theme.js-css-blades.select2')
@include('revox-theme.js-css-blades.sweetalert')



@endsection

@section('script')
<script>
let userId = '{{$user->id}}';

Vue.component('primary-info',{
  template:' <div class="card social-card width-auto margin-top-10 share">\
    <div class="card-header ">\
      <h5 class="text-complete pull-left fs-12">Primary Info</h5>\
      <div class="pull-right small hint-text">\
      </div>\
    </div>\
    <div class="card-description no-padding">\
       <ul class="list-group list-group-flush">\
          <li class="list-group-item">\
              <span class="bold">First Name :</span>\
              <span class="pull-right">@{{user.first_name}}</span>\
          </li>\
          <li class="list-group-item">\
              <span class="bold">Last Name :</span>\
              <span class="pull-right">@{{user.last_name}}</span>\
          </li>\
          <li class="list-group-item">\
                                        <span class="bold">Address :</span>\
                                        <span class="pull-right"> @{{user.shopaholic.address.street}}</span>\
                                    </li>\
          </ul>\
    </div>\
  </div>',
  props:['user']
})

 
var app = new Vue({
  el: '#profile-vue',
  data: {
     user:{}
  },
   mounted() {

  // console.log(this.user.id);
    axios
      .get('{{route("profile.get_profile_data")}}')
      .then(response => (this.user = response.data))
    },
    methods:{

      itemClicked: function() {
          /*this.name = item.itemName;
          this.description = item.desc;
          this.price = item.itemPrice;*/
          $("#edit_primary_info_model").modal('show');
        }
    } 
  
});
</script>
@endsection



  @section('document_ready')
  @parent

   

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

  @endsection


