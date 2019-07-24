 
@php
      $master_view = 'frontend.layouts.main';
      @endphp
@extends($master_view)
@section('content')

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div> --}}

 <section class="login offline-404 p-fixed d-flex text-center">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- auth body start -->
                    <div class="auth-body">
                        <form>

                            <h2>{{ __('A fresh verification link has been sent to your email address.') }}</h2>
                            <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" style="    color: #01a9ac;">{{ __('click here to request another') }}</a>.
                </div>
                        </form>
                    </div>
                    <!-- auth body end -->
                </div>
            </div>
        </div>
    </section>
@endsection
