@extends('frontend.layouts.main')
@section('content')
<div class="page-title login_page">
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
      <div class="row login_row" style="margin-left:25%;margin-right:25%">
        <div class="col-md-12">

          
          <form  name="form" id="form"  class="login-box" enctype="multipart/form-data" method="POST" action="{{route('login')}}" >
            @csrf
            <input hidden name="user_type" value="2">
            <div class="row margin-bottom-1x">
              <div class="col-xl-4 col-md-6 col-sm-4"><a class="btn btn-sm btn-block facebook-btn" href="{{url('auth/facebook')}}"><i class="socicon-facebook"></i>&nbsp;Facebook login</a></div>
              <div class="col-xl-4 col-md-6 col-sm-4"><a class="btn btn-sm btn-block twitter-btn" href="{{url('auth/twitter')}}"><i class="socicon-twitter"></i>&nbsp;Twitter login</a></div>
              <div class="col-xl-4 col-md-6 col-sm-4"><a class="btn btn-sm btn-block google-btn" href="{{url('auth/googleplus')}}"><i class="socicon-googleplus"></i>&nbsp;Google+ login</a></div>
            </div>
            <h4 class="margin-bottom-1x">Or using form below</h4>
            <div class="form-group input-group">
              <input  id="user" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="" placeholder="Shopaholic Email" required>
              
              <span class="input-group-addon"><i class="icon-mail"></i></span>
               
            </div>
            <div class="form-group input-group">
              <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Shopaholic Password">
            
              <span class="input-group-addon"><i class="icon-lock"></i></span>

            </div>
            <div class="d-flex flex-wrap justify-content-between padding-bottom-1x">
              <label class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked><span class="custom-control-indicator"></span><span class="custom-control-description">Remember me</span>
              </label><a class="navi-link" href="{{route('password.request')}}">Forgot password?</a>
            </div>
            @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
            <div class="text-center text-sm-right">
              <button class="btn btn-primary margin-bottom-none" type="submit">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
@endsection
