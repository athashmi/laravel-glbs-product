<!DOCTYPE html>
<html lang="en">

<head>
	<title>Global Shopaholics</title>

	@include('layout.head')

</head>


	<body id="app">

		@include('layout.pre-loader')

		<div id="pcoded" class="pcoded">
        	<div class="pcoded-overlay-box"></div>
        		<div class="pcoded-container navbar-wrapper">

        			@include('layout.top_nav')

        			@include('layout.chat_right_slide')

        			<div class="pcoded-main-container">
                		<div class="pcoded-wrapper">
                            @role('shopaholic')
                                @if(Auth::user()->email_verified_at != null)
                    			 @include('layout.left_navbar_shopaholic')
                                @endif
                            @endrole

                             @role(['owner','admin','employee'])
                               
                                 @include('layout.left_navbar_back-end')
                               
                            @endrole

                            
                			@include('layout.content_template')

               			</div>
                	</div>
        		</div>
        	</div>

        	@include('layout.script')
            <script>
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            </script>
        	
	</body>

</html>