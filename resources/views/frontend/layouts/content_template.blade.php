        <div class="offcanvas-wrapper" style="">
        <?php if(Session::has('error')){ ?>
        <div class="alert alert-info alert-dismissible fade show text-center margin-bottom-1x">
        <span class="alert-close" data-dismiss="alert"></span><i class="icon-help"></i>&nbsp;&nbsp;
        <strong>Alert :</strong>{{Session::get('error')}}</div>
        <?php } ?>
        
            			@section('content')
						@show
					
        @include('frontend.layouts.footer')
        </div>