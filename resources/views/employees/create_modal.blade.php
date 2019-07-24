<div class="modal  fade" id="create_permission_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel">Add Employee</h4>
         <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
     <form action="javascript:;" method="post" class="j-pro form-employee-add" id="" enctype="multipart/form-data" novalidate style="border:none; background-color: white;">
      <div class="modal-body">
            <div class="j-wrapper padd-0" >
                    <div class="j-content">
                        <!-- start name -->
                        <div class="j-row">
                        <div class="j-span6 j-unit">
                            <label class="j-label">First Name</label>
                            <div class="j-input">
                                <label class="j-icon-left" for="first_name">
                                    <i class="icofont icofont-ui-user"></i>
                                </label>
                                <input type="text" id="e_first_name" name="e_first_name" placeholder="">
                            </div>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Last Name</label>
                            <div class="j-input">
                                <label class="j-icon-left" for="last_name">
                                    <i class="icofont icofont-ui-user"></i>
                                </label>
                                <input type="text" id="e_last_name" name="e_last_name" placeholder="">
                            </div>
                        </div>
                        <div class="j-span6 j-unit">
                             <label class="j-label">Email</label>
                            <div class="j-input">
                                <label class="j-icon-left" for="email">
                                    <i class="icofont icofont-envelope"></i>
                                </label>
                                <input type="email" placeholder="" id="e_email" name="e_email">
                            </div>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Phone No</label>
                            <div class="j-input">
                                <label class="j-icon-left" for="phone">
                                    <i class="icofont icofont-phone"></i>
                                </label>
                                <input type="text" placeholder="" id="e_phone" name="e_phone">
                            </div>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Password</label>
                            <div class="j-input">
                                <label class="j-icon-left" for="email">
                                    <i class="icofont icofont-lock"></i>
                                </label>
                                <input type="password" placeholder="" id="e_password" name="e_password">
                            </div>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Re-Password</label>
                            <div class="j-input">
                                <label class="j-icon-left" for="email">
                                    <i class="icofont icofont-lock"></i>
                                </label>
                                <input type="password" placeholder="" id="r_e_password" name="password_confirmation">
                            </div>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Managed By</label>
                            <label class="j-input">
                                <select name="managed_by">
                                    <option value="" selected>Select managed by</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                </select>
                                <i></i>
                            </label>
                        </div>
                          <div class="j-span6 j-unit">
                            <label class="j-label">Role/Position</label>
                            <label class="j-input">
                                <select name="role">
                                    <option value="" selected>Select Role/Position</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                <i></i>
                            </label>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Date of Birth</label>
                                <div class="j-input">
                                <label class="j-icon-left" for="dob_date">
                                <i class="icofont icofont-ui-calendar"></i>
                                </label>
                                <input type="text" class="date" id="dob_date"  name="dob_date" readonly="">
                        </div>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Date of Hiring</label>
                            <div class="j-input">
                                <label class="j-icon-left" for="hire_date">
                                    <i class="icofont icofont-ui-calendar"></i>
                                  </label>
                                    <input type="text"  class="date" id="hire_date" name="hire_date" readonly="">
                            </div>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Pay Type</label>
                            <label class="j-input">
                                <select name="pay_type">
                                    <option value="" selected>Pay type</option>
                                    <option value="Australia">Hourly</option>
                                    <option value="Austria">monthly</option>
                                    <option value="Austria">contract</option>
                                </select>
                                <i></i>
                            </label>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Pay Rate</label>
                                <div class="j-input">
                                    <label class="j-icon-left" for="phone">
                                        <i class="icofont icofont-phone"></i>
                                    </label>
                                    <input type="text" placeholder="" id="pay_rate" name="pay_rate">
                                </div>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Vocation yearly</label>
                            <label class="j-input">
                                <select name="vocation_yearly">
                                    <option value="" selected>Vocation Yearly</option>
                                    <option value="Australia">0</option>
                                    <option value="Austria">1</option>
                                    <option value="Austria">2</option>
                                </select>
                                <i></i>
                            </label>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Sick leave</label>
                            <label class="j-input">
                                <select name="sick_leave">
                                    <option value="" selected>Sick leave</option>
                                    <option value="Australia">0</option>
                                    <option value="Austria">1</option>
                                    <option value="Austria">2</option>
                                </select>
                                <i></i>
                            </label>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Emergency Contact Name</label>
                                <div class="j-input">
                                    <label class="j-icon-left" for="email">
                                        <i class="icofont icofont-ui-user"></i>
                                    </label>
                                    <input type="text" placeholder="" id="emergency_name" name="emergency_name">
                                </div>
                        </div>
                        <div class="j-span6 j-unit">
                             <label class="j-label">Emergency Contact No</label>
                        <div class="j-input">
                                    <label class="j-icon-left" for="email">
                                        <i class="icofont icofont-phone"></i>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Emergency Contact Number" id="emergency_no" name="emergency_no">
                        </div>
                        </div>
                        <div class="j-span6 j-unit">
                            <label class="j-label">Image Upload</label>
                                <div class="j-input j-append-small-btn">
                                    <div class="j-file-button">
                                        Browse
                                        <input type="file" name="fileImage" onchange="document.getElementById('file1_input').value = this.value;">
                                    </div>
                                    <input type="text" id="file1_input" readonly="" placeholder="add your CV">
                                    <span class="j-hint">Only: doc / docx / xls /xlsx, less 1Mb</span>
                                </div>
                        </div>
                        </div>
                        <div class="j-unit">
                            <label class="j-label">Home Address</label>
                            <label class="j-input j-select">
                                <textarea name="e_address" id="e_address" placeholder="Home Address"></textarea>
                                <i></i>
                            </label>
                        </div>
                        <div class="j-response"></div>
                    </div>
            </div>
            <span id="error_msgs1"></span>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-employee-add">Create</button>
      </div>
       </form>
    </div>
  </div>
</div>



@section('document_ready')
@parent
$("#btn-employee-add").on("click",function(){
    $.ajax({
          type: "POST",
          url: "{{route('employee.store')}}",
          data: $('.form-employee-add').serialize(),
          dataType: "JSON",
          success: function (response) {
          if(response.status == 1)
          {
            responseMsg("update","Information has been inserted successfully...");
              $('#create_permission_model').modal('hide');
              $('.datatable').DataTable().draw();
          }
          },
          error: function(jqXHR, exception){

            var html_error = '<div  class="alert " style="background-color:#e67070; color:white;"><ul>';
            $.each(jqXHR.responseJSON.errors, function (key, value)
            {
                html_error +='<li class="padding-top-10">'+value+'</li>';
            })
             html_error += "</ul></div>";
          $('#error_msgs1').html(html_error);
          setTimeout(function(){
                $("#error_msgs1").html('');
          },12000);
        }
      });
});
@endsection