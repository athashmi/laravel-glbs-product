<div class="modal fade stick-up" id="edit_primary_info_model"  role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title pull-left" id="myModalLabel">Edit Personal Info</h4>
                <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            
            <form id="frm-update-profile-primary-info">

                <div class="modal-body">
                    <input type="hidden" name="shopaholic_id" value="">
                    <input type="hidden" id="address_id" name="address_id" value="">

                     <div class="row">
                    
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >Birth Date</label>
                            <div class="input-group date">
                                <input type='text' class="form-control dt-picker" id="dob" name="dob" value="" />
                                <div class="input-group-append ">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>       
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >Gender</label>
                           
                            <div class="radio radio-primary">
                               
                                <input type="radio" name="gender"  id="male" value="male" >
                                     <label for="male">Male</label>

                                <input type="radio" name="gender" id="female" value="female" >
                                   <label for="female">Female</label>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >Address</label>
                                <input type="text" class="form-control form-control-normal" name="address[street]" placeholder="Address" value="">
                            
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label>City</label>
                            
                                <input type="text" class="form-control form-control-normal" name="address[city]" placeholder="City" value="">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >State</label>
                          
                                <input type="text" class="form-control form-control-normal" name="address[state]" placeholder="State" value="">
                            
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12 col-lg-6">
                            <label >Zip Code</label>
                           
                                <input type="text" class="form-control form-control-normal" name="address[zip_code]" placeholder="Zip Code" value="">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label >Country</label>
                           
                            <select class="full-width select"  name="country" id="country">
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-primary_info_update">Updates</button>
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
     $('.error_msg_c_u').html('');
        var id = $(e.relatedTarget).data('id');


        $.get('{{URL::route("shopaholic.edituserprofile")}}',{'id':id},function(response) {
           //console.log(response.data.user.gender);
           if(response.status == 1)
            {
              $("#id").val(id);

              if(response.data.primary_address)
              {
                $('#address_id').val(response.data.primary_address.id);
                $('input[name="address[city]"]').val(response.data.primary_address.city);

                $('input[name="shopaholic_id"]').val(response.data.id);

                $('input[name="address[city]"]').val(response.data.primary_address.city);

                $('input[name="address[state]"]').val(response.data.primary_address.state);

                $('input[name="address[zip_code]"]').val(response.data.primary_address.zip_code);

                $('input[name="address[street]"]').val(response.data.primary_address.street);

                $('select[name="country"]').val(response.data.primary_address.country_id).trigger('change');

              }


              $("#dob").val(response.date_for);
              
              if(response.data.user.gender == 'male'){
              //console.log('llll');
                $('input[name="gender"][value="male"]').prop('checked', true);
              }
             if(response.data.user.gender == 'female'){
                $('input[name="gender"][value="female"]').prop('checked', true);
              }
              
              
            }
        },"json"); 

});

$('#edit-primary_info_update').on('click',function(){
var myForm = document.getElementById('frm-update-profile-primary-info');

//var data = new FormData();
//data.append("file",  $( '#file' )[0].files[0] );
var formData = new FormData(myForm);
       $.ajax({
            type: "POST",
            url: '{{URL::route("shopaholic.updateuserprofile")}}',
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
            }
          });
        });

  
@endsection
