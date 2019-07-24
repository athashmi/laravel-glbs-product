@extends('layouts.app')
@section('content')
    <form class="md-float-material form-material" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="text-center">
            <img src="{{asset('images/logo.png')}}" alt="logo.png">
        </div>
        <div class="auth-box card">
            <div class="card-block">
                <div class="row m-b-20">
                    <div class="col-md-12">
                        <h3 class="text-center txt-primary">Sign up</h3>
                    </div>
                </div>
                <div class="form-group form-primary">
                    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('name') }}" placeholder="Choose Username">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group form-primary">
                    <input type="text" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required="" placeholder="Your Email Address">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-primary">
                            <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required="" placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-primary">
                            <input type="password" name="password_confirmation" class="form-control" required="" placeholder="Confirm Password">
                            <span class="form-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="row m-t-25 text-left">
                    <div class="col-md-12">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="checkbox" value="">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span class="text-inverse">I read and accept <a href="#">Terms &amp; Conditions.</a></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="checkbox" value="">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span class="text-inverse">Send me the <a href="#!">Newsletter</a> weekly.</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row m-t-30">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign up now</button>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-10">
                        <p class="text-inverse text-left m-b-0">Thank you.</p>
                        <p class="text-inverse text-left"><a href="index.html"><b class="f-w-600">Back to website</b></a></p>
                    </div>
                    <div class="col-md-2">
                        <img src="../files/assets/images/auth/Logo-small-bottom.png" alt="small-logo.png">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
              