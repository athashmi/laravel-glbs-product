@extends('layouts.app')
@section('content')
    <form class="md-float-material form-material" method="POST" action="{{ route('login') }}">
         @csrf
        <div class="text-center">
            <img src="https://www.globalshopaholics.com/Front/img/logo/logo.png" class="img-responsive col-md-2" alt="logo.png">
        </div>
        <div class="auth-box card">
            <div class="card-block">
                <div class="row m-b-20">
                    <div class="col-md-12">
                        <h3 class="text-center">Sign In</h3>
                    </div>
                </div>
                <div class="form-group form-primary">
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Your Email Address"> 
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif 
                </div>
                <div class="form-group form-primary">
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"  placeholder="Password">
                        @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                </div>
                <div class="row m-t-25 text-left">
                    <div class="col-12">
                        <div class="checkbox-fade fade-in-primary d-">
                            <label>
                                <input type="checkbox" value="">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span class="text-inverse">Remember me</span>
                            </label>
                        </div>
                        <div class="forgot-phone text-right f-right">
                            <a href="{{route('password.request')}}" class="text-right f-w-600"> Forgot Password?</a>
                        </div>
                    </div>
                </div>
                <div class="row m-t-30">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-8">
                       {{--  <p class="text-inverse text-left m-b-0">Thank you.</p> --}}
                       {{--  <p class="text-inverse text-left"><a href="index.html"><b class="f-w-600">Back to website</b></a></p> --}}
                    </div>
                    <div class="col-md-4">
                        {{-- <a href="{{route('register')}}">Register Now</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
                    
