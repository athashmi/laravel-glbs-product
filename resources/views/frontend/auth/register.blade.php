@extends('frontend.layouts.main')
@section('content')
<div class="page-title register_page">
      <div class="container">
        <div class="column">
          <h1>Login / Register Account</h1>
        </div>
        <div class="column">
          <ul class="breadcrumbs">
            <li><a href="index.html">Home</a>
            </li>
            <li class="separator">&nbsp;</li>
            <li><a href="account-orders.html">Account</a>
            </li>
            <li class="separator">&nbsp;</li>
            <li>Login / Register</li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-2" style="margin-top:4%">
      <div class="row register_row" style="margin-left:20%;margin-right:20%">
        <div class="col-md-12 register-box">
          <div class="padding-top-3x hidden-md-up"></div>
          <h3 class="margin-bottom-1x">No Account? Register</h3>
          <p>Registration takes less than a minute but gives you full control over your orders.</p>
          <form class="row" method="post" action="{{ route('register') }}" id="form_register"> 
            @csrf
            <div class="col-sm-6">
              <div class="form-group">
                <label for="reg-fn">First Name</label>
                <input  type="text" class="form-control" name="first_name" placeholder="Your First Name" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="reg-ln">Last Name</label>
                <input type="text" class="form-control" name="last_name" placeholder="Your Last Name" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="reg-email">E-mail Address</label>
                <input type="text" class="form-control" name="email" placeholder="Your email" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="reg-phone">Phone Number</label>
                <input class="form-control" type="text" name="phone" id="reg-phone" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="reg-pass">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Your password" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="reg-pass-confirm">Confirm Password</label>
                <input class="form-control" type="password" name="password_confirmation" id="reg-pass-confirm" required>
              </div>
            </div>
            <span id="error_msgs" class="col-12"></span>
            <input type="hidden" class="form-control" name="user_type" value="2">
            <div class="col-12 text-center text-sm-right">
              <button class="btn btn-primary margin-bottom-none btn_register" type="submit">Register</button>
            </div>
          </form>
        </div>
      </div>
    </div>





@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
  $("#form_register").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "",
        data:$("#form_register").serialize(),
        dataType: "JSON",
        success: function (response) {
          console.log(response);
        if(response.status == 1)
        {
           window.location.href = response.url;
        }
        },
        error: function(jqXHR, exception){
          if(jqXHR.status == 422)
          {
            var html_error = '<div  class="alert " style="background-color:#e67070; color:white;"><ul>';
          $.each(jqXHR.responseJSON.errors, function (key, value)
          {
              html_error +='<li class="padding-top-10">'+value+'</li>';
          })
           html_error += "</ul></div>";
        $('#error_msgs').html(html_error);
        setTimeout(function(){
              $("#error_msgs").html('');
          },12000);
          }
          
        }
      })

  })
});
</script>
@endsection
