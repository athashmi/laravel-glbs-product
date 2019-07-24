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
           <h2>Forgot your password?</h2>
           <p>Change your password in two easy steps. This helps to keep your new password secure.</p>
           <ol class="list-unstyled">
             <li><span class="text-primary text-medium">1. </span>Fill in your email address below.</li>
             <li><span class="text-primary text-medium">2. </span>We'll email you a reset link.</li>
            
           </ol> 
            
            <form class="card mt-4"  method="POST"  action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                <div class="card-body">
                         
                          @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   <div class="form-group">
                        <label for="email-for-pass">Enter your email address</label>

                         <input type="text"  class="form-control" name="email" value="" placeholder="Your Email Address">
                        @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                        <small class="form-text text-muted">Type in the email address you used when you registered with Unishop. Then we'll email reset link.</small>
                   </div>

                    <p class="f-w-600 text-right">Back to <a href="{{route('login')}}">Login.</a></p>
                </div>
                <div class="card-footer">
                   <button class="btn btn-primary" type="submit">Send Password Reset Link</button>
                 </div>
            </form>

        </div>
    </div>
</div> 

@endsection
