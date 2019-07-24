@extends('frontend.layouts.main')
@section('content')
<div class="page-title change_password_page">
   <div class="container">
     <div class="column">
       <h1>Password Recovery</h1>
     </div>
     <div class="column">
       <ul class="breadcrumbs">
         <li><a href="index.html">Home</a>
         </li>
         <li class="separator">&nbsp;</li>
         <li><a href="account-orders.html">Account</a>
         </li>
         <li class="separator">&nbsp;</li>
         <li>Password Recovery</li>
       </ul>
     </div>
   </div>
 </div>


<div class="container padding-bottom-3x mb-2" style="margin-top:4%">
   <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 change_password_row">

            <h2>Password Reset</h2>
            
            <form method="POST"  class="card mt-4" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </div>
            </form>

        </div>
    </div>
</div>

@endsection
