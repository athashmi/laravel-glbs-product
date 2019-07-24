<!DOCTYPE html>
<html lang="en">
<head>
	<title>Global Shopaholics: USA Address & Package Forwarding </title>
	@include('frontend.layouts.head')
</head>
   <body>
        @include('frontend.layouts.body_tags')

        @include('frontend.layouts.mobile-menu')

        @include('frontend.layouts.top_nav')
        
        @include('frontend.layouts.content_template')

        <a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
        <!-- Backdrop-->


        <div class="site-backdrop"></div>
        @include('frontend.layouts.scripts')
        <script>
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            </script>
        @yield('scripts')
	</body>
</html>