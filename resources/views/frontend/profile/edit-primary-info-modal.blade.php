<div class="modal fade" id="edit_primary_info_model"  role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title pull-left" id="myModalLabel">Edit Personal Info</h4>
                <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            
            <form id="frm-update-profile">

                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" id="address_id" name="address_id" value="@if($user->shopaholic->primaryAddress) {{$user->shopaholic->primaryAddress->id}} @endif">

                     <div class="row">
                    
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >Birth Date</label>
                            <div class="input-group date">
                                <input type='text' class="form-control dt-picker" id="" name="dob" value="{{date('m/d/Y', strtotime($user->dob))}}" />
                                <div class="input-group-append ">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>       
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >Gender</label>
                           
                            <div class="radio radio-primary">
                               
                                <input type="radio" name="gender"  id="male" value="male" @if($user->gender=='male'){{'checked="checked"'}}@endif>
                                     <label for="male">Male</label>

                                <input type="radio" name="gender" id="female" value="female" @if($user->gender=='female'){{'checked="checked"'}}@endif>
                                   <label for="female">Female</label>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >Address</label>
                            
                                <input type="text" class="form-control form-control-normal" name="address[street]" placeholder="Address" value="@if($user->shopaholic->primaryAddress){{$user->shopaholic->primaryAddress->street}}@endif">
                            
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >City</label>
                            
                                <input type="text" class="form-control form-control-normal" name="address[city]" placeholder="City" value="@if($user->shopaholic->primaryAddress){{$user->shopaholic->primaryAddress->city}}@endif">
                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >State</label>
                          
                                <input type="text" class="form-control form-control-normal" name="address[state]" placeholder="State" value="@if($user->shopaholic->primaryAddress){{$user->shopaholic->primaryAddress->state}}@endif">
                            
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >Zip Code</label>
                           
                                <input type="text" class="form-control form-control-normal" name="address[zip_code]" placeholder="Zip Code" value="@if($user->shopaholic->primaryAddress){{$user->shopaholic->primaryAddress->zip_code}}@endif">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12 col-lg-12">
                            <label >PHONE</label>
                                <input type="number" class="form-control form-control-normal" name="phone" placeholder="Phone" value="@if($user->shopaholic->primaryAddress){{$user->shopaholic->primaryAddress->phone}}@endif">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label >Country</label>
                           
                            <select class="full-width select"  name="country" id="country">
                                @foreach($countries as $country)
                                <option value="{{$country->id}}" @if($user->country_id==$country->id){{'selected="selected"'}} @endif >{{$country->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label >Profile Image</label>
                           
                            <input type="file" class="form-control form-control-normal" name="files" id="filer_input">

                        </div>
                    </div>

                    
                </div>
                </form>

                <div class="error_msg_r_u">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-primary_info_save">Update</button>
                </div>
                
            

        </div>
    </div>
</div>
@section('document_ready')
@parent
$('#edit_primary_info_model').on('shown.bs.modal', function (e) {

    $('.dt-picker').datepicker();

   $('#country').select2({placeholder: "Select a Country",
    allowClear: true});


});

$('#edit-primary_info_save').on('click',function(){

var myForm = document.getElementById('frm-update-profile');

//var data = new FormData();
//data.append("file",  $( '#file' )[0].files[0] );
var formData = new FormData(myForm);
       $.ajax({
            type: "POST",
            url: '{{URL::route("profile.primary.info.update")}}',
            data:formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (response) {
            if(response.status == 1)
            {
               responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");

               window.location.reload();
            
            }
            
            },
            error: function (jqXHR, exception) {

                if (jqXHR.status == 422) {
                      var html_error = '';
                      $.each(jqXHR.responseJSON.errors, function (key, value)
                      {
                        html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
                      })
                      html_error += "</ul></div>";
                      $('.error_msg_r_u').html(html_error);
                    }
                  
            }
          });
        });

  
@endsection
